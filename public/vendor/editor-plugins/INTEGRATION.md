# AX File Browser — Integración con editores

El picker de AX File Browser usa un sistema de callback universal:
al seleccionar un archivo llama a `window[callbackName](code, url, name)`.

- `code` — tag HTML listo para insertar (`<img>`, `<video>`, `<a>`, etc.)
- `url`  — URL del archivo (`/uploads/fotos/imagen.jpg`)
- `name` — nombre del archivo

---

## CKEditor 4

### Opción A — Plugin (recomendado)

Copiar `editor-plugins/ckeditor4/axfilebrowser/` dentro de `ckeditor/plugins/` y activar:

```javascript
CKEDITOR.replace('editor', {
    extraPlugins : 'axfilebrowser',
    toolbar      : [['AxFileBrowser'], ['Bold', 'Italic'], ...],
    axFileBrowserUrl: '/ax-filebrowser/picker',
});
```

### Opción B — Botón externo

```html
<button onclick="axOpenFileBrowser()">File Browser</button>

<script>
function axOpenFileBrowser() {
    var cbName = 'axInsertFile';
    window[cbName] = function(code, url, name) {
        CKEDITOR.instances['editor'].insertHtml(code);
    };
    window.open('/ax-filebrowser/picker?callback=' + cbName, 'axPicker', 'width=1000,height=700');
}
</script>
```

---

## TinyMCE 6 / 7

### Opción A — Plugin (recomendado)

Copiar `editor-plugins/tinymce/plugins/axfilebrowser/` dentro de `tinymce/plugins/` y activar:

```javascript
tinymce.init({
    selector           : '#editor',
    plugins            : 'axfilebrowser image link',
    toolbar            : 'axfilebrowser | bold italic | image link',
    ax_filebrowser_url : '/ax-filebrowser/picker',
});
```

### Opción B — file_picker_callback nativo

```javascript
tinymce.init({
    selector: '#editor',
    file_picker_callback: function(callback, value, meta) {
        var cbName = 'axTinyMCECb';
        window[cbName] = function(code, url, name) {
            callback(url, { alt: name });
            delete window[cbName];
        };
        window.open('/ax-filebrowser/picker?callback=' + cbName, 'axPicker', 'width=1000,height=700');
    }
});
```

---

## TipTap (standalone)

```javascript
import { Editor } from '@tiptap/core'
import { AxFileBrowser } from './editor-plugins/tiptap/axfilebrowser.js'

const editor = new Editor({
    extensions: [
        AxFileBrowser.configure({ pickerUrl: '/ax-filebrowser/picker' }),
        // ...otros extensions
    ],
})

// Abrir el picker
editor.commands.openFileBrowser()

// O con un botón
document.getElementById('btn-file-browser').addEventListener('click', () => {
    editor.commands.openFileBrowser()
})
```

---

## Filament (Livewire)

### Con RichEditor nativo de Filament

```php
// En tu Form
RichEditor::make('content')
    ->hint(
        new HtmlString(
            '<button type="button" onclick="axOpenPickerForFilament()">File Browser</button>'
        )
    )
```

```javascript
// En el blade o JS
function axOpenPickerForFilament() {
    var cbName = 'axFilamentCallback';
    window[cbName] = function(code, url, name) {
        Livewire.dispatch('ax-file-selected', { url: url, name: name, code: code });
        delete window[cbName];
    };
    window.open('/ax-filebrowser/picker?callback=' + cbName, 'axPicker', 'width=1000,height=700');
}

// En el componente Livewire escuchar el evento
// En tu LivewireComponent.php:
// #[On('ax-file-selected')]
// public function axFileSelected($url, $name, $code) { ... }
```

### Con TipTap Editor for Filament (awcodes/filament-tiptap-editor)

```php
TiptapEditor::make('content')
    ->extraExtensions([AxFileBrowserExtension::class])
```

---

## Quill

```javascript
var quill = new Quill('#editor', { theme: 'snow' })

document.getElementById('btn-file-browser').addEventListener('click', function() {
    var cbName = 'axQuillCallback';
    window[cbName] = function(code, url, name) {
        var range = quill.getSelection(true);
        var ext   = url.split('.').pop().toLowerCase();
        var imgs  = ['jpg','jpeg','png','gif','webp','svg','avif'];
        if (imgs.includes(ext)) {
            quill.insertEmbed(range.index, 'image', url);
        } else {
            quill.clipboard.dangerouslyPasteHTML(range.index, code);
        }
        delete window[cbName];
    };
    window.open('/ax-filebrowser/picker?callback=' + cbName, 'axPicker', 'width=1000,height=700');
});
```

---

## Textarea / Input text

```html
<textarea id="mi-textarea"></textarea>
<button type="button" onclick="axOpenForTextarea('mi-textarea')">File Browser</button>

<input type="text" id="mi-input" readonly>
<button type="button" onclick="axOpenForInput('mi-input')">Browse</button>

<script>
// Para textarea — inserta en la posición del cursor
function axOpenForTextarea(targetId) {
    var ta  = document.getElementById(targetId);
    var pos = ta.selectionStart;
    var cbName = 'axTextareaCallback';
    window[cbName] = function(code, url, name) {
        ta.value = ta.value.slice(0, pos) + code + ta.value.slice(pos);
        delete window[cbName];
    };
    window.open('/ax-filebrowser/picker?callback=' + cbName, 'axPicker', 'width=1000,height=700');
}

// Para input text — pone solo la URL
function axOpenForInput(targetId) {
    var cbName = 'axInputCallback';
    window[cbName] = function(code, url, name) {
        document.getElementById(targetId).value = url;
        delete window[cbName];
    };
    window.open('/ax-filebrowser/picker?callback=' + cbName, 'axPicker', 'width=1000,height=700');
}
</script>
```
