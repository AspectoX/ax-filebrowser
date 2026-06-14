/**
 * AX File Browser — Plugin para CKEditor 4
 * Abre el picker de ax-filebrowser e inserta el archivo en el editor
 */
CKEDITOR.plugins.add('axfilebrowser', {

    icons: 'axfilebrowser',
    lang: ['en', 'es'],

    init: function (editor) {

        var pickerUrl = editor.config.axFileBrowserUrl || '/ax-filebrowser/picker';

        // Comando
        editor.addCommand('axfilebrowser', {
            exec: function (editor) {
                var width  = 1000;
                var height = 700;
                var left   = Math.round((screen.width  - width)  / 2);
                var top    = Math.round((screen.height - height) / 2);

                // Registrar callback global para que el picker lo encuentre
                var cbName = 'axFileBrowserCallback_' + editor.name.replace(/[^a-z0-9]/gi, '_');

                window[cbName] = function (code, url, name) {
                    editor.insertHtml(code);
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
        });

        // Botón en toolbar
        editor.ui.addButton('AxFileBrowser', {
            label   : editor.lang.axfilebrowser.buttonLabel,
            command : 'axfilebrowser',
            toolbar : 'insert',
            icon    : this.path + 'icons/axfilebrowser.png',
        });
    }
});
