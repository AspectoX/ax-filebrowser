/**
 * AX File Browser — Plugin para TinyMCE 6/7
 *
 * Instalación:
 * 1. Copiar este archivo a: tinymce/plugins/axfilebrowser/plugin.js
 * 2. Agregar 'axfilebrowser' a los plugins y toolbar en la config de TinyMCE
 *
 * Configuración:
 * tinymce.init({
 *     selector: '#editor',
 *     plugins: 'axfilebrowser',
 *     toolbar: 'axfilebrowser | bold italic ...',
 *     ax_filebrowser_url: '/ax-filebrowser/picker',
 * });
 */

tinymce.PluginManager.add('axfilebrowser', function (editor, url) {

    var pickerUrl = editor.getParam('ax_filebrowser_url', '/ax-filebrowser/picker');

    function openPicker() {
        var width  = 1000;
        var height = 700;
        var left   = Math.round((window.screen.width  - width)  / 2);
        var top    = Math.round((window.screen.height - height) / 2);

        // Callback único por instancia
        var cbName = 'axFileBrowserCallback_' + editor.id.replace(/[^a-z0-9]/gi, '_');

        window[cbName] = function (code, url, name) {
            editor.insertContent(code);
            delete window[cbName];
        };

        window.open(
            pickerUrl + '?callback=' + cbName,
            'axFileBrowser',
            'width=' + width + ',height=' + height +
            ',left=' + left + ',top=' + top +
            ',resizable=yes,scrollbars=yes'
        );
    }

    // Registrar botón en toolbar
    editor.ui.registry.addButton('axfilebrowser', {
        text    : 'File Browser',
        icon    : 'image',   // ícono nativo de TinyMCE, reemplazar por SVG propio si se quiere
        tooltip : 'Insert file from AX File Browser',
        onAction: openPicker
    });

    // También disponible como item de menú
    editor.ui.registry.addMenuItem('axfilebrowser', {
        text    : 'File Browser',
        icon    : 'image',
        onAction: openPicker
    });

    // Integración con file_picker_callback nativo de TinyMCE (para imágenes)
    // Si el usuario usa el diálogo de imagen de TinyMCE, el picker se abre automáticamente
    if (!editor.getParam('file_picker_callback')) {
        editor.options.set('file_picker_callback', function (callback, value, meta) {
            var cbName = 'axTinyMCECallback_' + editor.id.replace(/[^a-z0-9]/gi, '_');
            window[cbName] = function (code, url, name) {
                callback(url, { alt: name });
                delete window[cbName];
            };
            window.open(
                pickerUrl + '?callback=' + cbName,
                'axFileBrowser',
                'width=1000,height=700,resizable=yes,scrollbars=yes'
            );
        });
    }

    return {
        getMetadata: function () {
            return {
                name: 'AX File Browser',
                url : 'https://github.com/aspectox/ax-filebrowser',
            };
        }
    };
});
