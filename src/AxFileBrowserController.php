<?php

namespace AspectoX\AxFileBrowser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use AspectoX\AxFileBrowser\FileMetadata;

class AxFileBrowserController extends Controller
{
    protected string $uploadsPath;
    protected string $rootName = 'uploads';

    public function __construct()
    {
        $folder            = config('ax-filebrowser.uploads_folder', 'uploads');
        $this->uploadsPath = public_path($folder);
        $rootName          = config('ax-filebrowser.root_name', '');
        $this->rootName    = $rootName ?: basename($this->uploadsPath);
    }

    // ─── Vista principal ───────────────────────────────────────────────────────

    public function index(Request $request)
    {
        $currentFolder = $this->sanitizePath($request->get('folder'));
        $fullPath      = $this->uploadsPath . ($currentFolder ? '/' . $currentFolder : '');

        if (!File::exists($this->uploadsPath)) {
            File::makeDirectory($this->uploadsPath, 0755, true);
        }

        if (!File::exists($fullPath)) {
            abort(404, __('ax-filebrowser.folder_not_found'));
        }

        // Subcarpetas del nivel actual
        $folders    = collect(File::directories($fullPath))->map(fn($p) => basename($p))->sort()->values();
        $allFolders = $this->buildFolderTree($this->uploadsPath, '', 0);
        $imgExts    = ['jpg','jpeg','png','gif','webp','avif','svg'];

        // 1. Archivos físicos del disco
        $diskFiles = collect(File::files($fullPath))
            ->map(function($file) use ($currentFolder, $imgExts) {
                $relativePath = ($currentFolder ? $currentFolder . '/' : '') . $file->getFilename();
                $metadata     = FileMetadata::where('file_path', 'uploads/' . $relativePath)->first();
                $ext          = strtolower($file->getExtension());
                $dimensions   = null;
                if (in_array($ext, $imgExts)) {
                    $size = @getimagesize($file->getPathname());
                    if ($size) $dimensions = $size[0] . ' × ' . $size[1];
                }
                return [
                    'name'        => $file->getFilename(),
                    'path'        => $relativePath,
                    'size'        => $file->getSize(),
                    'sort_date'   => $file->getMTime(),
                    'extension'   => $ext,
                    'dimensions'  => $dimensions,
                    'metadata_id' => $metadata?->id,
                    'is_external' => false,
                ];
            });

        // 2. Links externos de la DB para esta carpeta
        $externalLinks = FileMetadata::where('is_external', true)
            ->where('folder', $currentFolder)
            ->get()
            ->map(fn($m) => [
                'name'        => $m->original_name,
                'path'        => $m->file_path,
                'size'        => 0,
                'sort_date'   => $m->created_at->timestamp,
                'extension'   => '',
                'dimensions'  => null,
                'metadata_id' => $m->id,
                'is_external' => true,
            ]);

        // 3. Mezclar y ordenar por fecha desc
        $files = $diskFiles->merge($externalLinks)
            ->sortByDesc('sort_date')
            ->values();

        $breadcrumb      = $this->buildBreadcrumb($currentFolder);
        $isGalleryFolder = $diskFiles->count() > 0
            && $diskFiles->every(fn($f) => in_array($f['extension'], $imgExts));
        $rootName        = $this->rootName;

        return view('ax-filebrowser.index', compact(
            'folders', 'allFolders', 'files', 'currentFolder', 'breadcrumb', 'isGalleryFolder', 'rootName'
        ));
    }

    // ─── Crear carpeta ─────────────────────────────────────────────────────────

    public function folderCreate(Request $request)
    {
        $currentFolder = $this->sanitizePath($request->get('folder'));
        return view('ax-filebrowser.folder-create', compact('currentFolder'));
    }

    public function folderStore(Request $request)
    {
        $request->validate([
            'folder_name'    => 'required|string|max:100|regex:/^[a-zA-Z0-9_\-]+$/',
            'current_folder' => 'nullable|string',
        ]);

        $currentFolder = $this->sanitizePath($request->input('current_folder'));
        $newFolderName = trim($request->input('folder_name'));
        $newPath       = $this->uploadsPath . ($currentFolder ? '/' . $currentFolder : '') . '/' . $newFolderName;

        if (File::exists($newPath)) {
            return back()->withErrors(['folder_name' => __('ax-filebrowser.folder_exists')]);
        }

        File::makeDirectory($newPath, 0755, true);

        return redirect()->route('ax.index', ['folder' => $currentFolder])
            ->with('success', __('ax-filebrowser.folder_created', ['name' => $newFolderName]));
    }

    // ─── Renombrar carpeta ─────────────────────────────────────────────────────

    public function folderRename(Request $request)
    {
        $request->validate([
            'folder_path' => 'required|string',
            'new_name'    => 'required|string|max:100|regex:/^[a-zA-Z0-9_\-]+$/',
        ]);

        $folderPath = $this->sanitizePath($request->input('folder_path'));
        $newName    = trim($request->input('new_name'));
        $fullPath   = $this->uploadsPath . '/' . $folderPath;
        $parentPath = dirname($fullPath);
        $newPath    = $parentPath . '/' . $newName;

        if (!File::exists($fullPath)) {
            return back()->withErrors(['folder_path' => __('ax-filebrowser.folder_not_found')]);
        }

        if (File::exists($newPath)) {
            return back()->withErrors(['new_name' => __('ax-filebrowser.folder_exists')]);
        }

        File::moveDirectory($fullPath, $newPath);

        $parentFolder = $this->sanitizePath(dirname($folderPath));
        return redirect()->route('ax.index', ['folder' => $parentFolder === '.' ? '' : $parentFolder])
            ->with('success', __('ax-filebrowser.folder_renamed', ['name' => $newName]));
    }

    // ─── Eliminar carpeta ──────────────────────────────────────────────────────

    public function folderDelete(Request $request)
    {
        $request->validate([
            'folder_path' => 'required|string',
            'force'       => 'nullable|in:1,true',
        ]);

        $folderPath = $this->sanitizePath($request->input('folder_path'));
        $fullPath   = $this->uploadsPath . '/' . $folderPath;
        $isJson     = $request->expectsJson() || $request->ajax();

        if (!File::exists($fullPath)) {
            return $isJson
                ? response()->json(['ok' => false, 'error' => __('ax-filebrowser.folder_not_found')])
                : back()->withErrors(['folder_path' => 'Carpeta no encontrada.']);
        }

        $hasContent = count(File::allFiles($fullPath)) > 0 || count(File::directories($fullPath)) > 0;
        $force      = in_array($request->input('force'), ['1', 'true', true]);

        if ($hasContent && !$force) {
            if ($isJson) {
                return response()->json(['ok' => false, 'has_content' => true, 'folder_path' => $folderPath]);
            }
            $parentFolder = $this->sanitizePath(dirname($folderPath));
            return redirect()->route('ax.index', ['folder' => $parentFolder === '.' ? '' : $parentFolder])
                ->with('confirm_delete_folder', $folderPath);
        }

        // Borrar del disco
        File::deleteDirectory($fullPath);

        // Limpiar DB — archivos físicos y links externos de esta carpeta y subcarpetas
        FileMetadata::where('folder', $folderPath)
            ->orWhere('folder', 'like', $folderPath . '/%')
            ->orWhere('file_path', 'like', 'uploads/' . $folderPath . '/%')
            ->delete();

        if ($isJson) {
            return response()->json(['ok' => true]);
        }

        $parentFolder = $this->sanitizePath(dirname($folderPath));
        return redirect()->route('ax.index', ['folder' => $parentFolder === '.' ? '' : $parentFolder])
            ->with('success', __('ax-filebrowser.folder_deleted'));
    }

    // ─── Subir archivo + metadata ─────────────────────────────────────────────

    public function upload(Request $request)
    {
        $request->validate([
            'file'           => 'required_without:file_url|nullable|file|max:102400',
            'file_name'      => 'required_without:file|nullable|string|max:255',
            'current_folder' => 'nullable|string',
            'autor'          => 'nullable|string|max:255',
            'credito_url'    => 'nullable|url|max:500',
            'fecha_archivo'  => 'nullable|date',
            'epigrafe'       => 'nullable|string',
            'tags'           => 'nullable|string|max:500',
        ]);

        $currentFolder = $this->sanitizePath($request->input('current_folder'));
        $destPath      = $this->uploadsPath . ($currentFolder ? '/' . $currentFolder : '');

        if ($request->hasFile('file')) {
            // Subida de archivo físico
            $file         = $request->file('file');
            $originalName = $file->getClientOriginalName();
            $extension    = strtolower($file->getClientOriginalExtension());
            $file->move($destPath, $originalName);
        } else {
            // Link URL — no se descarga nada, solo se guarda la referencia
            $fileUrl      = $request->input('file_url');
            $originalName = $request->input('file_name') ?: $fileUrl;
            $extension    = strtolower(pathinfo(parse_url($fileUrl, PHP_URL_PATH), PATHINFO_EXTENSION));
        }

        // Detectar tipo
        $type = match(true) {
            in_array($extension, ['jpg','jpeg','png','gif','webp','svg','avif']) => 'imagen',
            in_array($extension, ['mp4','webm','ogg','mov'])                    => 'video',
            in_array($extension, ['mp3','wav','flac','aac'])                    => 'audio',
            $extension === 'pdf'                                                => 'pdf',
            default                                                             => 'otro',
        };

        $relativePath = $request->hasFile('file')
            ? 'uploads/' . ($currentFolder ? $currentFolder . '/' : '') . $originalName
            : $request->input('file_url');

        $isExternalUrl = !$request->hasFile('file') && $request->input('file_url');

        FileMetadata::create([
            'file_path'     => $relativePath,
            'original_name' => $originalName,
            'folder'        => $currentFolder,
            'type'          => $type,
            'is_external'   => (bool) $isExternalUrl,
            'autor'         => $request->input('autor'),
            'credito_url'   => $request->input('credito_url'),
            'fecha_archivo' => $request->input('fecha_archivo'),
            'epigrafe'      => $request->input('epigrafe'),
            'tags'          => $request->input('tags'),
        ]);

        return redirect()->route('ax.index', ['folder' => $currentFolder])
            ->with('success', __('ax-filebrowser.file_uploaded', ['name' => $originalName]));
    }

    // ─── Subir galería de imágenes ───────────────────────────────────────────

    public function uploadGallery(Request $request)
    {
        $request->validate([
            'gallery_name'   => 'required|string|max:100|regex:/^[a-zA-Z0-9_\-]+$/',
            'files'          => 'required|array|min:1',
            'files.*'        => 'file|max:102400',
            'current_folder' => 'nullable|string',
            'autor'          => 'nullable|string|max:255',
            'epigrafe'       => 'nullable|string',
            'tags'           => 'nullable|string|max:500',
        ]);

        $currentFolder = $this->sanitizePath($request->input('current_folder'));
        $galleryName   = trim($request->input('gallery_name'));
        $galleryFolder = ($currentFolder ? $currentFolder . '/' : '') . $galleryName;
        $destPath      = $this->uploadsPath . '/' . $galleryFolder;

        if (!File::exists($destPath)) {
            File::makeDirectory($destPath, 0755, true);
        }

        $uploaded = 0;
        foreach ($request->file('files') as $file) {
            $originalName = $file->getClientOriginalName();
            $extension    = strtolower($file->getClientOriginalExtension());
            $file->move($destPath, $originalName);

            $relativePath = 'uploads/' . $galleryFolder . '/' . $originalName;
            FileMetadata::create([
                'file_path'     => $relativePath,
                'original_name' => $originalName,
                'type'          => 'imagen',
                'autor'         => $request->input('autor'),
                'epigrafe'      => $request->input('epigrafe'),
                'tags'          => $request->input('tags'),
            ]);
            $uploaded++;
        }

        return redirect()->route('ax.index', ['folder' => $galleryFolder])
            ->with('success', __('ax-filebrowser.gallery_uploaded', ['count' => $uploaded, 'name' => $galleryName]));
    }

    // ─── Eliminar archivo por path ────────────────────────────────────────────

    public function fileDeleteByPath(Request $request)
    {
        $request->validate([
            'file_path'      => 'required|string',
            'current_folder' => 'nullable|string',
        ]);

        $filePath      = $request->input('file_path');
        $currentFolder = $this->sanitizePath($request->input('current_folder'));
        $isJson        = $request->expectsJson() || $request->ajax();

        // Link externo (URL) — solo borrar de DB
        if (str_starts_with($filePath, 'http')) {
            FileMetadata::where('file_path', $filePath)->delete();
        } else {
            $sanitized = $this->sanitizePath($filePath);
            $fullPath  = $this->uploadsPath . '/' . $sanitized;
            if (File::exists($fullPath)) {
                File::delete($fullPath);
            }
            FileMetadata::where('file_path', 'uploads/' . $sanitized)
                ->orWhere('file_path', $filePath)
                ->delete();
        }

        if ($isJson) {
            return response()->json(['ok' => true]);
        }

        return redirect()->route('ax.index', ['folder' => $currentFolder])
            ->with('success', __('ax-filebrowser.file_deleted'));
    }

    // ─── Eliminar archivo por id (metadata) ──────────────────────────────────

    public function fileDelete(Request $request, $id)
    {
        $metadata = FileMetadata::findOrFail($id);
        $fullPath = public_path($metadata->file_path);

        if (File::exists($fullPath)) {
            File::delete($fullPath);
        }

        $metadata->delete();

        return back()->with('success', __('ax-filebrowser.file_deleted'));
    }

    // ─── Rename ───────────────────────────────────────────────────────────────

    public function rename(Request $request)
    {
        $request->validate([
            'old_path' => 'required|string',
            'new_name' => 'required|string|max:255',
            'type'     => 'required|in:file,folder',
        ]);

        $oldPath  = $this->sanitizePath($request->input('old_path'));
        $newName  = $request->input('new_name');
        $type     = $request->input('type');
        $fullOld  = $this->uploadsPath . '/' . $oldPath;
        $dir      = dirname($fullOld);
        $fullNew  = $dir . '/' . $newName;
        $newPath  = ($dir === $this->uploadsPath)
            ? $newName
            : $this->sanitizePath(substr($dir, strlen($this->uploadsPath) + 1)) . '/' . $newName;

        if (!File::exists($fullOld)) {
            return response()->json(['ok' => false, 'error' => __('ax-filebrowser.not_found')]);
        }
        if (File::exists($fullNew)) {
            return response()->json(['ok' => false, 'error' => __('ax-filebrowser.name_exists')]);
        }

        if ($type === 'folder') {
            File::moveDirectory($fullOld, $fullNew);
            // Actualizar DB
            FileMetadata::where('folder', $oldPath)
                ->orWhere('folder', 'like', $oldPath . '/%')
                ->get()
                ->each(function($m) use ($oldPath, $newPath) {
                    $m->folder    = str_replace($oldPath, $newPath, $m->folder);
                    $m->file_path = str_replace('uploads/' . $oldPath, 'uploads/' . $newPath, $m->file_path);
                    $m->save();
                });
        } else {
            File::move($fullOld, $fullNew);
            FileMetadata::where('file_path', 'uploads/' . $oldPath)
                ->update(['file_path' => 'uploads/' . $newPath, 'original_name' => $newName]);
        }

        return response()->json(['ok' => true, 'new_path' => $newPath, 'new_name' => $newName]);
    }

    // ─── Move ─────────────────────────────────────────────────────────────────

    public function move(Request $request)
    {
        $request->validate([
            'source_path' => 'required|string',
            'dest_folder' => 'required|string',
            'type'        => 'required|in:file,folder',
        ]);

        $sourcePath = $this->sanitizePath($request->input('source_path'));
        $destFolder = $this->sanitizePath($request->input('dest_folder'));
        $type       = $request->input('type');
        $name       = basename($sourcePath);
        $fullSource = $this->uploadsPath . '/' . $sourcePath;
        $fullDest   = $this->uploadsPath . ($destFolder ? '/' . $destFolder : '') . '/' . $name;
        $newPath    = ($destFolder ? $destFolder . '/' : '') . $name;

        if (!File::exists($fullSource)) {
            return response()->json(['ok' => false, 'error' => __('ax-filebrowser.not_found')]);
        }
        if (File::exists($fullDest)) {
            return response()->json(['ok' => false, 'error' => __('ax-filebrowser.name_exists')]);
        }

        if ($type === 'folder') {
            File::moveDirectory($fullSource, $fullDest);
            FileMetadata::where('folder', $sourcePath)
                ->orWhere('folder', 'like', $sourcePath . '/%')
                ->get()
                ->each(function($m) use ($sourcePath, $newPath) {
                    $m->folder    = str_replace($sourcePath, $newPath, $m->folder);
                    $m->file_path = str_replace('uploads/' . $sourcePath, 'uploads/' . $newPath, $m->file_path);
                    $m->save();
                });
        } else {
            File::move($fullSource, $fullDest);
            FileMetadata::where('file_path', 'uploads/' . $sourcePath)
                ->update(['file_path' => 'uploads/' . $newPath, 'folder' => $destFolder]);
        }

        return response()->json(['ok' => true]);
    }

    // ─── Copy ─────────────────────────────────────────────────────────────────

    public function copy(Request $request)
    {
        $request->validate([
            'source_path' => 'required|string',
            'dest_folder' => 'required|string',
            'type'        => 'required|in:file,folder',
        ]);

        $sourcePath = $this->sanitizePath($request->input('source_path'));
        $destFolder = $this->sanitizePath($request->input('dest_folder'));
        $type       = $request->input('type');
        $name       = basename($sourcePath);
        $fullSource = $this->uploadsPath . '/' . $sourcePath;
        $fullDest   = $this->uploadsPath . ($destFolder ? '/' . $destFolder : '') . '/' . $name;
        $newPath    = ($destFolder ? $destFolder . '/' : '') . $name;

        if (!File::exists($fullSource)) {
            return response()->json(['ok' => false, 'error' => __('ax-filebrowser.not_found')]);
        }

        // Si ya existe en destino, agregar sufijo
        if (File::exists($fullDest)) {
            $ext      = pathinfo($name, PATHINFO_EXTENSION);
            $base     = pathinfo($name, PATHINFO_FILENAME);
            $name     = $base . '_copy' . ($ext ? '.' . $ext : '');
            $fullDest = $this->uploadsPath . ($destFolder ? '/' . $destFolder : '') . '/' . $name;
            $newPath  = ($destFolder ? $destFolder . '/' : '') . $name;
        }

        if ($type === 'folder') {
            File::copyDirectory($fullSource, $fullDest);
        } else {
            File::copy($fullSource, $fullDest);
            $meta = FileMetadata::where('file_path', 'uploads/' . $sourcePath)->first();
            if ($meta) {
                FileMetadata::create(array_merge(
                    $meta->toArray(),
                    ['id' => null, 'file_path' => 'uploads/' . $newPath, 'folder' => $destFolder, 'original_name' => $name]
                ));
            }
        }

        return response()->json(['ok' => true, 'new_path' => $newPath]);
    }

    // ─── Metadata fetch/save ──────────────────────────────────────────────────

    public function metadataFetch(Request $request)
    {
        $path     = $request->get('path', '');
        $isExt    = str_starts_with($path, 'http');
        $dbPath   = $isExt ? $path : 'uploads/' . $path;
        $metadata = FileMetadata::where('file_path', $dbPath)->first();

        // Datos del archivo físico
        $fileData = [];
        if (!$isExt) {
            $fullPath = $this->uploadsPath . '/' . $path;
            if (File::exists($fullPath)) {
                $fileData = [
                    'size'          => File::size($fullPath),
                    'mtime'         => File::lastModified($fullPath),
                    'extension'     => strtolower(pathinfo($path, PATHINFO_EXTENSION)),
                ];
                $imgExts = ['jpg','jpeg','png','gif','webp','avif'];
                if (in_array($fileData['extension'], $imgExts)) {
                    $size = @getimagesize($fullPath);
                    if ($size) {
                        $fileData['width']  = $size[0];
                        $fileData['height'] = $size[1];
                    }
                }
            }
        }

        return response()->json([
            'ok'       => true,
            'metadata' => $metadata,
            'file'     => $fileData,
        ]);
    }

    public function metadataSave(Request $request)
    {
        $request->validate([
            'file_path'    => 'required|string',
            'original_name'=> 'nullable|string|max:255',
            'autor'        => 'nullable|string|max:255',
            'credito_url'  => 'nullable|string|max:500',
            'epigrafe'     => 'nullable|string',
            'tags'         => 'nullable|string',
            'fecha_archivo'=> 'nullable|date',
        ]);

        $filePath = $request->input('file_path');
        $metadata = FileMetadata::where('file_path', $filePath)->first();

        if (!$metadata) {
            $metadata = new FileMetadata();
            $metadata->file_path     = $filePath;
            $metadata->original_name = basename($filePath);
            $metadata->folder        = dirname($filePath) === 'uploads' ? '' : str_replace('uploads/', '', dirname($filePath));
            $metadata->type          = 'otro';
        }

        $metadata->fill($request->only(['original_name','autor','credito_url','epigrafe','tags','fecha_archivo']));
        $metadata->save();

        return response()->json(['ok' => true, 'metadata' => $metadata]);
    }

    // ─── Guardar imagen editada ───────────────────────────────────────────────

    public function imageSave(Request $request)
    {
        $request->validate([
            'image'     => 'required|string',
            'file_path' => 'required|string',
            'overwrite' => 'boolean',
            'format'    => 'required|string',
        ]);

        $dataUrl   = $request->input('image');
        $filePath  = $this->sanitizePath($request->input('file_path'));
        $overwrite = $request->boolean('overwrite');
        $format    = $request->input('format');

        // Decodificar base64
        $parts = explode(',', $dataUrl, 2);
        if (count($parts) !== 2) {
            return response()->json(['ok' => false, 'error' => __('ax-filebrowser.invalid_image_data')]);
        }
        $imageData = base64_decode($parts[1]);

        $ext = match($format) {
            'image/jpeg' => 'jpg',
            'image/png'  => 'png',
            'image/webp' => 'webp',
            default      => 'jpg',
        };

        if ($overwrite) {
            $savePath = public_path($filePath);
        } else {
            $dir      = dirname(public_path('uploads/' . $filePath));
            $base     = pathinfo($filePath, PATHINFO_FILENAME);
            $savePath = $dir . '/' . $base . '_edited.' . $ext;
        }

        file_put_contents($savePath, $imageData);

        return response()->json(['ok' => true, 'path' => $savePath]);
    }

    // ─── Disk usage ───────────────────────────────────────────────────────────

    public function diskUsage()
    {
        $bytes = 0;
        foreach (File::allFiles($this->uploadsPath) as $file) {
            $bytes += $file->getSize();
        }

        $total   = disk_total_space($this->uploadsPath);
        $free    = disk_free_space($this->uploadsPath);
        $used    = $total - $free;
        $percent = $total > 0 ? round(($used / $total) * 100) : 0;

        $fmt = function($b) {
            if ($b >= 1073741824) return round($b / 1073741824, 1) . ' GB';
            if ($b >= 1048576)    return round($b / 1048576, 1) . ' MB';
            return round($b / 1024, 1) . ' KB';
        };

        return response()->json([
            'label'   => $fmt($used) . ' de ' . $fmt($total) . ' usados',
            'percent' => $percent,
            'uploads' => $fmt($bytes),
        ]);
    }

    // ─── Buscador ─────────────────────────────────────────────────────────────

    public function search(Request $request)
    {
        $query  = $request->get('q', '');
        $type   = $request->get('type', '');
        $folder = $request->get('folder', '');
        $autor  = $request->get('autor', '');

        $results = FileMetadata::query()
            ->when($query,  fn($q) => $q->where('original_name', 'like', "%{$query}%"))
            ->when($type,   fn($q) => $q->where('type', $type))
            ->when($folder, fn($q) => $q->where('file_path', 'like', "%{$folder}%"))
            ->when($autor,  fn($q) => $q->where('autor', 'like', "%{$autor}%"))
            ->get();

        return view('ax-filebrowser.search', compact('results', 'query', 'type', 'folder', 'autor'));
    }

    // ─── Picker ───────────────────────────────────────────────────────────────

    public function picker(Request $request)
    {
        $callback      = $request->get('callback', 'insertFile');
        $currentFolder = $this->sanitizePath($request->get('folder'));
        $fullPath      = $this->uploadsPath . ($currentFolder ? '/' . $currentFolder : '');

        if (!File::exists($fullPath)) {
            File::makeDirectory($fullPath, 0755, true);
        }

        $folders = collect(File::directories($fullPath))
            ->map(fn($path) => basename($path))
            ->sort()->values();

        $files = collect(File::files($fullPath))
            ->map(fn($file) => [
                'name'      => $file->getFilename(),
                'path'      => 'uploads/' . ($currentFolder ? $currentFolder . '/' : '') . $file->getFilename(),
                'extension' => strtolower($file->getExtension()),
                'size'      => $file->getSize(),
            ])
            ->values();

        $allFolders = $this->buildFolderTree($this->uploadsPath, '', 0);

        $imgExts = ['jpg','jpeg','png','gif','webp','avif','svg'];
        $isGalleryFolder = $files->count() > 0 && $files->every(fn($f) => in_array($f['extension'], $imgExts));

        $rootName = $this->rootName;

        return view('ax-filebrowser.picker', compact('folders', 'allFolders', 'files', 'currentFolder', 'callback', 'isGalleryFolder', 'rootName'));
    }

    // ─── Helpers ──────────────────────────────────────────────────────────────

    protected function sanitizePath(?string $path): string
    {
        if ($path === null) return '';
        $path = str_replace(['..', '\\'], '', $path);
        $path = trim($path, '/');
        return $path;
    }

    protected function buildFolderTree(string $basePath, string $relativePath, int $depth): \Illuminate\Support\Collection
    {
        $result = collect();
        $dirs   = collect(File::directories($basePath))->sort()->values();

        foreach ($dirs as $dir) {
            $name    = basename($dir);
            $path    = $relativePath ? $relativePath . '/' . $name : $name;
            $result->push(['name' => $name, 'path' => $path, 'depth' => $depth]);
            $result = $result->merge($this->buildFolderTree($dir, $path, $depth + 1));
        }

        return $result;
    }

    protected function buildBreadcrumb(string $currentFolder): array
    {
        $breadcrumb = [['name' => $this->rootName, 'path' => '']];

        if ($currentFolder === '') return $breadcrumb;

        $parts       = explode('/', $currentFolder);
        $accumulated = '';

        foreach ($parts as $part) {
            $accumulated  = $accumulated ? $accumulated . '/' . $part : $part;
            $breadcrumb[] = ['name' => $part, 'path' => $accumulated];
        }

        return $breadcrumb;
    }
}