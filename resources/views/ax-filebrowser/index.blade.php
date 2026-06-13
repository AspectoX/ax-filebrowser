@push('styles')
    <link rel="stylesheet" href="/vendor/ax-filebrowser/css/ax-filebrowser.css">
@endpush
<div id="ax-filebrowser">

    {{-- ── TOOLBAR ──────────────────────────────────────────────────────────── --}}
    <header id="toolbar" class="toolbar">

        <div id="toolbar-acciones" class="toolbar-group">
            <button type="button" id="btn-nueva-carpeta" class="btn">
                <span class="material-symbols-outlined">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><defs><style>.ax-secondary{opacity:.4}</style></defs><path d="M464,128H272L208,64H48A48,48,0,0,0,0,112V400a48,48,0,0,0,48,48H464a48,48,0,0,0,48-48V176A48,48,0,0,0,464,128ZM359.5,296a16,16,0,0,1-16,16h-64v64a16,16,0,0,1-16,16h-16a16,16,0,0,1-16-16V312h-64a16,16,0,0,1-16-16V280a16,16,0,0,1,16-16h64V200a16,16,0,0,1,16-16h16a16,16,0,0,1,16,16v64h64a16,16,0,0,1,16,16Z" class="ax-secondary"/><path d="M359.5,296a16,16,0,0,1-16,16h-64v64a16,16,0,0,1-16,16h-16a16,16,0,0,1-16-16V312h-64a16,16,0,0,1-16-16V280a16,16,0,0,1,16-16h64V200a16,16,0,0,1,16-16h16a16,16,0,0,1,16,16v64h64a16,16,0,0,1,16,16Z" class="ax-primary"/></svg>
                </span>
                {{ __('ax-filebrowser.new_folder') }}
            </button>
            <button type="button" id="btn-subir" class="btn">
                <span class="material-symbols-outlined">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><defs><style>.ax-secondary{opacity:.4}</style></defs><path d="M488 351.92H352v8a56 56 0 0 1-56 56h-80a56 56 0 0 1-56-56v-8H24a23.94 23.94 0 0 0-24 24v112a23.94 23.94 0 0 0 24 24h464a23.94 23.94 0 0 0 24-24v-112a23.94 23.94 0 0 0-24-24zm-120 132a20 20 0 1 1 20-20 20.06 20.06 0 0 1-20 20zm64 0a20 20 0 1 1 20-20 20.06 20.06 0 0 1-20 20z" class="ax-secondary"/><path d="M192 359.93v-168h-87.7c-17.8 0-26.7-21.5-14.1-34.11L242.3 5.62a19.37 19.37 0 0 1 27.3 0l152.2 152.2c12.6 12.61 3.7 34.11-14.1 34.11H320v168a23.94 23.94 0 0 1-24 24h-80a23.94 23.94 0 0 1-24-24z" class="ax-primary"/></svg>
                </span>
                {{ __('ax-filebrowser.upload') }}
            </button>
            <div class="toolbar-divider"></div>
            <button type="button" id="btn-rename" class="btn" disabled>
                <span class="material-symbols-outlined">
                    <svg xmlns="http://www.w3.org/2000/svg" data-icon="edit" viewBox="0 0 576 512"><defs><style>.ax-secondary{opacity:.4}</style></defs><path d="M564.6 60.2l-48.8-48.8a39.11 39.11 0 0 0-55.2 0l-35.4 35.4a9.78 9.78 0 0 0 0 13.8l90.2 90.2a9.78 9.78 0 0 0 13.8 0l35.4-35.4a39.11 39.11 0 0 0 0-55.2zM427.5 297.6l-40 40a12.3 12.3 0 0 0-3.5 8.5v101.8H64v-320h229.8a12.3 12.3 0 0 0 8.5-3.5l40-40a12 12 0 0 0-8.5-20.5H48a48 48 0 0 0-48 48v352a48 48 0 0 0 48 48h352a48 48 0 0 0 48-48V306.1a12 12 0 0 0-20.5-8.5z" class="ax-secondary"/><path d="M492.8 173.3a9.78 9.78 0 0 1 0 13.8L274.4 405.5l-92.8 10.3a19.45 19.45 0 0 1-21.5-21.5l10.3-92.8L388.8 83.1a9.78 9.78 0 0 1 13.8 0z" class="ax-primary"/></svg>
                </span>
                {{ __('ax-filebrowser.rename') }}
            </button>
            <button type="button" id="btn-preview" class="btn" disabled>
                <span class="material-symbols-outlined">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><defs><style>.ax-secondary{opacity:.4}</style></defs><path d="M572.52 241.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288.14 400H288a143.93 143.93 0 1 1 .14 0z" class="ax-secondary"/><path d="M380.66 280.87a95.78 95.78 0 1 1-184.87-50.18 47.85 47.85 0 0 0 66.9-66.9 95.3 95.3 0 0 1 118 117.08z" class="ax-primary"/></svg>
                </span>
                {{ __('ax-filebrowser.preview') }}
            </button>
            <button type="button" id="btn-copy" class="btn" disabled>
                <span class="material-symbols-outlined">
                    <svg xmlns="http://www.w3.org/2000/svg" data-icon="copy" viewBox="0 0 448 512"><defs><style>.ax-secondary{opacity:.4}</style></defs><path d="M352 96V0H152a24 24 0 0 0-24 24v368a24 24 0 0 0 24 24h272a24 24 0 0 0 24-24V96z" class="ax-secondary"/><path d="M96 392V96H24a24 24 0 0 0-24 24v368a24 24 0 0 0 24 24h272a24 24 0 0 0 24-24v-40H152a56.06 56.06 0 0 1-56-56zM441 73L375 7a24 24 0 0 0-17-7h-6v96h96v-6.06A24 24 0 0 0 441 73z" class="ax-primary"/></svg>
                </span>
                {{ __('ax-filebrowser.copy') }}
            </button>
            <button type="button" id="btn-move" class="btn" disabled>
                <span class="material-symbols-outlined">
                    <svg xmlns="http://www.w3.org/2000/svg" data-icon="file-export" viewBox="0 0 576 512"><defs><style>.ax-secondary{opacity:.4}</style></defs><path d="M384 352.05v136.07A23.94 23.94 0 0 1 360 512H23.88A23.94 23.94 0 0 1 0 488V23.88A23.94 23.94 0 0 1 24 0h232v112a16 16 0 0 0 16 16h112v160.05H208a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16z" class="ax-secondary"/><path d="M272 128h112v-6.1a23.9 23.9 0 0 0-7-16.9L279.1 7a24 24 0 0 0-17-7H256v112a16 16 0 0 0 16 16zm299 180.05l-95.61-96.5c-10.1-10.1-27.41-3-27.41 11.3v65.2H208a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h239.93v65.1c0 14.3 17.31 21.4 27.41 11.3l95.71-96.4a17 17 0 0 0-.05-24z" class="ax-primary"/></svg>
                </span>
                {{ __('ax-filebrowser.move') }}
            </button>
            <button type="button" id="btn-edit-image" class="btn" disabled>
                <span class="material-symbols-outlined">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><defs><style>.ax-secondary{opacity:.4}</style></defs><path d="M448 384H64v-48l71.51-71.52a12 12 0 0 1 17 0L208 320l135.51-135.52a12 12 0 0 1 17 0L448 272z" class="ax-secondary"/><path d="M464 64H48a48 48 0 0 0-48 48v288a48 48 0 0 0 48 48h416a48 48 0 0 0 48-48V112a48 48 0 0 0-48-48zm-352 56a56 56 0 1 1-56 56 56 56 0 0 1 56-56zm336 264H64v-48l71.51-71.52a12 12 0 0 1 17 0L208 320l135.51-135.52a12 12 0 0 1 17 0L448 272z" class="ax-primary"/></svg>
                </span>
                {{ __('ax-filebrowser.edit_image') }}
            </button>
            <button type="button" id="btn-delete" class="btn" disabled>
                <span class="material-symbols-outlined">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><defs><style>.ax-secondary{opacity:.4}</style></defs><path d="M32 464a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V96H32zm272-288a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0z" class="ax-secondary"/><path d="M432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16zM128 160a16 16 0 0 0-16 16v224a16 16 0 0 0 32 0V176a16 16 0 0 0-16-16zm96 0a16 16 0 0 0-16 16v224a16 16 0 0 0 32 0V176a16 16 0 0 0-16-16zm96 0a16 16 0 0 0-16 16v224a16 16 0 0 0 32 0V176a16 16 0 0 0-16-16z" class="ax-primary"/></svg>
                </span>
                {{ __('ax-filebrowser.delete') }}
            </button>
        </div>

        <div id="toolbar-vistas" class="toolbar-group">
            <button type="button" id="btn-filter" class="btn">
                <span class="material-symbols-outlined">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M487.976 0H24.028C2.71 0-8.047 25.866 7.058 40.971L192 225.941V432c0 7.831 3.821 15.17 10.237 19.662l80 55.98C298.02 518.69 320 507.493 320 487.98V225.941l184.947-184.97C520.021 25.896 509.338 0 487.976 0z"></path></svg>
                </span>
                {{ __('ax-filebrowser.filter') }}
            </button>
            <button type="button" id="btn-buscar" class="btn">
                <span class="material-symbols-outlined"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"></path></svg></span>
                {{ __('ax-filebrowser.find') }}
            </button>
        </div>

    </header>

    <div id="layout" class="layout-container" id="layout">

        {{-- ── SIDEBAR ──────────────────────────────────────────────────────── --}}
        <aside id="sidebar" class="sidebar scrollbar-custom">
            <nav id="arbol-carpetas" class="sidebar-content">
                <div class="sidebar-tree-item {{ $currentFolder === '' ? 'active' : '' }}">
                    <span class="material-symbols-outlined small"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path fill="currentColor" d="M143 352.3L7 216.3c-9.4-9.4-9.4-24.6 0-33.9l22.6-22.6c9.4-9.4 24.6-9.4 33.9 0l96.4 96.4 96.4-96.4c9.4-9.4 24.6-9.4 33.9 0l22.6 22.6c9.4 9.4 9.4 24.6 0 33.9l-136 136c-9.2 9.4-24.4 9.4-33.8 0z"></path></svg></span>
                    <span class="material-symbols-outlined"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><defs><style>.ax-secondary{opacity:.4}</style></defs><path d="M69.08 271.63L0 390.05V112a48 48 0 0 1 48-48h160l64 64h160a48 48 0 0 1 48 48v48H152a96.31 96.31 0 0 0-82.92 47.63z" class="ax-secondary"/><path d="M152 256h400a24 24 0 0 1 20.73 36.09l-72.46 124.16A64 64 0 0 1 445 448H45a24 24 0 0 1-20.73-36.09l72.45-124.16A64 64 0 0 1 152 256z" class="ax-primary"/></svg></span>
                    <a href="{{ route('ax.index') }}">{{ $rootName }}</a>
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
                                    <a href="{{ route('ax.index', ['folder' => $item['path']]) }}">{{ $item['name'] }}</a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </nav>
        </aside>

        {{-- ── CONTENIDO PRINCIPAL ──────────────────────────────────────────── --}}
        <main id="contenido" class="main-content">

            {{-- Subheader: breadcrumb + controles de vista --}}
            <div class="subheader">
                <div class="breadcrumb-container">
                    <button class="btn-icon-small" id="btn-up" title="Subir nivel" {{ $currentFolder === '' ? 'disabled' : '' }}>
                        <span class="material-symbols-outlined text-muted">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M34.9 289.5l-22.2-22.2c-9.4-9.4-9.4-24.6 0-33.9L207 39c9.4-9.4 24.6-9.4 33.9 0l194.3 194.3c9.4 9.4 9.4 24.6 0 33.9L413 289.4c-9.5 9.5-25 9.3-34.3-.4L264 168.6V456c0 13.3-10.7 24-24 24h-32c-13.3 0-24-10.7-24-24V168.6L69.2 289.1c-9.3 9.8-24.8 10-34.3.4z"></path></svg>
                        </span>
                    </button>

                    <nav id="breadcrumb" aria-label="breadcrumb" class="breadcrumbs">
                        @foreach($breadcrumb as $crumb)
                            @if(!$loop->last)
                                <span class="breadcrumb-item">
                                    <span class="material-symbols-outlined">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><defs><style>.ax-secondary{opacity:.4}</style></defs><path d="M464 128H272l-64-64H48C21.49 64 0 85.49 0 112v288c0 26.51 21.49 48 48 48h416c26.51 0 48-21.49 48-48V176c0-26.51-21.49-48-48-48z" class="ax-primary"/></svg>
                                    </span>
                                    <a href="{{ route('ax.index', ['folder' => $crumb['path']]) }}">{{ $crumb['path'] === '' ? $rootName : $crumb['name'] }}</a>
                                    <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path fill="currentColor" d="M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z" class=""></path></svg></span>
                                </span>
                            @else
                                <span class="breadcrumb-item active">
                                    <span class="material-symbols-outlined"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><defs><style>.ax-secondary{opacity:.4}</style></defs><path d="M69.08 271.63L0 390.05V112a48 48 0 0 1 48-48h160l64 64h160a48 48 0 0 1 48 48v48H152a96.31 96.31 0 0 0-82.92 47.63z" class="ax-secondary"/><path d="M152 256h400a24 24 0 0 1 20.73 36.09l-72.46 124.16A64 64 0 0 1 445 448H45a24 24 0 0 1-20.73-36.09l72.45-124.16A64 64 0 0 1 152 256z" class="ax-primary"/></svg></span>
                                    <span aria-current="page">{{ $crumb['name'] }}</span>
                                </span>
                            @endif
                        @endforeach
                    </nav>
                </div>

                <div class="sort-view-controls">
                    <button type="button" class="btn-sort active" data-sort="name">{{ __('ax-filebrowser.sort_name') }}</button>
                    <button type="button" class="btn-sort" data-sort="size">{{ __('ax-filebrowser.sort_size') }}</button>
                    <button type="button" class="btn-sort" data-sort="date">
                        Date <span style="width: 0.5rem; margin-left: 0.3125rem;"><svg xmlns="http://www.w3.org/2000/svg" data-icon="triangle" viewBox="0 0 576 512"><path fill="currentColor" d="M329.6 24c-18.4-32-64.7-32-83.2 0L6.5 440c-18.4 31.9 4.6 72 41.6 72H528c36.9 0 60-40 41.6-72l-240-416z" class=""></path></svg></span>
                    </button>
                    <button type="button" id="btn-vista-grilla" class="btn-icon active" title="Vista grilla">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M149.333 56v80c0 13.255-10.745 24-24 24H24c-13.255 0-24-10.745-24-24V56c0-13.255 10.745-24 24-24h101.333c13.255 0 24 10.745 24 24zm181.334 240v-80c0-13.255-10.745-24-24-24H205.333c-13.255 0-24 10.745-24 24v80c0 13.255 10.745 24 24 24h101.333c13.256 0 24.001-10.745 24.001-24zm32-240v80c0 13.255 10.745 24 24 24H488c13.255 0 24-10.745 24-24V56c0-13.255-10.745-24-24-24H386.667c-13.255 0-24 10.745-24 24zm-32 80V56c0-13.255-10.745-24-24-24H205.333c-13.255 0-24 10.745-24 24v80c0 13.255 10.745 24 24 24h101.333c13.256 0 24.001-10.745 24.001-24zm-205.334 56H24c-13.255 0-24 10.745-24 24v80c0 13.255 10.745 24 24 24h101.333c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24zM0 376v80c0 13.255 10.745 24 24 24h101.333c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24H24c-13.255 0-24 10.745-24 24zm386.667-56H488c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24H386.667c-13.255 0-24 10.745-24 24v80c0 13.255 10.745 24 24 24zm0 160H488c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24H386.667c-13.255 0-24 10.745-24 24v80c0 13.255 10.745 24 24 24zM181.333 376v80c0 13.255 10.745 24 24 24h101.333c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24H205.333c-13.255 0-24 10.745-24 24z"></path></svg>
                    </button>
                    <button type="button" id="btn-vista-lista" class="btn-icon" title="Vista lista">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M149.333 216v80c0 13.255-10.745 24-24 24H24c-13.255 0-24-10.745-24-24v-80c0-13.255 10.745-24 24-24h101.333c13.255 0 24 10.745 24 24zM0 376v80c0 13.255 10.745 24 24 24h101.333c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24H24c-13.255 0-24 10.745-24 24zM125.333 32H24C10.745 32 0 42.745 0 56v80c0 13.255 10.745 24 24 24h101.333c13.255 0 24-10.745 24-24V56c0-13.255-10.745-24-24-24zm80 448H488c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24H205.333c-13.255 0-24 10.745-24 24v80c0 13.255 10.745 24 24 24zm-24-424v80c0 13.255 10.745 24 24 24H488c13.255 0 24-10.745 24-24V56c0-13.255-10.745-24-24-24H205.333c-13.255 0-24 10.745-24 24zm24 264H488c13.255 0 24-10.745 24-24v-80c0-13.255-10.745-24-24-24H205.333c-13.255 0-24 10.745-24 24v80c0 13.255 10.745 24 24 24z"></path></svg>
                    </button>
                    <button type="button" id="btn-reload" class="btn-icon" title="Recargar">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M500.33 0h-47.41a12 12 0 0 0-12 12.57l4 82.76A247.42 247.42 0 0 0 256 8C119.34 8 7.9 119.53 8 256.19 8.1 393.07 119.1 504 256 504a247.1 247.1 0 0 0 166.18-63.91 12 12 0 0 0 .48-17.43l-34-34a12 12 0 0 0-16.38-.55A176 176 0 1 1 402.1 157.8l-101.53-4.87a12 12 0 0 0-12.57 12v47.41a12 12 0 0 0 12 12h200.33a12 12 0 0 0 12-12V12a12 12 0 0 0-12-12z"></path></svg>
                    </button>
                </div>
            </div>

            {{-- Mensajes --}}
            @if(session('success'))
                <p id="msg-success" class="msg color-success msg-auto-hide" role="status">{{ session('success') }}</p>
            @endif

            @if($errors->any())
                <ul id="msg-errors" class="msg color-danger msg-auto-hide" role="alert">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            @endif

            @if(session('confirm_delete_folder'))
                <div id="confirm-delete">
                    <p>{{ __('ax-filebrowser.delete_folder_msg', ['name' => session('confirm_delete_folder')]) }}</p>
                    <form method="POST" action="{{ route('ax.folder.delete') }}">
                        @csrf
                        <input type="hidden" name="folder_path" value="{{ session('confirm_delete_folder') }}">
                        <input type="hidden" name="force" value="1">
                        <button type="submit" class"ax-btn color-danger">{{ __('ax-filebrowser.confirm_yes') }}</button>
                    </form>
                </div>
            @endif

            {{-- Archivos en grilla --}}
            <section id="seccion-archivos" class="file-grid-container scrollbar-custom">
                <ul id="grilla-archivos" class="file-grid" data-vista="grilla">

                    {{-- Carpetas --}}
                    @foreach($folders as $folder)
                        @php $folderPath = ($currentFolder ? $currentFolder . '/' : '') . $folder; @endphp
                        <li class="file-item folder-item"
                            data-type="folder"
                            data-path="{{ $folderPath }}"
                            data-name="{{ $folder }}">
                            <div class="file-card">
                                <div class="file-thumbnail folder-thumb">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><defs><style>.ax-secondary{opacity:.4}</style></defs><path d="M464 128H272l-64-64H48C21.49 64 0 85.49 0 112v288c0 26.51 21.49 48 48 48h416c26.51 0 48-21.49 48-48V176c0-26.51-21.49-48-48-48z" class="ax-secondary"/></svg>
                                </div>
                                <div class="file-info">
                                    <p class="file-name">{{ $folder }}</p>
                                    <p class="file-details">{{ __('ax-filebrowser.folder') }}</p>
                                </div>
                            </div>
                        </li>
                    @endforeach

                    {{-- Archivos --}}
                    @php
                    $iconos = [
                        'pdf'  => '<svg xmlns="http://www.w3.org/2000/svg" data-icon="file-pdf" viewBox="0 0 384 512"><defs><style>.fa-secondary{opacity:.4}</style></defs><path d="M86.1 428.1c0 .8 13.2-5.4 34.9-40.2-6.7 6.3-29.1 24.5-34.9 40.2zm93.8-218.9c-2.9 0-3 30.9 2 46.9 5.6-10 6.4-46.9-2-46.9zm80.2 142.1c37.1 15.8 42.8 9 42.8 9 4.1-2.7-2.5-11.9-42.8-9zm-79.9-48c-7.7 20.2-17.3 43.3-28.4 62.7 18.3-7 39-17.2 62.9-21.9-12.7-9.6-24.9-23.4-34.5-40.8zM272 128a16 16 0 0 1-16-16V0H24A23.94 23.94 0 0 0 0 23.88V488a23.94 23.94 0 0 0 23.88 24H360a23.94 23.94 0 0 0 24-23.88V128zm21.9 254.4c-16.9 0-42.3-7.7-64-19.5-24.9 4.1-53.2 14.7-79 23.2-25.4 43.8-43.2 61.8-61.1 61.8-5.5 0-15.9-3.1-21.5-10-19.1-23.5 27.4-54.1 54.5-68 .1 0 .1-.1.2-.1 12.1-21.2 29.2-58.2 40.8-85.8-8.5-32.9-13.1-58.7-8.1-77 5.4-19.7 43.1-22.6 47.8 6.8 5.4 17.6-1.7 45.7-6.2 64.2 9.4 24.8 22.7 41.6 42.7 53.8 19.3-2.5 59.7-6.4 73.6 7.2 11.5 11.4 9.5 43.4-19.7 43.4z" class="fa-secondary"/><path d="M377 105L279.1 7a24 24 0 0 0-17-7H256v112a16 16 0 0 0 16 16h112v-6.1a23.9 23.9 0 0 0-7-16.9zM240 331.8c-20-12.2-33.3-29-42.7-53.8 4.5-18.5 11.6-46.6 6.2-64.2-4.7-29.4-42.4-26.5-47.8-6.8-5 18.3-.4 44.1 8.1 77-11.6 27.6-28.7 64.6-40.8 85.8-.1 0-.1.1-.2.1-27.1 13.9-73.6 44.5-54.5 68 5.6 6.9 16 10 21.5 10 17.9 0 35.7-18 61.1-61.8 25.8-8.5 54.1-19.1 79-23.2 21.7 11.8 47.1 19.5 64 19.5 29.2 0 31.2-32 19.7-43.4-13.9-13.6-54.3-9.7-73.6-7.2zM86.1 428.1c5.8-15.7 28.2-33.9 34.9-40.2-21.7 34.8-34.9 41-34.9 40.2zm93.8-218.9c8.4 0 7.6 36.9 2 46.9-5-16-4.9-46.9-2-46.9zM151.8 366c11.1-19.4 20.7-42.5 28.4-62.7 9.6 17.4 21.8 31.2 34.5 40.8-23.9 4.7-44.6 14.9-62.9 21.9zm151.1-5.7s-5.7 6.8-42.8-9c40.3-2.9 46.9 6.3 42.8 9z" class="fa-primary"/></svg>',
                        'doc'  => '<svg xmlns="http://www.w3.org/2000/svg" data-icon="file-word" viewBox="0 0 384 512"><defs><style>.fa-secondary{opacity:.4}</style></defs><path d="M384 128H272a16 16 0 0 1-16-16V0H24A23.94 23.94 0 0 0 0 23.88V488a23.94 23.94 0 0 0 23.88 24H360a23.94 23.94 0 0 0 24-23.88V128zm-67.3 142.7l-38 168A11.9 11.9 0 0 1 267 448h-38a12 12 0 0 1-11.6-9.1c-25.8-103.5-20.8-81.2-25.6-110.5h-.5c-1.1 14.3-2.4 17.4-25.6 110.5a12 12 0 0 1-11.6 9.1H117a12 12 0 0 1-11.7-9.4l-37.8-168A12 12 0 0 1 79.2 256h24.5a12 12 0 0 1 11.8 9.7c15.6 78 20.1 109.5 21 122.2 1.6-10.2 7.3-32.7 29.4-122.7a11.9 11.9 0 0 1 11.7-9.1h29.1a12 12 0 0 1 11.7 9.2c24 100.4 28.8 124 29.6 129.4-.2-11.2-2.6-17.8 21.6-129.2a11.59 11.59 0 0 1 11.5-9.5H305a12 12 0 0 1 12 12 11.8 11.8 0 0 1-.3 2.7z" class="fa-secondary"/><path d="M377 105L279.1 7a24 24 0 0 0-17-7H256v112a16 16 0 0 0 16 16h112v-6.1a23.9 23.9 0 0 0-7-16.9zm-72 151h-23.9a11.59 11.59 0 0 0-11.5 9.5c-24.2 111.4-21.8 118-21.6 129.2-.8-5.4-5.6-29-29.6-129.4a12 12 0 0 0-11.7-9.2h-29.1a11.9 11.9 0 0 0-11.7 9.1c-22.1 90-27.8 112.5-29.4 122.7-.9-12.7-5.4-44.2-21-122.2a12 12 0 0 0-11.8-9.7H79.2a12 12 0 0 0-11.7 14.6l37.8 168A12 12 0 0 0 117 448h37.1a12 12 0 0 0 11.6-9.1c23.2-93.1 24.5-96.2 25.6-110.5h.5c4.8 29.3-.2 7 25.6 110.5A12 12 0 0 0 229 448h38a11.9 11.9 0 0 0 11.7-9.3l38-168a11.8 11.8 0 0 0 .3-2.7 12 12 0 0 0-12-12z" class="fa-primary"/></svg>',
                        'docx' => '<svg xmlns="http://www.w3.org/2000/svg" data-icon="file-word" viewBox="0 0 384 512"><defs><style>.fa-secondary{opacity:.4}</style></defs><path d="M384 128H272a16 16 0 0 1-16-16V0H24A23.94 23.94 0 0 0 0 23.88V488a23.94 23.94 0 0 0 23.88 24H360a23.94 23.94 0 0 0 24-23.88V128zm-67.3 142.7l-38 168A11.9 11.9 0 0 1 267 448h-38a12 12 0 0 1-11.6-9.1c-25.8-103.5-20.8-81.2-25.6-110.5h-.5c-1.1 14.3-2.4 17.4-25.6 110.5a12 12 0 0 1-11.6 9.1H117a12 12 0 0 1-11.7-9.4l-37.8-168A12 12 0 0 1 79.2 256h24.5a12 12 0 0 1 11.8 9.7c15.6 78 20.1 109.5 21 122.2 1.6-10.2 7.3-32.7 29.4-122.7a11.9 11.9 0 0 1 11.7-9.1h29.1a12 12 0 0 1 11.7 9.2c24 100.4 28.8 124 29.6 129.4-.2-11.2-2.6-17.8 21.6-129.2a11.59 11.59 0 0 1 11.5-9.5H305a12 12 0 0 1 12 12 11.8 11.8 0 0 1-.3 2.7z" class="fa-secondary"/><path d="M377 105L279.1 7a24 24 0 0 0-17-7H256v112a16 16 0 0 0 16 16h112v-6.1a23.9 23.9 0 0 0-7-16.9zm-72 151h-23.9a11.59 11.59 0 0 0-11.5 9.5c-24.2 111.4-21.8 118-21.6 129.2-.8-5.4-5.6-29-29.6-129.4a12 12 0 0 0-11.7-9.2h-29.1a11.9 11.9 0 0 0-11.7 9.1c-22.1 90-27.8 112.5-29.4 122.7-.9-12.7-5.4-44.2-21-122.2a12 12 0 0 0-11.8-9.7H79.2a12 12 0 0 0-11.7 14.6l37.8 168A12 12 0 0 0 117 448h37.1a12 12 0 0 0 11.6-9.1c23.2-93.1 24.5-96.2 25.6-110.5h.5c4.8 29.3-.2 7 25.6 110.5A12 12 0 0 0 229 448h38a11.9 11.9 0 0 0 11.7-9.3l38-168a11.8 11.8 0 0 0 .3-2.7 12 12 0 0 0-12-12z" class="fa-primary"/></svg>',
                        'xls'  => '<svg xmlns="http://www.w3.org/2000/svg" data-icon="file-exel" viewBox="0 0 384 512"><defs><style>.fa-secondary{opacity:.4}</style></defs><path d="M384 128H272a16 16 0 0 1-16-16V0H24A23.94 23.94 0 0 0 0 23.88V488a23.94 23.94 0 0 0 23.88 24H360a23.94 23.94 0 0 0 24-23.88V128zM280.51 446.09A12 12 0 0 1 274 448h-34.9a12 12 0 0 1-10.6-6.3C208.9 405.5 192 373 192 373c-6.4 14.8-10 20-36.6 68.8a11.89 11.89 0 0 1-10.5 6.3H110a12 12 0 0 1-10.1-18.5l60.3-93.5-60.3-93.5a12 12 0 0 1 10.1-18.5h34.8a12 12 0 0 1 10.6 6.3c26.1 48.8 20 33.6 36.6 68.5 0 0 6.1-11.7 36.6-68.5a12 12 0 0 1 10.6-6.3H274a11.93 11.93 0 0 1 10.1 18.4L224 336l60.1 93.5a12 12 0 0 1-3.59 16.59z" class="fa-secondary"/><path d="M377 105L279.1 7a24 24 0 0 0-17-7H256v112a16 16 0 0 0 16 16h112v-6.1a23.9 23.9 0 0 0-7-16.9zM224 336l60.1-93.5a11.93 11.93 0 0 0-10.1-18.4h-34.8a12 12 0 0 0-10.6 6.3c-30.5 56.8-36.6 68.5-36.6 68.5-16.6-34.9-10.5-19.7-36.6-68.5a12 12 0 0 0-10.6-6.3H110a12 12 0 0 0-10.1 18.5l60.3 93.5-60.3 93.5a12 12 0 0 0 10.1 18.5h34.9a11.89 11.89 0 0 0 10.5-6.3c26.6-48.8 30.2-54 36.6-68.8 0 0 16.9 32.5 36.5 68.7a12 12 0 0 0 10.6 6.3H274a12 12 0 0 0 10.1-18.5z" class="fa-primary"/></svg>',
                        'xlsx' => '<svg xmlns="http://www.w3.org/2000/svg" data-icon="file-exel" viewBox="0 0 384 512"><defs><style>.fa-secondary{opacity:.4}</style></defs><path d="M384 128H272a16 16 0 0 1-16-16V0H24A23.94 23.94 0 0 0 0 23.88V488a23.94 23.94 0 0 0 23.88 24H360a23.94 23.94 0 0 0 24-23.88V128zM280.51 446.09A12 12 0 0 1 274 448h-34.9a12 12 0 0 1-10.6-6.3C208.9 405.5 192 373 192 373c-6.4 14.8-10 20-36.6 68.8a11.89 11.89 0 0 1-10.5 6.3H110a12 12 0 0 1-10.1-18.5l60.3-93.5-60.3-93.5a12 12 0 0 1 10.1-18.5h34.8a12 12 0 0 1 10.6 6.3c26.1 48.8 20 33.6 36.6 68.5 0 0 6.1-11.7 36.6-68.5a12 12 0 0 1 10.6-6.3H274a11.93 11.93 0 0 1 10.1 18.4L224 336l60.1 93.5a12 12 0 0 1-3.59 16.59z" class="fa-secondary"/><path d="M377 105L279.1 7a24 24 0 0 0-17-7H256v112a16 16 0 0 0 16 16h112v-6.1a23.9 23.9 0 0 0-7-16.9zM224 336l60.1-93.5a11.93 11.93 0 0 0-10.1-18.4h-34.8a12 12 0 0 0-10.6 6.3c-30.5 56.8-36.6 68.5-36.6 68.5-16.6-34.9-10.5-19.7-36.6-68.5a12 12 0 0 0-10.6-6.3H110a12 12 0 0 0-10.1 18.5l60.3 93.5-60.3 93.5a12 12 0 0 0 10.1 18.5h34.9a11.89 11.89 0 0 0 10.5-6.3c26.6-48.8 30.2-54 36.6-68.8 0 0 16.9 32.5 36.5 68.7a12 12 0 0 0 10.6 6.3H274a12 12 0 0 0 10.1-18.5z" class="fa-primary"/></svg>',
                        'zip'  => '<svg xmlns="http://www.w3.org/2000/svg" data-icon="file-archive" viewBox="0 0 384 512"><defs><style>.fa-secondary{opacity:.4}</style></defs><path d="M272 128a16 16 0 0 1-16-16V0h-96v32h-32V0H24A23.94 23.94 0 0 0 0 23.88V488a23.94 23.94 0 0 0 23.88 24H360a23.94 23.94 0 0 0 24-23.88V128zM95.9 32h32v32h-32zm83.47 342.08a52.43 52.43 0 1 1-102.74-21L96 256v-32h32v-32H96v-32h32v-32H96V96h32V64h32v32h-32v32h32v32h-32v32h32v32h-32v32h22.33a12.08 12.08 0 0 1 11.8 9.7l17.3 87.7a52.54 52.54 0 0 1-.06 20.68z" class="fa-secondary"/><path d="M377 105L279.1 7a24 24 0 0 0-17-7H256v112a16 16 0 0 0 16 16h112v-6.1a23.9 23.9 0 0 0-7-16.9zM127.9 32h-32v32h32zM96 160v32h32v-32zM160 0h-32v32h32zM96 96v32h32V96zm83.43 257.4l-17.3-87.7a12.08 12.08 0 0 0-11.8-9.7H128v-32H96v32l-19.37 97.1a52.43 52.43 0 1 0 102.8.3zm-51.1 36.6c-17.9 0-32.5-12-32.5-27s14.5-27 32.4-27 32.5 12.1 32.5 27-14.5 27-32.4 27zM160 192h-32v32h32zm0-64h-32v32h32zm0-64h-32v32h32z" class="fa-primary"/></svg>',
                        // etc
                    ];
                    @endphp
                    @foreach($files as $file)
                            @php
                                $ext      = $file['extension'];
                                $isExtUrl = $file['is_external'] ?? false;
                                $fileUrl  = $isExtUrl ? $file['path'] : '/uploads/' . $file['path'];

                                if ($isExtUrl) {
                                    $tipo = 'link';
                                } elseif (in_array($ext, ['jpg','jpeg','png','gif','webp','svg','avif'])) {
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
                                data-id="{{ $file['metadata_id'] }}"
                                data-path="{{ $file['path'] }}"
                                data-name="{{ $file['name'] }}"
                                data-size="{{ $file['size'] ?? 0 }}"
                                data-date="{{ $file['mtime'] ?? 0 }}"
                                data-url="{{ $fileUrl }}"
                                data-external="{{ $isExtUrl ? 'true' : 'false' }}"
                                data-tipo="{{ $tipo }}">
                                <div class="file-card">
                                    <div class="file-thumbnail">
                                        @if(!$isExtUrl && $ext)
                                            <span class="file-ext-badge">{{ strtoupper($ext) }}</span>
                                        @endif
                                        @if($isExtUrl)
                                            {{-- miniatura generada por JS via canvas --}}
                                            <canvas class="video-thumb-canvas" data-url="{{ $fileUrl }}"></canvas>
                                        @elseif(in_array($ext, ['jpg','jpeg','png','gif','webp','svg','avif']))
                                            <img src="{{ $fileUrl }}" alt="{{ $file['name'] }}" loading="lazy">
                                        @elseif(in_array($ext, ['mp4','webm','ogg','mov']))
                                            <video class="video-thumb" src="{{ $fileUrl }}" muted preload="metadata"></video>
                                        @elseif(in_array($ext, ['mp3','wav','flac','aac']))
                                            <audio src="{{ $fileUrl }}" controls preload="none"></audio>
                                        @elseif($ext === 'pdf')
                                            {!! $iconos[$ext] ?? '<span>' . strtoupper($ext) . '</span>' !!}
                                        @else
                                            {!! $iconos[$ext] ?? '<span>' . strtoupper($ext) . '</span>' !!}
                                        @endif
                                    </div>
                                    <div class="file-info">
                                        <p class="file-name">{{ $file['name'] }}</p>
                                        <p class="file-details">
                                            @if($isExtUrl)
                                                <span title="{{ $file['path'] }}">URL</span>
                                            @else
                                                {{ $file['dimensions'] ?? '' }}{{ ($file['dimensions'] ?? '') ? ' • ' : '' }}{{ number_format(($file['size'] ?? 0) / 1024, 1) }} Kb
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </li>
                    @endforeach

                </ul>
                @if(!$folders->count() && !$files->count())
                    <p id="carpeta-vacia" class="msg center">{{ __('ax-filebrowser.no_files') }}</p>
                @endif
            </section>

            {{-- ── STATUSBAR ────────────────────────────────────────────────────── --}}
            <footer id="statusbar" class="footer">
                <div class="footer-stats">
                    <span id="msg-estado">{{ session('success') ?? '' }}</span>
                    <span id="contador-archivos">{{ $files->count() }} file(s) in this folder</span>
                </div>
                <div class="footer-stats">
                    <div class="usage-container">
                        <span id="usage-label">Calculando...</span>
                        <div class="progress-bar">
                            <div class="progress-fill" id="usage-bar" style="width:0%"></div>
                        </div>
                    </div>
                </div>
            </footer>

        </main>
        
    </div>

    {{-- ── PANEL LATERAL INFO/RENAME ──────────────────────────────────────────── --}}
    <aside id="panel-info" hidden>
        <div id="panel-info-header">
            <span id="panel-info-title">{{ __('ax-filebrowser.file_info') }}</span>
            <button type="button" id="btn-cerrar-panel-info" class="btn">
                <svg xmlns="http://www.w3.org/2000/svg" data-icon="arrow-from-left" viewBox="0 0 448 512" style="width: 0.875rem;"><path fill="currentColor" d="M0 424V88c0-13.3 10.7-24 24-24h24c13.3 0 24 10.7 24 24v336c0 13.3-10.7 24-24 24H24c-13.3 0-24-10.7-24-24zm254.5-269.6l65.6 65.6H120c-13.3 0-24 10.7-24 24v24c0 13.3 10.7 24 24 24h200.1l-65.6 65.6c-9.4 9.4-9.4 24.6 0 33.9l17 17c9.4 9.4 24.6 9.4 33.9 0L441 273c9.4-9.4 9.4-24.6 0-33.9L305.5 103.5c-9.4-9.4-24.6-9.4-33.9 0l-17 17c-9.4 9.4-9.4 24.6-.1 33.9z" class=""></path></svg>
            </button>
        </div>
        <div id="panel-info-thumb"></div>
        <div id="panel-info-body">
            <div class="panel-row"><span>{{ __('ax-filebrowser.sort_name') }}</span><span id="pi-name"></span></div>
            <div class="panel-row"><span>{{ __('ax-filebrowser.sort_size') }}</span><span id="pi-size"></span></div>
            <div class="panel-row"><span>{{ __('ax-filebrowser.modified') }}</span><span id="pi-date"></span></div>
            <div class="panel-row" id="pi-dims-row"><span>{{ __('ax-filebrowser.dimensions') }}</span><span id="pi-dims"></span></div>
            <span class="divider"></span>
            <div class="panel-row">
                <label for="pi-new-name">{{ __('ax-filebrowser.rename') }}</label>
                <input type="text" id="pi-new-name" class="form-control">
            </div>
            <div class="panel-row">
                <label for="pi-autor">{{ __('ax-filebrowser.filter_author') }}</label>
                <input type="text" id="pi-autor" class="form-control">
            </div>
            <div class="panel-row">
                <label for="pi-credito">{{ __('ax-filebrowser.source_url') }}</label>
                <input type="text" id="pi-credito" class="form-control">
            </div>
            <div class="panel-row">
                <label for="pi-epigrafe">{{ __('ax-filebrowser.description') }}</label>
                <textarea id="pi-epigrafe" class="form-control"></textarea>
            </div>
            <div class="panel-row">
                <label>{{ __('ax-filebrowser.tags') }}</label>
                <div id="pi-tags-container">
                    <div id="pi-tags-list"></div>
                    <input type="text" id="pi-tags-input" class="form-control" placeholder="{{ __('ax-filebrowser.add_tag') }}">
                </div>
            </div>
            <div class="panel-row">
                <label for="pi-fecha">{{ __('ax-filebrowser.file_date') }}</label>
                <input type="date" id="pi-fecha" class="form-control">
            </div>
            <div id="pi-btns">
                <button type="button" id="btn-pi-save" class="ax-btn color-primary">{{ __('ax-filebrowser.save') }}</button>
                <button type="button" id="btn-pi-cancel" class="ax-btn color-warning">{{ __('ax-filebrowser.cancel') }}</button>
            </div>
        </div>
    </aside>

    {{-- ── DIALOG NUEVA CARPETA ─────────────────────────────────────────────── --}}
    <dialog id="dialog-nueva-carpeta">
        <div class="dialog-title">{{ __('ax-filebrowser.new_folder_title') }}</div>
        <div class="dialog-body">
            <form method="POST" action="{{ route('ax.folder.store') }}">
                @csrf
                <input type="hidden" name="current_folder" value="{{ $currentFolder }}">
                <div class="row">
                    <label for="folder_name">{{ __('ax-filebrowser.sort_name') }}</label>
                    <input type="text" id="folder_name" class="form-control" name="folder_name" value="{{ old('folder_name') }}"
                           placeholder="letters, numbers, hyphens" required autofocus>
                </div>
                <div class="row btns">
                    <button type="submit" class="ax-btn color-primary">{{ __('ax-filebrowser.create') }}</button>
                    <button type="button" id="btn-cancelar-carpeta" class="ax-btn color-warning">{{ __('ax-filebrowser.cancel') }}</button>
                </div>
            </form>
        </div>
    </dialog>

    {{-- ── DIALOG SUBIR ARCHIVO ─────────────────────────────────────────────── --}}
    <dialog id="dialog-subir">
        <div class="dialog-title">{{ __('ax-filebrowser.upload') }}</div>
        <div class="dialog-body" style="padding-inline: 0;">
            <form method="POST" action="{{ route('ax.upload') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="current_folder" value="{{ $currentFolder }}">
                <div class="row">
                    <label>Source</label>
                    <div id="upload-tipo-toggle" style="display: grid;grid-template-columns: 1fr 1fr 1fr;">
                        <button type="button" class="ax-btn min color-gray active" id="btn-tipo-file" data-tipo="file">{{ __('ax-filebrowser.upload_file') }}</button>
                        <button type="button" class="ax-btn min color-gray" id="btn-tipo-link" data-tipo="link">{{ __('ax-filebrowser.link_url') }}</button>
                        <button type="button" class="ax-btn min color-gray" id="btn-tipo-gallery" data-tipo="gallery">{{ __('ax-filebrowser.gallery') }}</button>
                    </div>
                </div>
                <div class="row" id="upload-file-row">
                    <label for="file">File</label>
                    <div>
                        <label for="file" class="ax-btn color-gray inputFile">{{ __('ax-filebrowser.select_file') }}</label>
                        <input type="file" id="file" class="form-control" name="file">
                    </div>
                </div>
                <div id="upload-link-row" hidden>
                    <div class="row">
                        <label for="file_url">URL</label>
                        <input type="text" id="file_url" class="form-control" name="file_url" placeholder="https://...">
                    </div>
                    <div class="row">
                        <label for="file_name">{{ __('ax-filebrowser.sort_name') }}</label>
                        <input type="text" id="file_name" class="form-control" name="file_name" placeholder="My video">
                    </div>
                </div>
                <div id="upload-gallery-row" hidden>
                    <div class="row">
                        <label for="gallery_name">Gallery name</label>
                        <input type="text" id="gallery_name" class="form-control" name="gallery_name" placeholder="my-gallery">
                    </div>
                    <div class="row">
                        <label for="gallery_files">{{ __('ax-filebrowser.images') }}</label>
                        <div>
                            <label for="gallery_files" class="ax-btn color-gray inputFile">{{ __('ax-filebrowser.select_file') }}</label>
                            <input type="file" id="gallery_files" name="files[]" class="form-control" multiple accept="image/*">
                            <span id="gallery_files_count"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <label for="autor">{{ __('ax-filebrowser.filter_author') }}</label>
                    <input type="text" id="autor" class="form-control" name="autor">
                </div>
                <div class="row">
                    <label for="credito_url">Source</label>
                    <input type="text" id="credito_url" class="form-control" name="credito_url">
                </div>
                <div class="row">
                    <label for="fecha_archivo">{{ __('ax-filebrowser.file_date') }}</label>
                    <input type="date" id="fecha_archivo" class="form-control" name="fecha_archivo">
                </div>
                <div class="row">
                    <label for="epigrafe">Heading / Description</label>
                    <textarea id="epigrafe" class="form-control" name="epigrafe"></textarea>
                </div>
                <div class="row">
                    <label for="tags">{{ __('ax-filebrowser.tags') }}</label>
                    <input type="text" id="tags" class="form-control" name="tags" placeholder="separated by comma">
                </div>
                <div class="row btns">
                    <button type="submit" class="ax-btn color-primary">{{ __('ax-filebrowser.upload_btn') }}</button>
                    <button type="button" id="btn-cancelar-subir" class="ax-btn color-warning">{{ __('ax-filebrowser.cancel') }}</button>
                </div>
            </form>
        </div>
    </dialog>

    {{-- ── DIALOG PREVIEW ───────────────────────────────────────────────────── --}}
    <dialog id="dialog-preview">
        <div class="dialog-title">{{ __('ax-filebrowser.preview') }}</div>
        <div class="dialog-body">
            <div id="preview-contenido"></div>
            <p id="preview-nombre"></p>
            <div class="row btns">
                <button type="button" id="btn-cerrar-preview" class="ax-btn cancel">{{ __('ax-filebrowser.close') }}</button>
            </div>
        </div>
    </dialog>


    {{-- ── DIALOG DELETE ───────────────────────────────────────────────────────── --}}
    <dialog id="dialog-delete">
        <div class="dialog-title">Delete file(s)</div>
        <div class="dialog-body">
            <p id="delete-msg"></p>
            <ul id="delete-list"></ul>
            <div class="row btns">
                <button type="button" id="btn-confirmar-delete" class="ax-btn color-danger">Delete</button>
                <button type="button" id="btn-cancelar-delete" class="ax-btn color-warning">{{ __('ax-filebrowser.cancel') }}</button>
            </div>
        </div>
    </dialog>

    {{-- ── DIALOG FIND ──────────────────────────────────────────────────────────── --}}
    <dialog id="dialog-find">
        <div class="dialog-title">{{ __('ax-filebrowser.find_title') }}</div>
        <div class="dialog-body">
            <div class="row">
                <label for="find-input">File name</label>
                <input type="text" id="find-input" class="form-control" placeholder="{{ __('ax-filebrowser.find_placeholder') }}" autocomplete="off">
            </div>
            <div id="find-results"></div>
            <div class="row btns">
                <button type="button" id="btn-cerrar-find" class="ax-btn cancel">{{ __('ax-filebrowser.close') }}</button>
            </div>
        </div>
    </dialog>

    {{-- ── DIALOG FILTER ────────────────────────────────────────────────────────── --}}
    <dialog id="dialog-filter">
        <div class="dialog-title">{{ __('ax-filebrowser.filter_title') }}</div>
        <div class="dialog-body">
            <div class="row">
                <label>{{ __('ax-filebrowser.filter_type') }}</label>
                <div id="filter-tipos" style="display: grid;grid-template-columns: 1fr 1fr 1fr;row-gap: .5rem;">
                    <button type="button" class="ax-btn color-gray active" data-tipo="">{{ __('ax-filebrowser.filter_all') }}</button>
                    <button type="button" class="ax-btn color-gray" data-tipo="imagen">{{ __('ax-filebrowser.images') }}</button>
                    <button type="button" class="ax-btn color-gray" data-tipo="video">{{ __('ax-filebrowser.filter_video') }}</button>
                    <button type="button" class="ax-btn color-gray" data-tipo="audio">{{ __('ax-filebrowser.filter_audio') }}</button>
                    <button type="button" class="ax-btn color-gray" data-tipo="pdf">{{ __('ax-filebrowser.filter_pdf') }}</button>
                    <button type="button" class="ax-btn color-gray" data-tipo="otro">Others</button>
                </div>
            </div>
            <div class="row">
                <label for="filter-ext">{{ __('ax-filebrowser.filter_ext') }}</label>
                <input type="text" id="filter-ext" class="form-control" placeholder="jpg, png, mp4...">
            </div>
            <div class="row">
                <label for="filter-autor">{{ __('ax-filebrowser.filter_author') }}</label>
                <input type="text" id="filter-autor" class="form-control" placeholder="Author name">
            </div>
            <div class="row">
                <label for="filter-tags">{{ __('ax-filebrowser.tags') }}</label>
                <input type="text" id="filter-tags" class="form-control" placeholder="separated by comma">
            </div>
            <div class="row">
                <label>{{ __('ax-filebrowser.sort_size') }}</label>
                <div id="filter-size-range">
                    <input type="number" id="filter-size-min" class="form-control" placeholder="{{ __('ax-filebrowser.filter_min_kb') }}" min="0">
                    <span>—</span>
                    <input type="number" id="filter-size-max" class="form-control" placeholder="{{ __('ax-filebrowser.filter_max_kb') }}" min="0">
                </div>
            </div>
            <div class="row btns">
                <button type="button" id="btn-aplicar-filter" class="ax-btn color-success">{{ __('ax-filebrowser.apply') }}</button>
                <button type="button" id="btn-limpiar-filter" class="ax-btn color-info">{{ __('ax-filebrowser.clear') }}</button>
                <button type="button" id="btn-cerrar-filter" class="ax-btn cancel">{{ __('ax-filebrowser.close') }}</button>
            </div>
        </div>
    </dialog>

    {{-- ── DIALOG EDIT IMAGE ────────────────────────────────────────────────────── --}}
    <dialog id="dialog-edit-image">
        <div class="dialog-title">{{ __('ax-filebrowser.edit_image_title') }}: <span id="edit-image-nombre" style="margin-left: .5rem;"></span></div>
        <div class="content-grid-2col dialog-body">
            <div>
                <div id="edit-controls">
    
                    <fieldset>
                        <legend><span>{{ __('ax-filebrowser.rotate_flip') }}</span></legend>
                        <div class="row btns-normal">
                            <button type="button" class="ax-btn color-gray" data-action="rotate-left"><span class="icon"><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' class=''><path fill='currentColor' d='M40 16C53.25 16 64 26.75 64 40v102.1C103.7 75.57 176.3 32.11 256.1 32.11C379.6 32.11 480 132.5 480 256s-100.4 223.9-223.9 223.9c-52.31 0-103.3-18.33-143.5-51.77c-10.19-8.5-11.56-23.62-3.062-33.81c8.5-10.22 23.66-11.56 33.81-3.062C174.9 417.5 214.9 432 256 432c97.03 0 176-78.97 176-176S353 80 256 80c-66.54 0-126.8 38.28-156.5 96H200C213.3 176 224 186.8 224 200S213.3 224 200 224h-160C26.75 224 16 213.3 16 200v-160C16 26.75 26.75 16 40 16z'/></svg></span> 90°</button>
                            <button type="button" class="ax-btn color-gray" data-action="rotate-right"><span class="icon"><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' class=''><path fill='currentColor' d='M496 40v160C496 213.3 485.3 224 472 224h-160C298.8 224 288 213.3 288 200s10.75-24 24-24h100.5C382.8 118.3 322.5 80 256 80C158.1 80 80 158.1 80 256s78.97 176 176 176c41.09 0 81.09-14.47 112.6-40.75c10.16-8.5 25.31-7.156 33.81 3.062c8.5 10.19 7.125 25.31-3.062 33.81c-40.16 33.44-91.17 51.77-143.5 51.77C132.4 479.9 32 379.5 32 256s100.4-223.9 223.9-223.9c79.85 0 152.4 43.46 192.1 109.1V40c0-13.25 10.75-24 24-24S496 26.75 496 40z'/></svg></span> 90°</button>
                            <button type="button" class="ax-btn color-gray" data-action="flip-h"><span class="icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M347.404 142.86c-4.753 4.753-4.675 12.484.173 17.14l73.203 70H91.22l73.203-70c4.849-4.656 4.927-12.387.173-17.14l-19.626-19.626c-4.686-4.686-12.284-4.686-16.971 0L3.515 247.515c-4.686 4.686-4.686 12.284 0 16.971L128 388.766c4.686 4.686 12.284 4.686 16.971 0l19.626-19.626c4.753-4.753 4.675-12.484-.173-17.14L91.22 282h329.56l-73.203 70c-4.849 4.656-4.927 12.387-.173 17.14l19.626 19.626c4.686 4.686 12.284 4.686 16.971 0l124.485-124.281c4.686-4.686 4.686-12.284 0-16.971L384 123.234c-4.686-4.686-12.284-4.686-16.971 0l-19.625 19.626z" class=""></path></svg></span> Horizontal</button>
                            <button type="button" class="ax-btn color-gray" data-action="flip-v"><span class="icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path fill="currentColor" d="M273.1 347.4c-4.8-4.8-12.5-4.7-17.1.2l-70 73.2V91.2l70 73.2c4.7 4.8 12.4 4.9 17.1.2l19.6-19.6c4.7-4.7 4.7-12.3 0-17L168.5 3.5c-4.7-4.7-12.3-4.7-17 0L27.2 128c-4.7 4.7-4.7 12.3 0 17l19.6 19.6c4.8 4.8 12.5 4.7 17.1-.2l70-73.2v329.6l-70-73.2c-4.7-4.8-12.4-4.9-17.1-.2L27.2 367c-4.7 4.7-4.7 12.3 0 17l124.3 124.5c4.7 4.7 12.3 4.7 17 0L292.8 384c4.7-4.7 4.7-12.3 0-17l-19.7-19.6z" class=""></path></svg></span> Vertical</button>
                        </div>
                    </fieldset>
    
                    <fieldset>
                        <legend><span>{{ __('ax-filebrowser.crop') }}</span></legend>
                        <input type="number" id="crop-x" value="0" min="0" hidden>
                        <input type="number" id="crop-y" value="0" min="0" hidden>

                        <div class="row">
                            <label for="crop-w">Width</label>
                            <input type="number" id="crop-w" class="form-control" value="0" min="1">
                        </div>
                        <div class="row">
                            <label for="crop-h">Height</label>
                            <input type="number" id="crop-h" class="form-control" value="0" min="1">
                        </div>
                        <div class="row btns">
                            <button type="button" class="ax-btn color-primary" data-action="crop">{{ __('ax-filebrowser.crop') }}</button>
                            <button type="button" class="ax-btn color-gray" id="btn-crop-manual">{{ __('ax-filebrowser.crop_manual') }}</button>
                        </div>
                    </fieldset>
    
                    <fieldset>
                        <legend><span>{{ __('ax-filebrowser.resize') }}</span></legend>
                        <div class="row">
                            <label for="resize-w">{{ __('ax-filebrowser.width_px') }}</label>
                            <input type="number" id="resize-w" class="form-control" min="1">
                        </div>
                        <div class="row">
                            <label for="resize-h">{{ __('ax-filebrowser.height_px') }}</label>
                            <input type="number" id="resize-h" class="form-control" min="1">
                        </div>
                        <label>
                            <input type="checkbox" id="resize-ratio" class="form-check-input" checked>
                            Keep aspect ratio
                        </label>
                        <div class="row btns">
                            <button type="button" class="ax-btn color-primary" data-action="resize">{{ __('ax-filebrowser.resize') }}</button>
                        </div>
                    </fieldset>

                </div>
            </div>

            <div class="edit-controls">
                <div id="edit-preview-wrap">
                    <canvas id="edit-canvas"></canvas>
                    <div id="crop-overlay" hidden>
                        <div id="crop-rect">
                            <div class="crop-handle" data-pos="tl"></div>
                            <div class="crop-handle" data-pos="tc"></div>
                            <div class="crop-handle" data-pos="tr"></div>
                            <div class="crop-handle" data-pos="ml"></div>
                            <div class="crop-handle" data-pos="mr"></div>
                            <div class="crop-handle" data-pos="bl"></div>
                            <div class="crop-handle" data-pos="bc"></div>
                            <div class="crop-handle" data-pos="br"></div>
                        </div>
                        <p id="crop-hint">Double click to crop · Ctrl+drag to scale proportionally · Esc to cancel</p>
                    </div>
                </div>
    
                <fieldset>
                    <legend><span>{{ __('ax-filebrowser.adjustments') }}</span></legend>
                    <div class="row">
                        <label for="edit-filtro">Filter</label>
                        <select id="edit-filtro" class="form-select">
                            <option value="">{{ __('ax-filebrowser.no_filter') }}</option>
                            <option value="grayscale">Grayscale</option>
                            <option value="sepia">Sepia</option>
                            <option value="noir">Noir</option>
                            <option value="vintage">Vintage</option>
                            <option value="fade">Fade</option>
                            <option value="warm">Warm</option>
                            <option value="cold">Cold</option>
                            <option value="dramatic">Dramatic</option>
                            <option value="invert">Invert</option>
                            <option value="blur">Blur</option>
                        </select>
                    </div>
                    <div class="row">
                        <label for="adj-brightness">
                            Brightness
                            <span id="adj-brightness-val" class="range-value">0</span>
                        </label>
                        <input type="range" id="adj-brightness" min="-100" max="100" value="0">
                    </div>
                    <div class="row">
                        <label for="adj-contrast">
                            Contrast
                            <span id="adj-contrast-val" class="range-value">0</span>
                        </label>
                        <input type="range" id="adj-contrast" min="-100" max="100" value="0">
                    </div>
                    <div class="row">
                        <label for="adj-saturation"> Saturation<span id="adj-saturation-val" class="range-value">0</span></label>
                        <input type="range" id="adj-saturation" min="-100" max="100" value="0">
                    </div>
                    <div class="row btns">
                        <button type="button" class="ax-btn color-primary" data-action="apply-adjustments">{{ __('ax-filebrowser.apply_adjustments') }}</button>
                    </div>
                </fieldset>

                <fieldset>
                    <legend><span>{{ __('ax-filebrowser.save') }}</span></legend>
                    <div class="row">
                        <label for="edit-format">{{ __('ax-filebrowser.format') }}</label>
                        <select id="edit-format" class="form-select">
                            <option value="image/jpeg">JPEG</option>
                            <option value="image/png">PNG</option>
                            <option value="image/webp">WebP</option>
                        </select>
                    </div>
                    <div class="row">
                        <label for="edit-quality">
                            Quality (JPEG/WebP)
                            <span id="edit-quality-val" class="range-value">90%</span>
                        </label>
                        <input type="range" id="edit-quality" min="10" max="100" value="90">
                    </div>
                    <div class="row">
                        <label><input type="checkbox" id="edit-overwrite" class="form-check-input"> Overwrite original</label>
                    </div>
                    <div class="row btns">
                        <button type="button" class="ax-btn color-info" style="margin-left: 1rem;" id="btn-edit-save">{{ __('ax-filebrowser.save_image') }}</button>
                        <button type="button" class="ax-btn color-success" id="btn-edit-download">{{ __('ax-filebrowser.download') }}</button>
                    </div>
                </fieldset>                
            </div>
        </div>
        <div class="row btns">
            <button type="button" id="btn-edit-reset" class="ax-btn color-danger">{{ __('ax-filebrowser.reset') }}</button>
            <button type="button" id="btn-cerrar-edit" class="ax-btn cancel">{{ __('ax-filebrowser.close') }}</button>
        </div>
    </dialog>


    {{-- ── DIALOG GALLERY (SLIDESHOW) ─────────────────────────────────────────── --}}
    <dialog id="dialog-gallery">
        <div id="gallery-header">
            <span id="gallery-nombre"></span>
            <span id="gallery-counter"></span>
            <button type="button" id="btn-cerrar-gallery" class="ax-btn circle cancel" style="width: 1.5rem!important;height: 1.5rem">
                <svg data-icon="times" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 352 512" style="width: 0.75rem;height: 0.75rem"><path fill="currentColor" d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z" class=""></path></svg>
            </button>
        </div>
        <div id="gallery-stage">
            <button type="button" id="gallery-prev" class="gallery-nav">
                <svg data-icon="angle-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path fill="currentColor" d="M31.7 239l136-136c9.4-9.4 24.6-9.4 33.9 0l22.6 22.6c9.4 9.4 9.4 24.6 0 33.9L127.9 256l96.4 96.4c9.4 9.4 9.4 24.6 0 33.9L201.7 409c-9.4 9.4-24.6 9.4-33.9 0l-136-136c-9.5-9.4-9.5-24.6-.1-34z" class=""></path></svg>
            </button>
            <div id="gallery-img-wrap">
                <img id="gallery-img" src="" alt="">
            </div>
            <button type="button" id="gallery-next" class="gallery-nav">
                <svg data-icon="angle-right" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path fill="currentColor" d="M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z" class=""></path></svg>
            </button>
        </div>
        <div id="gallery-info">
            <span id="gallery-details"></span>
        </div>
        <div id="gallery-thumbs"></div>
    </dialog>


    {{-- ── DIALOG CONFIRMAR BORRAR CARPETA ────────────────────────────────────── --}}
    <dialog id="dialog-confirm-folder">
        <div class="dialog-title">{{ __('ax-filebrowser.delete_folder_title') }}</div>
        <div class="dialog-body">
            <p>The folder <strong id="confirm-folder-name"></strong> has content. Delete everything inside?</p>
        </div>
        <div class="row btns">
            <button type="button" id="btn-confirmar-folder-delete" class="ax-btn color-danger">{{ __('ax-filebrowser.yes_delete_all') }}</button>
            <button type="button" id="btn-cancelar-folder-delete" class="ax-btn cancel">{{ __('ax-filebrowser.cancel') }}</button>
        </div>
    </dialog>


    {{-- ── DIALOG MOVE ──────────────────────────────────────────────────────────── --}}
    <dialog id="dialog-move">
        <div class="dialog-title">{{ __('ax-filebrowser.move_to') }}</div>
        <div class="dialog-body">
            <p id="move-source-name"></p>
            <div id="move-folder-tree" class="folder-tree-picker scrollbar-custom"></div>
        </div>
        <div class="row btns">
            <button type="button" id="btn-confirmar-move" class="ax-btn color-primary">{{ __('ax-filebrowser.move_here') }}</button>
            <button type="button" id="btn-cancelar-move" class="ax-btn color-warning">{{ __('ax-filebrowser.cancel') }}</button>
        </div>
    </dialog>

    {{-- ── DIALOG COPY ──────────────────────────────────────────────────────────── --}}
    <dialog id="dialog-copy">
        <div class="dialog-title">{{ __('ax-filebrowser.copy_to') }}</div>
        <div class="dialog-body">
            <p id="copy-source-name"></p>
            <div id="copy-folder-tree" class="folder-tree-picker scrollbar-custom"></div>
        </div>
        <div class="row btns">
            <button type="button" id="btn-confirmar-copy" class="ax-btn color-primary">{{ __('ax-filebrowser.copy_here') }}</button>
            <button type="button" id="btn-cancelar-copy" class="ax-btn color-warning">{{ __('ax-filebrowser.cancel') }}</button>
        </div>
    </dialog>

    {{-- ── FORM HIDDEN PARA BORRADO ─────────────────────────────────────────── --}}
    <form id="form-delete" method="POST" action="{{ route('ax.file.delete.path') }}" hidden>
        @csrf
        <input type="hidden" name="file_path" id="delete-file-path">
        <input type="hidden" name="current_folder" value="{{ $currentFolder }}">
    </form>

    <script>
        const AX = {
            currentFolder    : '{{ $currentFolder }}',
            urlIndex         : '{{ route("ax.index") }}',
            urlDiskUsage     : '{{ route("ax.disk.usage") }}',
            urlSaveEdit      : '{{ route("ax.image.save") }}',
            urlDeleteByPath  : '{{ route("ax.file.delete.path") }}',
        urlFolderDelete  : '{{ route("ax.folder.delete") }}',
            urlUpload        : '{{ route("ax.upload") }}',
            urlUploadGallery : '{{ route("ax.upload.gallery") }}',
        urlRename        : '{{ route("ax.rename") }}',
        urlMove          : '{{ route("ax.move") }}',
        urlCopy          : '{{ route("ax.copy") }}',
        urlMetadataFetch : '{{ route("ax.metadata.fetch") }}',
        urlMetadataSave  : '{{ route("ax.metadata.save") }}',
            isGalleryFolder  : {{ $isGalleryFolder ? 'true' : 'false' }},
        allFolders       : {!! json_encode($allFolders) !!},
            csrf             : '{{ csrf_token() }}'
        };
    </script>

    <script>
        // Auto-hide mensajes después de 30 segundos
        document.querySelectorAll('.msg-auto-hide').forEach(el => {
            setTimeout(() => {
                el.style.transition = 'opacity .6s';
                el.style.opacity    = '0';
                setTimeout(() => el.remove(), 600);
            }, 5000);
        });

        // Toggle subir / link / gallery en dialog upload
        const btnTipoFile     = document.getElementById('btn-tipo-file');
        const btnTipoLink     = document.getElementById('btn-tipo-link');
        const btnTipoGallery  = document.getElementById('btn-tipo-gallery');
        const uploadFileRow   = document.getElementById('upload-file-row');
        const uploadLinkRow   = document.getElementById('upload-link-row');
        const uploadGalleryRow = document.getElementById('upload-gallery-row');
        const inputFile       = document.getElementById('file');
        const inputUrl        = document.getElementById('file_url');
        const uploadForm      = document.querySelector('#dialog-subir form');

        function setUploadMode(mode) {
            // Reset todos
            [btnTipoFile, btnTipoLink, btnTipoGallery].forEach(b => b && b.classList.remove('active'));
            uploadFileRow.hidden    = true;
            uploadLinkRow.hidden    = true;
            uploadGalleryRow.hidden = true;
            if (inputFile) inputFile.required = false;
            if (inputUrl)  inputUrl.required  = false;

            if (mode === 'file') {
                btnTipoFile.classList.add('active');
                uploadFileRow.hidden = false;
                if (inputFile) inputFile.required = true;
                if (uploadForm) uploadForm.action = AX.urlUpload;
            } else if (mode === 'link') {
                btnTipoLink.classList.add('active');
                uploadLinkRow.hidden = false;
                if (inputUrl) inputUrl.required = true;
                if (uploadForm) uploadForm.action = AX.urlUpload;
            } else if (mode === 'gallery') {
                btnTipoGallery.classList.add('active');
                uploadGalleryRow.hidden = false;
                if (uploadForm) uploadForm.action = AX.urlUploadGallery;
            }
        }

        if (btnTipoFile)    btnTipoFile.addEventListener('click',    () => setUploadMode('file'));
        if (btnTipoLink)    btnTipoLink.addEventListener('click',    () => setUploadMode('link'));
        if (btnTipoGallery) btnTipoGallery.addEventListener('click', () => setUploadMode('gallery'));

        // Contador archivos gallery
        const galleryFilesInput = document.getElementById('gallery_files');
        const galleryFilesCount = document.getElementById('gallery_files_count');
        if (galleryFilesInput) {
            galleryFilesInput.addEventListener('change', () => {
                const n = galleryFilesInput.files.length;
                if (galleryFilesCount) galleryFilesCount.textContent = n > 0 ? n + ' image(s) selected' : '';
            });
        }
    </script>

@push('scripts')
    <script src="/vendor/ax-filebrowser/js/ax-filebrowser.js"></script>
@endpush
</div>