# AX File Browser

A full-featured file manager package for Laravel applications. Browse, upload, organize, and manage files directly from your app with support for metadata, image editing, galleries, and an embeddable file picker.

## Features

- Browse folders and files with list and gallery views
- Upload files or link external URLs
- Create, rename, move, copy, and delete files and folders
- Upload image galleries (multiple files to a new folder in one step)
- File metadata: author, source URL, date, description, tags
- Built-in image editor (crop, rotate, flip, resize, brightness/contrast/saturation, filters)
- File search and filtering by type, extension, author, and size
- Embeddable file picker (for use in CKEditor, TinyMCE, custom inputs, etc.)
- Disk usage stats
- Breadcrumb navigation and sidebar folder tree
- Multilingual: English and Spanish included

## Requirements

- PHP 8.3+
- Laravel 13.x

## Installation

Install via Composer:

```bash
composer require aspectox/ax-filebrowser
```

Laravel will auto-discover the service provider. Then run the migrations:

```bash
php artisan migrate
```

Publish the assets (CSS and JS):

```bash
php artisan vendor:publish --tag=ax-filebrowser-assets
```

## Publishing other resources

Publish only what you need:

```bash
# Config file
php artisan vendor:publish --tag=ax-filebrowser-config

# Blade views (to customize them)
php artisan vendor:publish --tag=ax-filebrowser-views

# Language files
php artisan vendor:publish --tag=ax-filebrowser-lang

# Everything at once (config + assets)
php artisan vendor:publish --tag=ax-filebrowser
```

## Configuration

After publishing the config, edit `config/ax-filebrowser.php`:

```php
return [
    // Root uploads folder, relative to public/
    // Example: 'uploads' → public/uploads
    'uploads_folder' => 'uploads',

    // Label shown in the sidebar and breadcrumb
    // Leave empty to use the folder name automatically
    'root_name' => '',
];
```

## Usage

### File Browser

Navigate to `/ax-filebrowser` in your application. The route is registered automatically.

### File Picker

The picker is designed to be embedded in rich text editors or custom file inputs. Open it via:

```
/ax-filebrowser/picker?callback=myCallbackFunction
```

The `callback` parameter is the name of the JavaScript function that will receive the selected file path.

**Example with a plain input:**

```html
<input type="text" id="file-input" value="">
<button onclick="openPicker()">Browse</button>

<script>
function openPicker() {
    window.open(
        '/ax-filebrowser/picker?callback=onFilePicked',
        'picker',
        'width=1000,height=700'
    );
}

function onFilePicked(path) {
    document.getElementById('file-input').value = path;
}
</script>
```

## Available Routes

| Method | URI | Name | Description |
|--------|-----|------|-------------|
| GET | `/ax-filebrowser` | `ax.index` | Main file browser view |
| GET | `/ax-filebrowser/picker` | `ax.picker` | Embeddable file picker |
| GET | `/ax-filebrowser/search` | `ax.search` | Search files |
| GET | `/ax-filebrowser/disk-usage` | `ax.disk.usage` | Disk usage stats (JSON) |
| POST | `/ax-filebrowser/upload` | `ax.upload` | Upload a file or link a URL |
| POST | `/ax-filebrowser/upload-gallery` | `ax.upload.gallery` | Upload image gallery |
| POST | `/ax-filebrowser/folder/store` | `ax.folder.store` | Create folder |
| POST | `/ax-filebrowser/folder/rename` | `ax.folder.rename` | Rename folder |
| POST | `/ax-filebrowser/folder/delete` | `ax.folder.delete` | Delete folder |
| POST | `/ax-filebrowser/rename` | `ax.rename` | Rename file or folder |
| POST | `/ax-filebrowser/move` | `ax.move` | Move file or folder |
| POST | `/ax-filebrowser/copy` | `ax.copy` | Copy file or folder |
| GET | `/ax-filebrowser/metadata-fetch` | `ax.metadata.fetch` | Get file metadata (JSON) |
| POST | `/ax-filebrowser/metadata-fetch` | `ax.metadata.save` | Save file metadata (JSON) |
| POST | `/ax-filebrowser/image/save` | `ax.image.save` | Save edited image |
| POST | `/ax-filebrowser/delete/{id}` | `ax.file.delete` | Delete file by metadata ID |
| POST | `/ax-filebrowser/delete-by-path` | `ax.file.delete.path` | Delete file by path |

## File Metadata

Each file can store the following metadata:

| Field | Description |
|-------|-------------|
| `autor` | Author or credit |
| `credito_url` | Source URL |
| `fecha_archivo` | File date |
| `epigrafe` | Description / caption |
| `tags` | Comma-separated tags |

## Localization

The package ships with English and Spanish. To add another language, publish the lang files and add a new folder:

```bash
php artisan vendor:publish --tag=ax-filebrowser-lang
```

This creates `lang/vendor/ax-filebrowser/{locale}/ax-filebrowser.php`. Duplicate the `en` file and translate.

## License

MIT — see [LICENSE](LICENSE) for details.
