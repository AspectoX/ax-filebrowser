<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Picker — ax FileBrowser</title>
    <link rel="stylesheet" href="/css/ax-filebrowser.css">
</head>
<body id="ax-filebrowser">

    {{-- ── TOOLBAR ──────────────────────────────────────────────────────────── --}}
    <header id="toolbar" class="toolbar">
        <div id="toolbar-acciones" class="toolbar-group">
            <button type="button" id="btn-subir-picker" class="btn">
                <span class="material-symbols-outlined">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><defs><style>.ax-secondary{opacity:.4}</style></defs><path d="M488 351.92H352v8a56 56 0 0 1-56 56h-80a56 56 0 0 1-56-56v-8H24a23.94 23.94 0 0 0-24 24v112a23.94 23.94 0 0 0 24 24h464a23.94 23.94 0 0 0 24-24v-112a23.94 23.94 0 0 0-24-24zm-120 132a20 20 0 1 1 20-20 20.06 20.06 0 0 1-20 20zm64 0a20 20 0 1 1 20-20 20.06 20.06 0 0 1-20 20z" class="ax-secondary"/><path d="M192 359.93v-168h-87.7c-17.8 0-26.7-21.5-14.1-34.11L242.3 5.62a19.37 19.37 0 0 1 27.3 0l152.2 152.2c12.6 12.61 3.7 34.11-14.1 34.11H320v168a23.94 23.94 0 0 1-24 24h-80a23.94 23.94 0 0 1-24-24z" class="ax-primary"/></svg>
                </span>
                {{ __('ax-filebrowser.upload') }}
            </button>
        </div>
    </header>

    <div id="layout" class="layout-container">

        {{-- ── SIDEBAR ──────────────────────────────────────────────────────── --}}
        <aside id="sidebar" class="sidebar scrollbar-custom">
            <nav id="arbol-carpetas" class="sidebar-content">
                <div class="sidebar-tree-item {{ $currentFolder === '' ? 'active' : '' }}">
                    <span class="material-symbols-outlined small"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path fill="currentColor" d="M143 352.3L7 216.3c-9.4-9.4-9.4-24.6 0-33.9l22.6-22.6c9.4-9.4 24.6-9.4 33.9 0l96.4 96.4 96.4-96.4c9.4-9.4 24.6-9.4 33.9 0l22.6 22.6c9.4 9.4 9.4 24.6 0 33.9l-136 136c-9.2 9.4-24.4 9.4-33.8 0z"></path></svg></span>
                    <span class="material-symbols-outlined"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><defs><style>.ax-secondary{opacity:.4}</style></defs><path d="M69.08 271.63L0 390.05V112a48 48 0 0 1 48-48h160l64 64h160a48 48 0 0 1 48 48v48H152a96.31 96.31 0 0 0-82.92 47.63z" class="ax-secondary"/><path d="M152 256h400a24 24 0 0 1 20.73 36.09l-72.46 124.16A64 64 0 0 1 445 448H45a24 24 0 0 1-20.73-36.09l72.45-124.16A64 64 0 0 1 152 256z" class="ax-primary"/></svg></span>
                    <a href="{{ route('ax.picker', ['callback' => $callback]) }}">{{ $rootName }}</a>
                </div>
                <div class="pl-8">
                @if($allFolders->count())
                    <div class="sidebar-tree-children">
                        @foreach($allFolders as $item)
                            <div class="sidebar-tree-item {{ $currentFolder === $item['path'] ? 'active' : '' }}" style="padding-left: {{ ($item['depth'] + 1) * 14 }}px">
                                @if($currentFolder === $item['path'])
                                    <span class="material-symbols-outlined"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><defs><style>.ax-secondary{opacity:.4}</style></defs><path d="M69.08 271.63L0 390.05V112a48 48 0 0 1 48-48h160l64 64h160a48 48 0 0 1 48 48v48H152a96.31 96.31 0 0 0-82.92 47.63z" class="ax-secondary"/><path d="M152 256h400a24 24 0 0 1 20.73 36.09l-72.46 124.16A64 64 0 0 1 445 448H45a24 24 0 0 1-20.73-36.09l72.45-124.16A64 64 0 0 1 152 256z" class="ax-primary"/></svg></span>
                                @else
                                    <span class="material-symbols-outlined"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><defs><style>.ax-secondary{opacity:.4}</style></defs><path d="M464 128H272l-64-64H48C21.49 64 0 85.49 0 112v288c0 26.51 21.49 48 48 48h416c26.51 0 48-21.49 48-48V176c0-26.51-21.49-48-48-48z" class="ax-secondary"/></svg></span>
                                @endif
                                <a href="{{ route('ax.picker', ['folder' => $item['path'], 'callback' => $callback]) }}">{{ $item['name'] }}</a>
                            </div>
                        @endforeach
                    </div>
                @endif
                </div>
            </nav>
        </aside>

        {{-- ── CONTENIDO ────────────────────────────────────────────────────── --}}
        <main id="contenido" class="main-content">

            {{-- Subheader breadcrumb --}}
            <div class="subheader">
                <div class="breadcrumb-container">
                    <nav id="breadcrumb" aria-label="breadcrumb" class="breadcrumbs">
                        <span class="breadcrumb-item">
                            <a href="{{ route('ax.picker', ['callback' => $callback]) }}">{{ $rootName }}</a>
                            @if($currentFolder)<span class="breadcrumb-sep">›</span>@endif
                        </span>
                        @if($currentFolder)
                            @php $parts = explode('/', $currentFolder); $acc = ''; @endphp
                            @foreach($parts as $part)
                                @php $acc = $acc ? $acc . '/' . $part : $part; @endphp
                                <span class="breadcrumb-item {{ $loop->last ? 'active' : '' }}">
                                    @if(!$loop->last)
                                        <a href="{{ route('ax.picker', ['folder' => $acc, 'callback' => $callback]) }}">{{ $part }}</a>
                                        <span class="breadcrumb-sep">›</span>
                                    @else
                                        <span aria-current="page">{{ $part }}</span>
                                    @endif
                                </span>
                            @endforeach
                        @endif
                    </nav>
                </div>
            </div>

            @if(session('success'))
                <p id="msg-success" role="status" class="msg-auto-hide">{{ session('success') }}</p>
            @endif

            {{-- Archivos en grilla --}}
            @if($files->count())
                <section id="seccion-archivos">
                    <ul id="grilla-archivos" class="file-grid" data-vista="grilla">
                        @foreach($files as $file)
                            @php
                                $ext = $file['extension'];
                                if (in_array($ext, ['jpg','jpeg','png','gif','webp','svg','avif'])) {
                                    $tipo = 'imagen';
                                } elseif (in_array($ext, ['mp4','webm','ogg','mov'])) {
                                    $tipo = 'video';
                                } elseif (in_array($ext, ['mp3','wav','flac','aac'])) {
                                    $tipo = 'audio';
                                } elseif ($ext === 'pdf') {
                                    $tipo = 'pdf';
                                } else {
                                    $tipo = 'otro';
                                }
                            @endphp
                            <li class="file-item"
                                data-ext="{{ $file['extension'] }}"
                                data-path="{{ $file['path'] }}"
                                data-name="{{ $file['name'] }}"
                                data-url="/{{ $file['path'] }}"
                                data-tipo="{{ $tipo }}">

                                <div class="file-card picker-card">
                                    <div class="file-thumbnail">
                                        @if(in_array($file['extension'], ['jpg','jpeg','png','gif','webp','svg','avif']))
                                            <img src="/{{ $file['path'] }}" alt="{{ $file['name'] }}" loading="lazy">
                                        @elseif(in_array($file['extension'], ['mp4','webm','ogg','mov']))
                                            <video src="/{{ $file['path'] }}" muted preload="metadata"></video>
                                        @elseif($file['extension'] === 'pdf')
                                            <span>PDF</span>
                                        @else
                                            <span>{{ strtoupper($file['extension']) }}</span>
                                        @endif
                                    </div>
                                    <div class="file-info">
                                        <p class="file-name">{{ $file['name'] }}</p>
                                        <p class="file-details">{{ number_format($file['size'] / 1024, 1) }} Kb</p>
                                    </div>
                                </div>

                            </li>
                        @endforeach
                    </ul>
                </section>
            @else
                <p class="msg color-info">{{ __('ax-filebrowser.no_files') }}</p>
            @endif

        </main>
    </div>

    {{-- ── DIALOG SUBIR (picker) ────────────────────────────────────────────── --}}
    <dialog id="dialog-subir-picker">
        <div class="dialog-title">{{ __('ax-filebrowser.upload') }}</div>
        <div class="dialog-body">
            <form method="POST" action="{{ route('ax.upload') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="current_folder" value="{{ $currentFolder }}">
                <input type="hidden" name="picker_callback" value="{{ $callback }}">
                <div class="row">
                    <label>Source</label>
                    <div id="picker-tipo-toggle">
                        <button type="button" class="ax-btn color-gray active" id="picker-btn-file">{{ __('ax-filebrowser.upload_file') }}</button>
                        <button type="button" class="ax-btn color-gray" id="picker-btn-link">{{ __('ax-filebrowser.link_url') }}</button>
                    </div>
                </div>
                <div class="row" id="picker-file-row">
                    <label for="picker-file">File</label>
                    <div>
                        <label for="picker-file" class="ax-btn color-gray inputFile">{{ __('ax-filebrowser.select_file') }}</label>
                        <input type="file" id="picker-file" name="file" class="form-control">
                    </div>
                </div>
                <div class="row" id="picker-link-row" hidden>
                    <label for="picker-file-url">URL</label>
                    <input type="url" id="picker-file-url" name="file_url" class="form-control" placeholder="https://...">
                </div>
                <div class="row">
                    <label for="picker-autor">{{ __('ax-filebrowser.author') }}</label>
                    <input type="text" id="picker-autor" class="form-control" name="autor">
                </div>
                <div class="row">
                    <label for="picker-epigrafe">{{ __('ax-filebrowser.description') }}</label>
                    <textarea id="picker-epigrafe" class="form-control" name="epigrafe"></textarea>
                </div>
                <div class="row">
                    <label for="picker-tags">{{ __('ax-filebrowser.tags') }}</label>
                    <input type="text" id="picker-tags" class="form-control" name="tags" placeholder="{{ __('ax-filebrowser.add_tag') }}">
                </div>
                <div class="row btns">
                    <button type="submit" class="ax-btn color-primary">{{ __('ax-filebrowser.upload_btn') }}</button>
                    <button type="button" id="picker-btn-cancelar" class="ax-btn color-warning">{{ __('ax-filebrowser.cancel') }}</button>
                </div>
            </form>
        </div>
    </dialog>


    {{-- ── DIALOG GALLERY (SLIDESHOW) ─────────────────────────────────────────── --}}
    <dialog id="dialog-gallery">
        <div id="gallery-header">
            <span id="gallery-nombre"></span>
            <span id="gallery-counter"></span>
            <button type="button" id="btn-cerrar-gallery" class="ax-btn cancel">✕</button>
        </div>
        <div id="gallery-stage">
            <button type="button" id="gallery-prev" class="gallery-nav">‹</button>
            <div id="gallery-img-wrap">
                <img id="gallery-img" src="" alt="">
            </div>
            <button type="button" id="gallery-next" class="gallery-nav">›</button>
        </div>
        <div id="gallery-info">
            <span id="gallery-details"></span>
            <button type="button" id="gallery-insert" class="ax-btn color-primary">{{ __('ax-filebrowser.insert') }}</button>
        </div>
        <div id="gallery-thumbs"></div>
    </dialog>

    <script>
        const PICKER_CALLBACK = '{{ $callback }}';

        // Click en archivo → insertar
        const grilla = document.getElementById('grilla-archivos');
        if (grilla) {
            grilla.addEventListener('click', (e) => {
                const item = e.target.closest('.file-item');
                if (!item) return;

                // Highlight
                grilla.querySelectorAll('.file-item.selected').forEach(el => el.classList.remove('selected'));
                item.classList.add('selected');
            });

            grilla.addEventListener('dblclick', (e) => {
                const item = e.target.closest('.file-item');
                if (item) insertarDesdeItem(item);
            });
        }

        // Click en thumbnail también inserta con un solo click si se quiere — usamos dblclick arriba
        // Para insertar con un click en el file-card:
        document.querySelectorAll('.picker-card').forEach(card => {
            card.addEventListener('click', () => {
                const item = card.closest('.file-item');
                if (item) {
                    // primer click selecciona, segundo inserta
                    if (item.classList.contains('selected')) {
                        insertarDesdeItem(item);
                    } else {
                        grilla.querySelectorAll('.file-item.selected').forEach(el => el.classList.remove('selected'));
                        item.classList.add('selected');
                    }
                }
            });
        });

        function insertarDesdeItem(item) {
            const path = item.dataset.path;
            const name = item.dataset.name;
            const ext  = item.dataset.ext;
            const url  = '/' + path;
            let code   = '';

            const imagenes = ['jpg','jpeg','png','gif','webp','svg','avif'];
            const videos   = ['mp4','webm','ogg','mov'];
            const audios   = ['mp3','wav','ogg','flac','aac'];

            if (imagenes.includes(ext)) {
                code = '<img src="' + url + '" alt="' + name + '" class="img-article">';
            } else if (videos.includes(ext)) {
                code = '<video controls><source src="' + url + '"></video>';
            } else if (audios.includes(ext)) {
                code = '<audio controls><source src="' + url + '"></audio>';
            } else if (ext === 'pdf') {
                code = '<embed src="' + url + '" type="application/pdf">';
            } else {
                code = '<a href="' + url + '">' + name + '</a>';
            }

            if (window.opener && typeof window.opener[PICKER_CALLBACK] === 'function') {
                window.opener[PICKER_CALLBACK](code, url, name);
                window.close();
            } else if (window.parent !== window && typeof window.parent[PICKER_CALLBACK] === 'function') {
                window.parent[PICKER_CALLBACK](code, url, name);
            }
        }

        // Dialog subir
        const dialogSubirPicker = document.getElementById('dialog-subir-picker');
        document.getElementById('btn-subir-picker').addEventListener('click', () => dialogSubirPicker.showModal());
        document.getElementById('picker-btn-cancelar').addEventListener('click', () => dialogSubirPicker.close());

        // Toggle file/link
        document.getElementById('picker-btn-file').addEventListener('click', () => {
            document.getElementById('picker-btn-file').classList.add('active');
            document.getElementById('picker-btn-link').classList.remove('active');
            document.getElementById('picker-file-row').hidden = false;
            document.getElementById('picker-link-row').hidden = true;
        });
        document.getElementById('picker-btn-link').addEventListener('click', () => {
            document.getElementById('picker-btn-link').classList.add('active');
            document.getElementById('picker-btn-file').classList.remove('active');
            document.getElementById('picker-link-row').hidden = false;
            document.getElementById('picker-file-row').hidden = true;
        });

        // Auto-hide mensajes
        document.querySelectorAll('.msg-auto-hide').forEach(el => {
            setTimeout(() => {
                el.style.transition = 'opacity .6s';
                el.style.opacity    = '0';
                setTimeout(() => el.remove(), 600);
            }, 30000);
        });
    </script>

</body>
</html>