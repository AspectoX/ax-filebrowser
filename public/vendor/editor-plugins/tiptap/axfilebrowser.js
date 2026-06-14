/**
 * AX File Browser — Extension para TipTap / Filament
 *
 * Instalación en TipTap puro:
 * import { AxFileBrowser } from './axfilebrowser'
 * const editor = new Editor({ extensions: [AxFileBrowser] })
 *
 * Instalación en Filament (resources/js/axfilebrowser.js):
 * import { AxFileBrowser } from './extensions/axfilebrowser'
 * document.addEventListener('tiptap-editor:boot', ({ detail: { editor } }) => {
 *     editor.extensionManager.extensions.push(AxFileBrowser)
 * })
 */

import { Extension } from '@tiptap/core'

export const AxFileBrowser = Extension.create({
    name: 'axFileBrowser',

    addOptions() {
        return {
            pickerUrl: '/ax-filebrowser/picker',
        }
    },

    addCommands() {
        return {
            openFileBrowser: () => ({ editor }) => {
                const pickerUrl = this.options.pickerUrl
                const width     = 1000
                const height    = 700
                const left      = Math.round((window.screen.width  - width)  / 2)
                const top       = Math.round((window.screen.height - height) / 2)
                const cbName    = 'axFileBrowserCallback_tiptap_' + Date.now()

                window[cbName] = (code, url, name) => {
                    // Detectar tipo por extensión
                    const ext  = url.split('.').pop().toLowerCase()
                    const imgs = ['jpg','jpeg','png','gif','webp','svg','avif']

                    if (imgs.includes(ext)) {
                        editor.chain().focus().setImage({ src: url, alt: name }).run()
                    } else {
                        editor.chain().focus().insertContent(code).run()
                    }
                    delete window[cbName]
                }

                window.open(
                    pickerUrl + '?callback=' + cbName,
                    'axFileBrowser',
                    `width=${width},height=${height},left=${left},top=${top},resizable=yes,scrollbars=yes`
                )

                return true
            },
        }
    },

    addKeyboardShortcuts() {
        return {
            'Mod-Shift-f': () => this.editor.commands.openFileBrowser(),
        }
    },
})

/**
 * Uso en Filament (Livewire):
 *
 * En el panel de Filament, en tu Form:
 *
 * RichEditor::make('content')
 *     ->toolbarButtons(['attachFiles', ...])
 *
 * O con TipTap Builder:
 *
 * TiptapEditor::make('content')
 *     ->extensions([AxFileBrowserExtension::class])
 *
 * Botón externo para abrir el picker desde Filament/Livewire:
 *
 * <button
 *     type="button"
 *     onclick="window.__axOpenPicker()"
 *     class="fi-btn fi-btn-size-md fi-btn-color-gray"
 * >
 *     File Browser
 * </button>
 *
 * <script>
 * window.__axOpenPicker = function() {
 *     const cbName = 'axFileBrowserCallback'
 *     window[cbName] = function(code, url, name) {
 *         // Insertar en el editor de Filament via Livewire
 *         Livewire.dispatch('ax-file-selected', { url, name, code })
 *         delete window[cbName]
 *     }
 *     window.open('/ax-filebrowser/picker?callback=' + cbName, 'axFileBrowser', 'width=1000,height=700')
 * }
 * </script>
 */
