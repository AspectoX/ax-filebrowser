// ── Dialogs ────────────────────────────────────────────────────────────────

// Nueva carpeta
const dialogCarpeta = document.getElementById('dialog-nueva-carpeta');
const btnNuevaCarpeta = document.getElementById('btn-nueva-carpeta');
const btnCancelarCarpeta = document.getElementById('btn-cancelar-carpeta');
btnNuevaCarpeta.addEventListener('click', () => dialogCarpeta.showModal());
btnCancelarCarpeta.addEventListener('click', () => dialogCarpeta.close());
dialogCarpeta.addEventListener('click', (e) => { if (e.target === dialogCarpeta) dialogCarpeta.close(); });

// Subir archivo
const dialogSubir = document.getElementById('dialog-subir');
const btnSubir = document.getElementById('btn-subir');
const btnCancelarSubir = document.getElementById('btn-cancelar-subir');
btnSubir.addEventListener('click', () => dialogSubir.showModal());
btnCancelarSubir.addEventListener('click', () => dialogSubir.close());
dialogSubir.addEventListener('click', (e) => { if (e.target === dialogSubir) dialogSubir.close(); });

// Preview
const dialogPreview = document.getElementById('dialog-preview');
const btnCerrarPreview = document.getElementById('btn-cerrar-preview');
btnCerrarPreview.addEventListener('click', () => {
    dialogPreview.close();
    document.getElementById('preview-contenido').innerHTML = '';
});
dialogPreview.addEventListener('click', (e) => {
    if (e.target === dialogPreview) {
        dialogPreview.close();
        document.getElementById('preview-contenido').innerHTML = '';
    }
});

// ── Selección de archivos ──────────────────────────────────────────────────

const grilla = document.getElementById('grilla-archivos');
const btnDelete = document.getElementById('btn-delete');
const btnPreview = document.getElementById('btn-preview');
const btnEditImage = document.getElementById('btn-edit-image');
let selectedItems = [];

if (grilla) {
    grilla.addEventListener('click', (e) => {
        const item = e.target.closest('.file-item');
        if (!item) return;
        if (e.ctrlKey || e.metaKey) {
            item.classList.toggle('selected');
        } else {
            grilla.querySelectorAll('.file-item.selected').forEach(el => el.classList.remove('selected'));
            item.classList.add('selected');
        }
        selectedItems = Array.from(grilla.querySelectorAll('.file-item.selected'));
        actualizarBotonesToolbar();
    });

    grilla.addEventListener('dblclick', (e) => {
        const item = e.target.closest('.file-item');
        if (!item) return;
        // Doble click en carpeta → navegar
        if (item.dataset.type === 'folder') {
            window.location = AX.urlIndex + '?folder=' + encodeURIComponent(item.dataset.path);
            return;
        }
        // Doble click en imagen → galería o preview
        if (['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'avif'].includes(item.dataset.ext)) {
            galleryItems = buildGalleryItems();
            const idx = galleryItems.indexOf(item);
            openGallery(idx >= 0 ? idx : 0);
        } else {
            abrirPreview(item);
        }
    });
}

function actualizarBotonesToolbar() {
    const n = selectedItems.length;
    const esImagen = n === 1 && ['jpg', 'jpeg', 'png', 'gif', 'webp', 'avif'].includes(selectedItems[0]?.dataset.ext);
    btnDelete.disabled = n === 0;
    btnPreview.disabled = n !== 1;
    btnEditImage.disabled = !esImagen;
}

// ── Preview ────────────────────────────────────────────────────────────────

btnPreview.addEventListener('click', () => {
    if (selectedItems.length === 1) abrirPreview(selectedItems[0]);
});
function abrirPreview(item) {
    const url = item.dataset.url;
    const ext = item.dataset.ext;
    const name = item.dataset.name;
    const isExternal = item.dataset.external === 'true';
    const cont = document.getElementById('preview-contenido');
    const imgs = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'avif'];
    const vids = ['mp4', 'webm', 'ogg', 'mov'];
    const auds = ['mp3', 'wav', 'flac', 'aac'];

    cont.innerHTML = '';

    if (isExternal) {
        // Detectar servicio
        const ytMatch = url.match(/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/);
        const vimeoMatch = url.match(/vimeo\.com\/(\d+)/);
        const iframeExts = ['youtube.com', 'youtu.be', 'vimeo.com', 'dailymotion.com', 'twitch.tv'];
        const needsIframe = iframeExts.some(d => url.includes(d));

        if (ytMatch) {
            const iframe = document.createElement('iframe');
            iframe.src = 'https://www.youtube.com/embed/' + ytMatch[1] + '?autoplay=1';
            iframe.allow = 'autoplay; encrypted-media; fullscreen';
            iframe.allowFullscreen = true;
            cont.appendChild(iframe);
        } else if (vimeoMatch) {
            const iframe = document.createElement('iframe');
            iframe.src = 'https://player.vimeo.com/video/' + vimeoMatch[1] + '?autoplay=1';
            iframe.allow = 'autoplay; fullscreen';
            iframe.allowFullscreen = true;
            cont.appendChild(iframe);
        } else if (needsIframe) {
            const iframe = document.createElement('iframe');
            iframe.src = url;
            iframe.allowFullscreen = true;
            cont.appendChild(iframe);
        } else {
            // URL directa de video/audio
            const vid = document.createElement('video');
            vid.src = url;
            vid.controls = true;
            vid.autoplay = true;
            cont.appendChild(vid);
        }
    } else if (imgs.includes(ext)) {
        const img = document.createElement('img');
        img.src = url; img.alt = name;
        cont.appendChild(img);
    } else if (vids.includes(ext)) {
        const vid = document.createElement('video');
        vid.src = url; vid.controls = true; vid.autoplay = true;
        cont.appendChild(vid);
    } else if (auds.includes(ext)) {
        const aud = document.createElement('audio');
        aud.src = url; aud.controls = true; aud.autoplay = true;
        cont.appendChild(aud);
    } else if (ext === 'pdf') {
        const embed = document.createElement('embed');
        embed.src = url; embed.type = 'application/pdf';
        cont.appendChild(embed);
    } else {
        cont.innerHTML = '<p>Sin previsualización disponible</p>';
    }
    document.getElementById('preview-nombre').textContent = name;
    dialogPreview.showModal();
}
// ── Dialog Delete ──────────────────────────────────────────────────────────

const dialogDelete = document.getElementById('dialog-delete');
const btnConfirmarDelete = document.getElementById('btn-confirmar-delete');
const btnCancelarDelete = document.getElementById('btn-cancelar-delete');

// Dialog confirm folder
const dialogConfirmFolder = document.getElementById('dialog-confirm-folder');
const btnConfirmarFolderDelete = document.getElementById('btn-confirmar-folder-delete');
const btnCancelarFolderDelete = document.getElementById('btn-cancelar-folder-delete');
let pendingFolderPath = null;

if (btnCancelarFolderDelete) btnCancelarFolderDelete.addEventListener('click', () => dialogConfirmFolder.close());
if (dialogConfirmFolder) dialogConfirmFolder.addEventListener('click', (e) => { if (e.target === dialogConfirmFolder) dialogConfirmFolder.close(); });

if (btnConfirmarFolderDelete) {
    btnConfirmarFolderDelete.addEventListener('click', async () => {
        if (!pendingFolderPath) return;
        dialogConfirmFolder.close();
        await borrarCarpeta(pendingFolderPath, true);
        pendingFolderPath = null;
    });
}

async function borrarCarpeta(folderPath, force) {
    const formData = new FormData();
    formData.append('_token', AX.csrf);
    formData.append('folder_path', folderPath);
    if (force) formData.append('force', 'true');

    const res = await fetch(AX.urlFolderDelete, { method: 'POST', body: formData, headers: { 'X-Requested-With': 'XMLHttpRequest' } });
    const data = await res.json();

    if (data.has_content) {
        // Pedir confirmación
        pendingFolderPath = folderPath;
        document.getElementById('confirm-folder-name').textContent = folderPath.split('/').pop();
        dialogConfirmFolder.showModal();
    } else if (data.ok) {
        // Quitar del DOM
        const item = grilla.querySelector('.folder-item[data-path="' + folderPath + '"]');
        if (item) item.remove();
        // Quitar del sidebar también
        const sidebarLink = document.querySelector('#arbol-carpetas a[href*="folder=' + encodeURIComponent(folderPath) + '"]');
        if (sidebarLink) sidebarLink.closest('.sidebar-tree-item')?.remove();
    }
}

btnDelete.addEventListener('click', () => {
    if (selectedItems.length === 0) return;
    const names = selectedItems.map(i => i.dataset.name);
    document.getElementById('delete-msg').textContent =
        names.length === 1 ? 'Delete this item?' : 'Delete ' + names.length + ' items?';
    const list = document.getElementById('delete-list');
    list.innerHTML = '';
    names.forEach(n => { const li = document.createElement('li'); li.textContent = n; list.appendChild(li); });
    dialogDelete.showModal();
});

btnConfirmarDelete.addEventListener('click', async () => {
    if (selectedItems.length === 0) return;
    dialogDelete.close();

    const btn = document.getElementById('btn-confirmar-delete');
    btn.disabled = true;

    for (const item of selectedItems) {
        if (item.dataset.type === 'folder') {
            await borrarCarpeta(item.dataset.path, false);
        } else {
            if (selectedItems.length === 1 && !item.dataset.external) {
                document.getElementById('delete-file-path').value = item.dataset.path;
                document.getElementById('form-delete').submit();
                return;
            }
            const formData = new FormData();
            formData.append('_token', AX.csrf);
            formData.append('file_path', item.dataset.path);
            formData.append('current_folder', AX.currentFolder);
            const res = await fetch(AX.urlDeleteByPath, { method: 'POST', body: formData, headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            const data = await res.json();
            if (data.ok) item.remove();
        }
    }

    selectedItems = [];
    actualizarBotonesToolbar();
    btn.disabled = false;
});

btnCancelarDelete.addEventListener('click', () => dialogDelete.close());
dialogDelete.addEventListener('click', (e) => { if (e.target === dialogDelete) dialogDelete.close(); });

// ── Dialog Find ────────────────────────────────────────────────────────────

const dialogFind = document.getElementById('dialog-find');
const btnBuscar = document.getElementById('btn-buscar');
const btnCerrarFind = document.getElementById('btn-cerrar-find');
const findInput = document.getElementById('find-input');
const findResults = document.getElementById('find-results');

btnBuscar.addEventListener('click', () => {
    findInput.value = ''; findResults.innerHTML = '';
    dialogFind.showModal(); findInput.focus();
});
btnCerrarFind.addEventListener('click', () => dialogFind.close());
dialogFind.addEventListener('click', (e) => { if (e.target === dialogFind) dialogFind.close(); });

findInput.addEventListener('input', () => {
    const q = findInput.value.toLowerCase().trim();
    findResults.innerHTML = '';
    if (!q) return;
    const matches = Array.from(document.querySelectorAll('.file-item'))
        .filter(i => i.dataset.name.toLowerCase().includes(q));
    if (!matches.length) { findResults.innerHTML = '<p>Sin resultados</p>'; return; }
    const ul = document.createElement('ul');
    matches.forEach(item => {
        const li = document.createElement('li');
        li.textContent = item.dataset.name;
        li.style.cursor = 'pointer';
        li.addEventListener('click', () => {
            dialogFind.close();
            grilla.querySelectorAll('.file-item.selected').forEach(el => el.classList.remove('selected'));
            item.classList.add('selected');
            item.scrollIntoView({ behavior: 'smooth', block: 'center' });
            selectedItems = [item];
            actualizarBotonesToolbar();
        });
        ul.appendChild(li);
    });
    findResults.appendChild(ul);
});

// ── Dialog Filter ──────────────────────────────────────────────────────────

const dialogFilter = document.getElementById('dialog-filter');
const btnFilter = document.getElementById('btn-filter');
const btnAplicarFilter = document.getElementById('btn-aplicar-filter');
const btnLimpiarFilter = document.getElementById('btn-limpiar-filter');
const btnCerrarFilter = document.getElementById('btn-cerrar-filter');

btnFilter.addEventListener('click', () => dialogFilter.showModal());
btnCerrarFilter.addEventListener('click', () => dialogFilter.close());
dialogFilter.addEventListener('click', (e) => { if (e.target === dialogFilter) dialogFilter.close(); });

document.querySelectorAll('#filter-tipos .ax-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('#filter-tipos .ax-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
    });
});

btnAplicarFilter.addEventListener('click', () => {
    const tipo = document.querySelector('#filter-tipos .ax-btn.active')?.dataset.tipo || '';
    const ext = document.getElementById('filter-ext').value.toLowerCase().trim();
    const sizeMin = parseInt(document.getElementById('filter-size-min').value) || 0;
    const sizeMax = parseInt(document.getElementById('filter-size-max').value) || Infinity;

    document.querySelectorAll('.file-item').forEach(item => {
        let show = true;
        if (tipo && item.dataset.tipo !== tipo) show = false;
        if (ext && !item.dataset.ext.includes(ext)) show = false;
        const kb = parseInt(item.dataset.size || 0) / 1024;
        if (sizeMin && kb < sizeMin) show = false;
        if (sizeMax !== Infinity && kb > sizeMax) show = false;
        item.hidden = !show;
    });

    dialogFilter.close();
    btnFilter.classList.add('active');
});

btnLimpiarFilter.addEventListener('click', () => {
    document.querySelectorAll('#filter-tipos .ax-btn').forEach(b => b.classList.remove('active'));
    document.querySelector('#filter-tipos .ax-btn[data-tipo=""]').classList.add('active');
    ['filter-ext', 'filter-autor', 'filter-tags', 'filter-size-min', 'filter-size-max']
        .forEach(id => document.getElementById(id).value = '');
    document.querySelectorAll('.file-item').forEach(i => i.hidden = false);
    btnFilter.classList.remove('active');
});

// ── Dialog Edit Image ──────────────────────────────────────────────────────

const dialogEditImage = document.getElementById('dialog-edit-image');
const btnCerrarEdit = document.getElementById('btn-cerrar-edit');
const editCanvas = document.getElementById('edit-canvas');
const editCtx = editCanvas.getContext('2d');

let editImg = null;
let editBlobUrl = null;

// Ajustes CSS actuales (en tiempo real, no destructivos)
let adjBrightness = 0;
let adjContrast = 0;
let adjSaturation = 0;
let adjFiltro = '';  // filtro predefinido activo

// Filtros predefinidos
const FILTROS = {
    '': '',
    'grayscale': 'grayscale(100%)',
    'sepia': 'sepia(100%)',
    'invert': 'invert(100%)',
    'blur': 'blur(3px)',
    'vintage': 'sepia(50%) contrast(120%) brightness(90%) saturate(80%)',
    'cold': 'saturate(120%) hue-rotate(180deg) brightness(105%)',
    'warm': 'sepia(30%) saturate(140%) brightness(105%)',
    'fade': 'brightness(110%) saturate(60%) contrast(90%)',
    'dramatic': 'contrast(180%) brightness(85%) saturate(120%)',
    'noir': 'grayscale(100%) contrast(150%) brightness(85%)',
};

// Aplica CSS filter al canvas para preview en tiempo real
function aplicarCSSFilter() {
    const b = adjBrightness;
    const c = adjContrast;
    const s = adjSaturation;

    const cssBrightness = 1 + (b / 100);
    const cssContrast = 1 + (c / 100);
    const cssSaturate = 1 + (s / 100);

    let base = `brightness(${cssBrightness}) contrast(${cssContrast}) saturate(${cssSaturate})`;
    if (adjFiltro && FILTROS[adjFiltro]) {
        base = FILTROS[adjFiltro] + ' ' + base;
    }
    editCanvas.style.filter = base;
}

// Hornear el CSS filter al canvas antes de exportar/guardar
function hornearFiltros() {
    if (adjBrightness === 0 && adjContrast === 0 && adjSaturation === 0 && adjFiltro === '') return;
    const tmp = document.createElement('canvas');
    tmp.width = editCanvas.width;
    tmp.height = editCanvas.height;
    const tCtx = tmp.getContext('2d');
    tCtx.filter = editCanvas.style.filter;
    tCtx.drawImage(editCanvas, 0, 0);
    editCanvas.style.filter = 'none';
    editCtx.clearRect(0, 0, editCanvas.width, editCanvas.height);
    editCtx.drawImage(tmp, 0, 0);
    // Reset valores
    adjBrightness = adjContrast = adjSaturation = 0;
    adjFiltro = '';
    const selFiltro = document.getElementById('edit-filtro');
    if (selFiltro) selFiltro.value = '';
    ['brightness', 'contrast', 'saturation'].forEach(a => {
        document.getElementById('adj-' + a).value = 0;
        document.getElementById('adj-' + a + '-val').textContent = '0';
    });
}

function cargarImagenEnCanvas(url, callback) {
    fetch(url)
        .then(r => r.blob())
        .then(blob => {
            if (editBlobUrl) URL.revokeObjectURL(editBlobUrl);
            editBlobUrl = URL.createObjectURL(blob);
            const img = new Image();
            img.onload = () => {
                editImg = img;
                editCanvas.width = img.naturalWidth;
                editCanvas.height = img.naturalHeight;
                editCanvas.style.filter = 'none';
                editCtx.drawImage(img, 0, 0);
                if (callback) callback(img);
            };
            img.src = editBlobUrl;
        })
        .catch(() => alert('No se pudo cargar la imagen para editar.'));
}

btnEditImage.addEventListener('click', () => {
    if (selectedItems.length !== 1) return;
    const item = selectedItems[0];
    document.getElementById('edit-image-nombre').textContent = item.dataset.name;

    adjBrightness = adjContrast = adjSaturation = 0;
    adjFiltro = '';
    const selFiltro = document.getElementById('edit-filtro');
    if (selFiltro) selFiltro.value = '';
    ['brightness', 'contrast', 'saturation'].forEach(a => {
        document.getElementById('adj-' + a).value = 0;
        document.getElementById('adj-' + a + '-val').textContent = '0';
    });

    cargarImagenEnCanvas(item.dataset.url, (img) => {
        document.getElementById('resize-w').value = img.naturalWidth;
        document.getElementById('resize-h').value = img.naturalHeight;
        document.getElementById('crop-x').value = 0;
        document.getElementById('crop-y').value = 0;
        document.getElementById('crop-w').value = img.naturalWidth;
        document.getElementById('crop-h').value = img.naturalHeight;
    });

    dialogEditImage.showModal();
});

btnCerrarEdit.addEventListener('click', () => {
    dialogEditImage.close();
    editCanvas.style.filter = 'none';
    if (editBlobUrl) { URL.revokeObjectURL(editBlobUrl); editBlobUrl = null; }
});
dialogEditImage.addEventListener('click', (e) => {
    if (e.target === dialogEditImage) {
        dialogEditImage.close();
        editCanvas.style.filter = 'none';
        if (editBlobUrl) { URL.revokeObjectURL(editBlobUrl); editBlobUrl = null; }
    }
});

// Reset — recarga imagen original y limpia filtros
document.getElementById('btn-edit-reset').addEventListener('click', () => {
    if (!selectedItems.length) return;
    adjBrightness = adjContrast = adjSaturation = 0;
    cargarImagenEnCanvas(selectedItems[0].dataset.url, (img) => {
        document.getElementById('resize-w').value = img.naturalWidth;
        document.getElementById('resize-h').value = img.naturalHeight;
        ['brightness', 'contrast', 'saturation'].forEach(a => {
            document.getElementById('adj-' + a).value = 0;
            document.getElementById('adj-' + a + '-val').textContent = '0';
        });
        aplicarCSSFilter();
    });
});

// Acciones destructivas (rotar, voltear, recortar, redimensionar)
// Hornean los filtros primero para no perderlos
document.querySelectorAll('#dialog-edit-image [data-action]').forEach(btn => {
    btn.addEventListener('click', () => {
        const action = btn.dataset.action;

        // Acciones destructivas: hornear filtros CSS al canvas antes
        if (['rotate-left', 'rotate-right', 'flip-h', 'flip-v', 'crop', 'resize'].includes(action)) {
            hornearFiltros();
        }

        const w = editCanvas.width;
        const h = editCanvas.height;
        const tmp = document.createElement('canvas');
        const tCtx = tmp.getContext('2d');

        if (action === 'rotate-left' || action === 'rotate-right') {
            tmp.width = h; tmp.height = w;
            tCtx.translate(tmp.width / 2, tmp.height / 2);
            tCtx.rotate((action === 'rotate-left' ? -1 : 1) * Math.PI / 2);
            tCtx.drawImage(editCanvas, -w / 2, -h / 2);
            editCanvas.width = tmp.width; editCanvas.height = tmp.height;
            editCtx.drawImage(tmp, 0, 0);

        } else if (action === 'flip-h') {
            tmp.width = w; tmp.height = h;
            tCtx.translate(w, 0); tCtx.scale(-1, 1);
            tCtx.drawImage(editCanvas, 0, 0);
            editCtx.clearRect(0, 0, w, h);
            editCtx.drawImage(tmp, 0, 0);

        } else if (action === 'flip-v') {
            tmp.width = w; tmp.height = h;
            tCtx.translate(0, h); tCtx.scale(1, -1);
            tCtx.drawImage(editCanvas, 0, 0);
            editCtx.clearRect(0, 0, w, h);
            editCtx.drawImage(tmp, 0, 0);

        } else if (action === 'crop') {
            const cx = parseInt(document.getElementById('crop-x').value) || 0;
            const cy = parseInt(document.getElementById('crop-y').value) || 0;
            const cw = Math.min(parseInt(document.getElementById('crop-w').value) || w, w - cx);
            const ch = Math.min(parseInt(document.getElementById('crop-h').value) || h, h - cy);
            const imgData = editCtx.getImageData(cx, cy, cw, ch);
            editCanvas.width = cw; editCanvas.height = ch;
            editCtx.putImageData(imgData, 0, 0);
            document.getElementById('crop-x').value = 0;
            document.getElementById('crop-y').value = 0;
            document.getElementById('crop-w').value = cw;
            document.getElementById('crop-h').value = ch;

        } else if (action === 'resize') {
            const rw = parseInt(document.getElementById('resize-w').value) || w;
            const rh = parseInt(document.getElementById('resize-h').value) || h;
            tmp.width = rw; tmp.height = rh;
            tCtx.drawImage(editCanvas, 0, 0, rw, rh);
            editCanvas.width = rw; editCanvas.height = rh;
            editCtx.drawImage(tmp, 0, 0);

        } else if (action === 'apply-adjustments') {
            // Hornear al canvas y resetear sliders
            hornearFiltros();
        }
    });
});

// Sliders en tiempo real via CSS filter
['brightness', 'contrast', 'saturation'].forEach(adj => {
    const input = document.getElementById('adj-' + adj);
    const span = document.getElementById('adj-' + adj + '-val');
    if (!input) return;
    input.addEventListener('input', () => {
        const val = parseInt(input.value);
        span.textContent = val;
        if (adj === 'brightness') adjBrightness = val;
        if (adj === 'contrast') adjContrast = val;
        if (adj === 'saturation') adjSaturation = val;
        aplicarCSSFilter();
    });
});

// Select filtros predefinidos
const selFiltroEdit = document.getElementById('edit-filtro');
if (selFiltroEdit) {
    selFiltroEdit.addEventListener('change', () => {
        adjFiltro = selFiltroEdit.value;
        aplicarCSSFilter();
    });
}

// Calidad
const qualityInput = document.getElementById('edit-quality');
const qualityVal = document.getElementById('edit-quality-val');
qualityInput.addEventListener('input', () => qualityVal.textContent = qualityInput.value + '%');

// Mantener proporción
const resizeW = document.getElementById('resize-w');
const resizeH = document.getElementById('resize-h');
resizeW.addEventListener('input', () => {
    if (document.getElementById('resize-ratio').checked && editImg) {
        const ratio = editImg.naturalHeight / editImg.naturalWidth;
        resizeH.value = Math.round(parseInt(resizeW.value) * ratio);
    }
});
resizeH.addEventListener('input', () => {
    if (document.getElementById('resize-ratio').checked && editImg) {
        const ratio = editImg.naturalWidth / editImg.naturalHeight;
        resizeW.value = Math.round(parseInt(resizeH.value) * ratio);
    }
});

// Descargar
document.getElementById('btn-edit-download').addEventListener('click', () => {
    hornearFiltros(); // hornear CSS filter antes de exportar
    const fmt = document.getElementById('edit-format').value;
    const qual = parseInt(document.getElementById('edit-quality').value) / 100;
    const ext = fmt === 'image/jpeg' ? 'jpg' : fmt === 'image/png' ? 'png' : 'webp';
    const name = selectedItems[0]?.dataset.name || 'edited';
    const base = name.replace(/\.[^.]+$/, '');
    const a = document.createElement('a');
    a.href = editCanvas.toDataURL(fmt, qual);
    a.download = base + '_edited.' + ext;
    a.click();
});

// Guardar en servidor
document.getElementById('btn-edit-save').addEventListener('click', () => {
    if (!selectedItems.length) return;
    hornearFiltros(); // hornear CSS filter antes de guardar
    const fmt = document.getElementById('edit-format').value;
    const qual = parseInt(document.getElementById('edit-quality').value) / 100;
    const overwrite = document.getElementById('edit-overwrite').checked;
    const dataUrl = editCanvas.toDataURL(fmt, qual);
    const filePath = selectedItems[0].dataset.path;

    const btnSave = document.getElementById('btn-edit-save');
    btnSave.disabled = true;
    btnSave.textContent = 'Guardando...';

    fetch(AX.urlSaveEdit, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': AX.csrf },
        body: JSON.stringify({ image: dataUrl, file_path: filePath, overwrite, format: fmt })
    })
        .then(r => r.json())
        .then(data => {
            if (data.ok) {
                dialogEditImage.close();
                location.reload();
            } else {
                alert('Error: ' + (data.error || 'desconocido'));
            }
        })
        .catch(() => alert('Error de conexión al guardar'))
        .finally(() => {
            btnSave.disabled = false;
            btnSave.textContent = 'Guardar imagen';
        });
});

// ── Miniaturas de video ────────────────────────────────────────────────────

function generarMiniaturaDesdeVideo(videoEl) {
    const hacerCaptura = () => {
        try {
            const canvas = document.createElement('canvas');
            canvas.width = videoEl.videoWidth || 160;
            canvas.height = videoEl.videoHeight || 90;
            canvas.getContext('2d').drawImage(videoEl, 0, 0, canvas.width, canvas.height);
            const img = document.createElement('img');
            img.src = canvas.toDataURL('image/jpeg', 0.75);
            img.alt = '';
            videoEl.replaceWith(img);
        } catch (e) {
            // CORS u otro error — dejar el video como está
        }
    };

    if (videoEl.readyState >= 2) {
        videoEl.currentTime = 1;
    } else {
        videoEl.addEventListener('loadeddata', () => { videoEl.currentTime = 1; }, { once: true });
    }
    videoEl.addEventListener('seeked', hacerCaptura, { once: true });
}

// Videos físicos (.mp4 etc)
document.querySelectorAll('#grilla-archivos .video-thumb').forEach(vid => {
    generarMiniaturaDesdeVideo(vid);
});

// URLs externas — generar miniatura via canvas con video oculto
document.querySelectorAll('#grilla-archivos .video-thumb-canvas').forEach(canvas => {
    const url = canvas.dataset.url;
    if (!url) return;

    // Para YouTube extraer thumbnail de la API pública
    const ytMatch = url.match(/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/);
    if (ytMatch) {
        const img = document.createElement('img');
        img.src = 'https://img.youtube.com/vi/' + ytMatch[1] + '/mqdefault.jpg';
        img.alt = '';
        canvas.replaceWith(img);
        return;
    }

    // Para Vimeo usar oEmbed thumbnail
    const vimeoMatch = url.match(/vimeo\.com\/(\d+)/);
    if (vimeoMatch) {
        fetch('https://vimeo.com/api/v2/video/' + vimeoMatch[1] + '.json')
            .then(r => r.json())
            .then(data => {
                const img = document.createElement('img');
                img.src = data[0].thumbnail_medium;
                img.alt = '';
                canvas.replaceWith(img);
            })
            .catch(() => {
                canvas.replaceWith(crearIconoLink());
            });
        return;
    }

    // Para otras URLs — intentar video oculto
    const vid = document.createElement('video');
    vid.src = url;
    vid.muted = true;
    vid.crossOrigin = 'anonymous';
    vid.style.display = 'none';
    vid.currentTime = 1;
    document.body.appendChild(vid);
    vid.addEventListener('seeked', () => {
        try {
            canvas.width = vid.videoWidth || 160;
            canvas.height = vid.videoHeight || 90;
            canvas.getContext('2d').drawImage(vid, 0, 0, canvas.width, canvas.height);
            const img = document.createElement('img');
            img.src = canvas.toDataURL('image/jpeg', 0.75);
            img.alt = '';
            canvas.replaceWith(img);
        } catch (e) {
            canvas.replaceWith(crearIconoLink());
        }
        vid.remove();
    }, { once: true });
    vid.addEventListener('error', () => {
        canvas.replaceWith(crearIconoLink());
        vid.remove();
    }, { once: true });
});

function crearIconoLink() {
    const span = document.createElement('span');
    span.textContent = '▶';
    span.className = 'file-icon-video';
    return span;
}

// ── Vista grilla / lista ───────────────────────────────────────────────────

const btnGrilla = document.getElementById('btn-vista-grilla');
const btnLista = document.getElementById('btn-vista-lista');

if (grilla && btnGrilla && btnLista) {
    btnGrilla.addEventListener('click', () => {
        grilla.setAttribute('data-vista', 'grilla');
        btnGrilla.classList.add('active');
        btnLista.classList.remove('active');
    });
    btnLista.addEventListener('click', () => {
        grilla.setAttribute('data-vista', 'lista');
        btnLista.classList.add('active');
        btnGrilla.classList.remove('active');
    });
}

// ── Reload ─────────────────────────────────────────────────────────────────

document.getElementById('btn-reload').addEventListener('click', () => location.reload());

// ── Botón subir un nivel ───────────────────────────────────────────────────

const btnUp = document.getElementById('btn-up');
if (btnUp && !btnUp.disabled) {
    btnUp.addEventListener('click', () => {
        const parts = AX.currentFolder.split('/');
        parts.pop();
        const parent = parts.join('/');
        window.location = AX.urlIndex + (parent ? '?folder=' + parent : '');
    });
}

// ── Ordenar ────────────────────────────────────────────────────────────────

let sortDir = {};

document.querySelectorAll('.btn-sort').forEach(btn => {
    btn.addEventListener('click', () => {
        if (!grilla) return;
        const sort = btn.dataset.sort;
        sortDir[sort] = sortDir[sort] === 'asc' ? 'desc' : 'asc';
        const dir = sortDir[sort];

        document.querySelectorAll('.btn-sort').forEach(b => b.classList.remove('active', 'sort-asc', 'sort-desc'));
        btn.classList.add('active', dir === 'asc' ? 'sort-asc' : 'sort-desc');

        const items = Array.from(grilla.querySelectorAll('.file-item'));
        items.sort((a, b) => {
            if (sort === 'name') {
                const va = a.dataset.name.toLowerCase(), vb = b.dataset.name.toLowerCase();
                return dir === 'asc' ? va.localeCompare(vb) : vb.localeCompare(va);
            }
            if (sort === 'size') {
                const va = parseInt(a.dataset.size || 0), vb = parseInt(b.dataset.size || 0);
                return dir === 'asc' ? va - vb : vb - va;
            }
            if (sort === 'date') {
                const va = parseInt(a.dataset.date || 0), vb = parseInt(b.dataset.date || 0);
                return dir === 'asc' ? va - vb : vb - va;
            }
            return 0;
        });
        items.forEach(i => grilla.appendChild(i));
    });
});

// ── Cursor del textarea (para el picker del blog) ─────────────────────────

// Esta función debe llamarse desde el blog ANTES de abrir el popup
// Uso: <button onclick="guardarCursor('body'); abrirPicker()">Insertar</button>
let pickerCursorPos = null;
let pickerTextareaId = null;

function guardarCursor(textareaId) {
    const ta = document.getElementById(textareaId);
    if (ta) {
        pickerTextareaId = textareaId;
        pickerCursorPos = ta.selectionStart;
    }
}

// Esta función la llama el picker al seleccionar un archivo
// Reemplaza la función insertarArchivo del blog
function insertarArchivo(code, url, name) {
    if (!pickerTextareaId) return;
    const ta = document.getElementById(pickerTextareaId);
    if (!ta) return;
    const pos = pickerCursorPos !== null ? pickerCursorPos : ta.value.length;
    ta.value = ta.value.slice(0, pos) + code + ta.value.slice(pos);
    const newPos = pos + code.length;
    ta.focus();
    ta.setSelectionRange(newPos, newPos);
    pickerCursorPos = newPos;
}

// ── Disk usage ─────────────────────────────────────────────────────────────

(function () {
    const items = Array.from(document.querySelectorAll('.file-item'));
    const totalBytes = items.reduce((sum, i) => sum + parseInt(i.dataset.size || 0), 0);

    const fmt = b => {
        if (b >= 1073741824) return (b / 1073741824).toFixed(1) + ' GB';
        if (b >= 1048576) return (b / 1048576).toFixed(1) + ' MB';
        if (b >= 1024) return (b / 1024).toFixed(1) + ' KB';
        return b + ' B';
    };

    fetch(AX.urlDiskUsage)
        .then(r => r.json())
        .then(data => {
            document.getElementById('usage-label').textContent = fmt(totalBytes) + ' en esta carpeta · ' + data.label;
            document.getElementById('usage-bar').style.width = data.percent + '%';
        })
        .catch(() => {
            document.getElementById('usage-label').textContent = fmt(totalBytes) + ' en esta carpeta';
            document.getElementById('usage-bar').style.width = '0%';
        });
})();
// ── Gallery / Slideshow ────────────────────────────────────────────────────

const dialogGallery = document.getElementById('dialog-gallery');
const btnGallery = document.getElementById('btn-gallery');
const btnCerrarGallery = document.getElementById('btn-cerrar-gallery');
const galleryImg = document.getElementById('gallery-img');
const galleryNombre = document.getElementById('gallery-nombre');
const galleryCounter = document.getElementById('gallery-counter');
const galleryDetails = document.getElementById('gallery-details');
const galleryThumbs = document.getElementById('gallery-thumbs');
const galleryInsert = document.getElementById('gallery-insert'); // solo en picker

let galleryItems = [];
let galleryIndex = 0;

function buildGalleryItems() {
    return Array.from(document.querySelectorAll('.file-item'))
        .filter(i => ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'avif'].includes(i.dataset.ext))
        .filter(i => !i.hidden);
}

function galleryShow(index) {
    if (!galleryItems.length) return;
    galleryIndex = (index + galleryItems.length) % galleryItems.length;
    const item = galleryItems[galleryIndex];

    galleryImg.src = item.dataset.url;
    galleryImg.alt = item.dataset.name;
    galleryNombre.textContent = item.dataset.name;
    galleryCounter.textContent = (galleryIndex + 1) + ' / ' + galleryItems.length;

    const kb = parseInt(item.dataset.size || 0) / 1024;
    galleryDetails.textContent = kb >= 1024
        ? (kb / 1024).toFixed(1) + ' MB'
        : kb.toFixed(1) + ' KB';

    // Thumbs — marcar activo
    galleryThumbs.querySelectorAll('.gallery-thumb').forEach((t, i) => {
        t.classList.toggle('active', i === galleryIndex);
    });

    // Si estamos en el picker, actualizar el botón insert
    if (galleryInsert) {
        galleryInsert.onclick = () => {
            const code = '<img src="' + item.dataset.url + '" alt="' + item.dataset.name + '" class="img-article">';
            const cb = typeof PICKER_CALLBACK !== 'undefined' ? PICKER_CALLBACK : null;
            if (cb && window.opener && typeof window.opener[cb] === 'function') {
                window.opener[cb](code, item.dataset.url, item.dataset.name);
                window.close();
            } else if (cb && window.parent !== window && typeof window.parent[cb] === 'function') {
                window.parent[cb](code, item.dataset.url, item.dataset.name);
            }
        };
    }
}

function openGallery(startIndex) {
    galleryItems = buildGalleryItems();
    if (!galleryItems.length) return;

    // Construir thumbnails
    galleryThumbs.innerHTML = '';
    galleryItems.forEach((item, i) => {
        const img = document.createElement('img');
        img.src = item.dataset.url;
        img.alt = item.dataset.name;
        img.className = 'gallery-thumb';
        img.addEventListener('click', () => galleryShow(i));
        galleryThumbs.appendChild(img);
    });

    galleryShow(startIndex || 0);
    dialogGallery.showModal();
}

// Botón gallery en toolbar
if (btnGallery) {
    btnGallery.addEventListener('click', () => {
        // Si hay un item seleccionado, abrir desde ese
        const sel = selectedItems.length ? galleryItems.indexOf(selectedItems[0]) : 0;
        openGallery(sel >= 0 ? sel : 0);
    });
}

// Cerrar
if (btnCerrarGallery) {
    btnCerrarGallery.addEventListener('click', () => dialogGallery.close());
}
if (dialogGallery) {
    dialogGallery.addEventListener('click', (e) => { if (e.target === dialogGallery) dialogGallery.close(); });
}

// Navegación botones
const galleryPrev = document.getElementById('gallery-prev');
const galleryNext = document.getElementById('gallery-next');
if (galleryPrev) galleryPrev.addEventListener('click', () => galleryShow(galleryIndex - 1));
if (galleryNext) galleryNext.addEventListener('click', () => galleryShow(galleryIndex + 1));

// Navegación teclado
document.addEventListener('keydown', (e) => {
    if (!dialogGallery || !dialogGallery.open) return;
    if (e.key === 'ArrowLeft') galleryShow(galleryIndex - 1);
    if (e.key === 'ArrowRight') galleryShow(galleryIndex + 1);
    if (e.key === 'Escape') dialogGallery.close();
});

// Doble click en imagen de grilla abre galería directamente en esa imagen
if (grilla) {
    grilla.addEventListener('dblclick', (e) => {
        const item = e.target.closest('.file-item');
        if (!item) return;
        if (['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'avif'].includes(item.dataset.ext)) {
            galleryItems = buildGalleryItems();
            const idx = galleryItems.indexOf(item);
            openGallery(idx >= 0 ? idx : 0);
        } else {
            abrirPreview(item);
        }
    });
}

// Habilitar botón gallery según carpeta
if (btnGallery && typeof AX !== 'undefined' && AX.isGalleryFolder) {
    btnGallery.disabled = false;
}

// En picker: también habilitar al seleccionar imágenes
if (!btnGallery && dialogGallery) {
    // Estamos en el picker — abrir galería con click en thumbnail
    document.querySelectorAll('.picker-card').forEach((card, cardIdx) => {
        card.addEventListener('dblclick', () => {
            const item = card.closest('.file-item');
            if (item && ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'avif'].includes(item.dataset.ext)) {
                galleryItems = buildGalleryItems();
                const idx = galleryItems.indexOf(item);
                openGallery(idx >= 0 ? idx : 0);
            }
        });
    });
}
// ── Crop manual con manejadores ────────────────────────────────────────────

const btnCropManual = document.getElementById('btn-crop-manual');
const cropOverlay = document.getElementById('crop-overlay');
const cropRect = document.getElementById('crop-rect');

if (btnCropManual && cropOverlay && cropRect) {

    let cropActive = false;
    let dragging = null;   // handle que se está arrastrando
    let cropX = 0, cropY = 0, cropW = 0, cropH = 0;
    let startMx, startMy, startCropX, startCropY, startCropW, startCropH;

    function updateCropRect() {
        cropRect.style.left = cropX + 'px';
        cropRect.style.top = cropY + 'px';
        cropRect.style.width = cropW + 'px';
        cropRect.style.height = cropH + 'px';
        // Actualizar inputs
        const scaleX = editCanvas.width / editCanvas.offsetWidth;
        const scaleY = editCanvas.height / editCanvas.offsetHeight;
        document.getElementById('crop-x').value = Math.round(cropX * scaleX);
        document.getElementById('crop-y').value = Math.round(cropY * scaleY);
        document.getElementById('crop-w').value = Math.round(cropW * scaleX);
        document.getElementById('crop-h').value = Math.round(cropH * scaleY);
    }

    btnCropManual.addEventListener('click', () => {
        if (!editCanvas) return;
        cropActive = true;
        // Inicializar rect al tamaño del canvas visible
        cropX = 0; cropY = 0;
        cropW = editCanvas.offsetWidth;
        cropH = editCanvas.offsetHeight;
        cropOverlay.hidden = false;
        updateCropRect();
    });

    // Escape cancela
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && cropActive) {
            cropActive = false;
            cropOverlay.hidden = true;
            dragging = null;
        }
    });

    // Doble click en overlay → ejecutar crop
    cropOverlay.addEventListener('dblclick', (e) => {
        if (!cropActive) return;
        e.preventDefault();
        // Ejecutar el crop con los valores actuales de los inputs
        const btn = cropRect.querySelector ? document.querySelector('#dialog-edit-image [data-action="crop"]') : null;
        if (btn) btn.click();
        cropActive = false;
        cropOverlay.hidden = true;
    });

    // Drag en handles y movimiento del rectángulo completo
    let moving = false;

    cropRect.addEventListener('mousedown', (e) => {
        e.preventDefault();
        startMx = e.clientX;
        startMy = e.clientY;
        startCropX = cropX;
        startCropY = cropY;
        startCropW = cropW;
        startCropH = cropH;

        const handle = e.target.closest('.crop-handle');
        if (handle) {
            dragging = handle.dataset.pos;
            moving = false;
        } else {
            // Click en el interior del rect → mover
            moving = true;
            dragging = null;
        }
    });

    document.addEventListener('mousemove', (e) => {
        if (!dragging && !moving) return;
        const dx = e.clientX - startMx;
        const dy = e.clientY - startMy;
        const ratio = startCropW / startCropH;
        const proportional = e.ctrlKey;
        const minSize = 20;

        // Límites del canvas visible
        const maxW = editCanvas.offsetWidth;
        const maxH = editCanvas.offsetHeight;

        if (moving) {
            // Mover el rectángulo completo
            cropX = Math.max(0, Math.min(maxW - cropW, startCropX + dx));
            cropY = Math.max(0, Math.min(maxH - cropH, startCropY + dy));
            updateCropRect();
            return;
        }

        let nx = startCropX, ny = startCropY, nw = startCropW, nh = startCropH;

        if (dragging === 'br') {
            nw = Math.max(minSize, startCropW + dx);
            nh = proportional ? nw / ratio : Math.max(minSize, startCropH + dy);
        } else if (dragging === 'bl') {
            nw = Math.max(minSize, startCropW - dx);
            nh = proportional ? nw / ratio : Math.max(minSize, startCropH + dy);
            nx = startCropX + startCropW - nw;
        } else if (dragging === 'tr') {
            nw = Math.max(minSize, startCropW + dx);
            nh = proportional ? nw / ratio : Math.max(minSize, startCropH - dy);
            ny = startCropY + startCropH - nh;
        } else if (dragging === 'tl') {
            nw = Math.max(minSize, startCropW - dx);
            nh = proportional ? nw / ratio : Math.max(minSize, startCropH - dy);
            nx = startCropX + startCropW - nw;
            ny = startCropY + startCropH - nh;
        } else if (dragging === 'tc') {
            nh = Math.max(minSize, startCropH - dy);
            if (proportional) { nw = nh * ratio; nx = startCropX + (startCropW - nw) / 2; }
            ny = startCropY + startCropH - nh;
        } else if (dragging === 'bc') {
            nh = Math.max(minSize, startCropH + dy);
            if (proportional) { nw = nh * ratio; nx = startCropX + (startCropW - nw) / 2; }
        } else if (dragging === 'ml') {
            nw = Math.max(minSize, startCropW - dx);
            if (proportional) { nh = nw / ratio; ny = startCropY + (startCropH - nh) / 2; }
            nx = startCropX + startCropW - nw;
        } else if (dragging === 'mr') {
            nw = Math.max(minSize, startCropW + dx);
            if (proportional) { nh = nw / ratio; ny = startCropY + (startCropH - nh) / 2; }
        }

        // Mantener dentro del canvas
        nx = Math.max(0, nx);
        ny = Math.max(0, ny);
        nw = Math.min(nw, maxW - nx);
        nh = Math.min(nh, maxH - ny);

        cropX = nx; cropY = ny; cropW = nw; cropH = nh;
        updateCropRect();
    });

    document.addEventListener('mouseup', () => { dragging = null; moving = false; });
}
// ── Rename / Move / Copy / Panel info ─────────────────────────────────────

const btnRename = document.getElementById('btn-rename');
const btnMove = document.getElementById('btn-move');
const btnCopy = document.getElementById('btn-copy');

// ── Panel lateral info/rename ──────────────────────────────────────────────

const panelInfo = document.getElementById('panel-info');
const btnCerrarPanel = document.getElementById('btn-cerrar-panel-info');
let panelCurrentItem = null;
let panelCurrentMeta = null;
let panelTags = [];

function abrirPanel(item) {
    panelCurrentItem = item;
    panelTags = [];
    panelInfo.hidden = false;

    // Datos básicos
    const name = item.dataset.name || item.dataset.path?.split('/').pop() || '';
    document.getElementById('pi-new-name').value = name;
    document.getElementById('pi-name').textContent = name;
    document.getElementById('pi-size').textContent = item.dataset.size
        ? (parseInt(item.dataset.size) / 1024).toFixed(1) + ' KB' : '—';
    document.getElementById('pi-date').textContent = item.dataset.date
        ? new Date(parseInt(item.dataset.date) * 1000).toLocaleDateString() : '—';

    // Thumbnail
    const thumb = document.getElementById('panel-info-thumb');
    thumb.innerHTML = '';
    const imgs = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'avif'];
    if (imgs.includes(item.dataset.ext)) {
        const img = document.createElement('img');
        img.src = item.dataset.url;
        thumb.appendChild(img);
    }

    // Dimensiones
    const dimsRow = document.getElementById('pi-dims-row');
    dimsRow.hidden = true;

    // Limpiar campos
    ['pi-autor', 'pi-credito', 'pi-epigrafe', 'pi-fecha'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.value = '';
    });
    renderTags([]);

    // Cargar metadata
    const path = item.dataset.external === 'true' ? item.dataset.url : item.dataset.path;
    fetch(AX.urlMetadataFetch + '?path=' + encodeURIComponent(path))
        .then(r => r.json())
        .then(data => {
            if (data.metadata) {
                const m = data.metadata;
                document.getElementById('pi-autor').value = m.autor || '';
                document.getElementById('pi-credito').value = m.credito_url || '';
                document.getElementById('pi-epigrafe').value = m.epigrafe || '';
                document.getElementById('pi-fecha').value = m.fecha_archivo || '';
                panelTags = m.tags ? m.tags.split(',').map(t => t.trim()).filter(Boolean) : [];
                renderTags(panelTags);
            }
            if (data.file?.width) {
                document.getElementById('pi-dims').textContent = data.file.width + ' × ' + data.file.height + ' px';
                dimsRow.hidden = false;
            }
        });
}

function renderTags(tags) {
    const list = document.getElementById('pi-tags-list');
    list.innerHTML = '';
    tags.forEach((tag, i) => {
        const chip = document.createElement('span');
        chip.className = 'tag-chip';
        chip.textContent = tag;
        const x = document.createElement('button');
        x.type = 'button';
        x.textContent = '×';
        x.addEventListener('click', () => {
            panelTags.splice(i, 1);
            renderTags(panelTags);
        });
        chip.appendChild(x);
        list.appendChild(chip);
    });
}

// Input tags — Enter agrega
const piTagsInput = document.getElementById('pi-tags-input');
if (piTagsInput) {
    piTagsInput.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ',') {
            e.preventDefault();
            const val = piTagsInput.value.trim().replace(/,$/, '');
            if (val && !panelTags.includes(val)) {
                panelTags.push(val);
                renderTags(panelTags);
            }
            piTagsInput.value = '';
        }
    });
}

if (btnCerrarPanel) {
    btnCerrarPanel.addEventListener('click', () => {
        panelInfo.hidden = true;
        panelCurrentItem = null;
    });
}

// Guardar desde panel
const btnPiSave = document.getElementById('btn-pi-save');
if (btnPiSave) {
    btnPiSave.addEventListener('click', async () => {
        if (!panelCurrentItem) return;

        const newName = document.getElementById('pi-new-name').value.trim();
        const oldName = panelCurrentItem.dataset.name;
        const oldPath = panelCurrentItem.dataset.path;
        const isFolder = panelCurrentItem.dataset.type === 'folder';
        const isExtUrl = panelCurrentItem.dataset.external === 'true';

        // Rename si cambió el nombre
        if (newName && newName !== oldName) {
            const fd = new FormData();
            fd.append('_token', AX.csrf);
            fd.append('old_path', oldPath);
            fd.append('new_name', newName);
            fd.append('type', isFolder ? 'folder' : 'file');
            const res = await fetch(AX.urlRename, { method: 'POST', body: fd });
            const data = await res.json();
            if (!data.ok) { alert('Rename error: ' + data.error); return; }
            panelCurrentItem.dataset.name = data.new_name;
            panelCurrentItem.dataset.path = data.new_path;
            panelCurrentItem.querySelector('.file-name').textContent = data.new_name;
        }

        // Guardar metadata
        const dbPath = isExtUrl ? panelCurrentItem.dataset.url : 'uploads/' + panelCurrentItem.dataset.path;
        const body = JSON.stringify({
            file_path: dbPath,
            original_name: newName || oldName,
            autor: document.getElementById('pi-autor').value,
            credito_url: document.getElementById('pi-credito').value,
            epigrafe: document.getElementById('pi-epigrafe').value,
            tags: panelTags.join(','),
            fecha_archivo: document.getElementById('pi-fecha').value,
        });
        await fetch(AX.urlMetadataSave, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': AX.csrf },
            body,
        });

        panelInfo.hidden = true;
    });
}

document.getElementById('btn-pi-cancel')?.addEventListener('click', () => {
    panelInfo.hidden = true;
});

// Abrir panel al click en Rename
if (btnRename) {
    btnRename.addEventListener('click', () => {
        if (selectedItems.length !== 1) return;
        abrirPanel(selectedItems[0]);
    });
}

// ── Move ───────────────────────────────────────────────────────────────────

const dialogMove = document.getElementById('dialog-move');
const btnConfirmarMove = document.getElementById('btn-confirmar-move');
const btnCancelarMove = document.getElementById('btn-cancelar-move');
let moveDestFolder = '';

function buildFolderTreePicker(containerId) {
    const container = document.getElementById(containerId);
    if (!container || !AX.allFolders) return;
    container.innerHTML = '';

    // Raíz
    const root = document.createElement('div');
    root.className = 'tree-item';
    root.textContent = AX.allFolders.length ? '/ (root)' : '/ (root)';
    root.dataset.path = '';
    root.classList.add('selected');
    container.appendChild(root);

    AX.allFolders.forEach(item => {
        const div = document.createElement('div');
        div.className = 'tree-item';
        div.textContent = item.name;
        div.dataset.path = item.path;
        div.style.paddingLeft = ((item.depth + 1) * 14) + 'px';
        container.appendChild(div);
    });

    container.addEventListener('click', (e) => {
        const item = e.target.closest('.tree-item');
        if (!item) return;
        container.querySelectorAll('.tree-item').forEach(i => i.classList.remove('selected'));
        item.classList.add('selected');
        return item.dataset.path;
    });
}

if (btnMove) {
    btnMove.addEventListener('click', () => {
        if (selectedItems.length === 0) return;
        document.getElementById('move-source-name').textContent =
            selectedItems.map(i => i.dataset.name).join(', ');
        buildFolderTreePicker('move-folder-tree');
        dialogMove.showModal();
    });
}

if (btnConfirmarMove) {
    btnConfirmarMove.addEventListener('click', async () => {
        const selected = document.querySelector('#move-folder-tree .tree-item.selected');
        const dest = selected ? selected.dataset.path : '';
        dialogMove.close();

        for (const item of selectedItems) {
            const fd = new FormData();
            fd.append('_token', AX.csrf);
            fd.append('source_path', item.dataset.path);
            fd.append('dest_folder', dest);
            fd.append('type', item.dataset.type === 'folder' ? 'folder' : 'file');
            const res = await fetch(AX.urlMove, { method: 'POST', body: fd });
            const data = await res.json();
            if (data.ok) item.remove();
            else alert('Move error: ' + data.error);
        }
        selectedItems = [];
        actualizarBotonesToolbar();
    });
}

if (btnCancelarMove) btnCancelarMove.addEventListener('click', () => dialogMove.close());
if (dialogMove) dialogMove.addEventListener('click', (e) => { if (e.target === dialogMove) dialogMove.close(); });

// ── Copy ───────────────────────────────────────────────────────────────────

const dialogCopy = document.getElementById('dialog-copy');
const btnConfirmarCopy = document.getElementById('btn-confirmar-copy');
const btnCancelarCopy = document.getElementById('btn-cancelar-copy');

if (btnCopy) {
    btnCopy.addEventListener('click', () => {
        if (selectedItems.length === 0) return;
        document.getElementById('copy-source-name').textContent =
            selectedItems.map(i => i.dataset.name).join(', ');
        buildFolderTreePicker('copy-folder-tree');
        dialogCopy.showModal();
    });
}

if (btnConfirmarCopy) {
    btnConfirmarCopy.addEventListener('click', async () => {
        const selected = document.querySelector('#copy-folder-tree .tree-item.selected');
        const dest = selected ? selected.dataset.path : '';
        dialogCopy.close();

        for (const item of selectedItems) {
            const fd = new FormData();
            fd.append('_token', AX.csrf);
            fd.append('source_path', item.dataset.path);
            fd.append('dest_folder', dest);
            fd.append('type', item.dataset.type === 'folder' ? 'folder' : 'file');
            await fetch(AX.urlCopy, { method: 'POST', body: fd });
        }
        location.reload();
    });
}

if (btnCancelarCopy) btnCancelarCopy.addEventListener('click', () => dialogCopy.close());
if (dialogCopy) dialogCopy.addEventListener('click', (e) => { if (e.target === dialogCopy) dialogCopy.close(); });

// ── Actualizar toolbar con botones nuevos ──────────────────────────────────

// Extender actualizarBotonesToolbar para incluir rename/move/copy
const _origActualizar = actualizarBotonesToolbar;
actualizarBotonesToolbar = function () {
    _origActualizar();
    const n = selectedItems.length;
    if (btnRename) btnRename.disabled = n !== 1;
    if (btnMove) btnMove.disabled = n === 0;
    if (btnCopy) btnCopy.disabled = n === 0;
};

// ── Dialogs movibles (drag desde el título) ────────────────────────────────

function hacerMovible(dialog) {
    const title = dialog.querySelector('.dialog-title');
    if (!title) return;
    title.style.cursor = 'move';
    let startX, startY, startL, startT;

    title.addEventListener('mousedown', (e) => {
        e.preventDefault();
        const rect = dialog.getBoundingClientRect();
        startX = e.clientX; startY = e.clientY;
        startL = rect.left; startT = rect.top;
        dialog.style.margin = '0';
        dialog.style.position = 'fixed';
        dialog.style.left = startL + 'px';
        dialog.style.top = startT + 'px';

        const onMove = (e) => {
            dialog.style.left = (startL + e.clientX - startX) + 'px';
            dialog.style.top = (startT + e.clientY - startY) + 'px';
        };
        const onUp = () => {
            document.removeEventListener('mousemove', onMove);
            document.removeEventListener('mouseup', onUp);
        };
        document.addEventListener('mousemove', onMove);
        document.addEventListener('mouseup', onUp);
    });
}

document.querySelectorAll('dialog').forEach(d => hacerMovible(d));