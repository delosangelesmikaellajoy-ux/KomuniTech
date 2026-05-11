<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('document-type-form');
        const modeSelect = document.getElementById('template_mode');
        const wordWorkspace = document.getElementById('word-workspace');
        const spreadsheetWorkspace = document.getElementById('spreadsheet-workspace');
        const wordEditor = document.getElementById('word-editor');
        const hiddenHtml = document.getElementById('template_html');
        const previewFrame = document.getElementById('template-preview-frame');
        const previewButton = document.getElementById('preview-template');
        const printButton = document.getElementById('print-template');
        const addRowButton = document.getElementById('add-row');
        const addColumnButton = document.getElementById('add-column');
        const spreadsheetGrid = document.getElementById('spreadsheet-grid');
        const templateFileInput = document.querySelector('input[name="template_file"]');

        function serializeSpreadsheet() {
            if (!spreadsheetGrid) {
                return '';
            }

            return spreadsheetGrid.outerHTML;
        }

        function updatePreview(content) {
            if (!previewFrame) {
                return;
            }

            previewFrame.srcdoc = `<!DOCTYPE html><html><head><meta charset="utf-8"><style>
                body{font-family:Quicksand,Arial,sans-serif;padding:24px;line-height:1.6;background:#fff;color:#111827}
                table{border-collapse:collapse;width:100%}
                td,th{border:1px solid #d1d5db;padding:10px;vertical-align:top}
                h1,h2,h3{margin:0 0 12px}
            </style></head><body>${content || '<p><em>No template content yet.</em></p>'}</body></html>`;
        }

        function syncEditorState() {
            const mode = modeSelect.value;

            if (mode === 'spreadsheet') {
                wordWorkspace.classList.add('hidden');
                spreadsheetWorkspace.classList.remove('hidden');
                hiddenHtml.value = serializeSpreadsheet();
                updatePreview(hiddenHtml.value);
                return;
            }

            spreadsheetWorkspace.classList.add('hidden');
            wordWorkspace.classList.remove('hidden');
            hiddenHtml.value = wordEditor ? wordEditor.value : hiddenHtml.value;
            updatePreview(hiddenHtml.value);
        }

        if (typeof tinymce !== 'undefined' && wordEditor) {
            tinymce.init({
                selector: '#word-editor',
                height: 420,
                menubar: false,
                plugins: 'lists link table code wordcount',
                toolbar: 'undo redo | blocks | bold italic underline | alignleft aligncenter alignright | bullist numlist | table | code | removeformat',
                setup(editor) {
                    editor.on('init', function () {
                        editor.setContent(wordEditor.value || '');
                        hiddenHtml.value = editor.getContent();
                        updatePreview(hiddenHtml.value);
                    });
                    editor.on('change keyup setcontent', function () {
                        hiddenHtml.value = editor.getContent();
                        updatePreview(hiddenHtml.value);
                    });
                }
            });
        }

        if (wordEditor) {
            wordEditor.addEventListener('input', function () {
                hiddenHtml.value = wordEditor.value;
                updatePreview(hiddenHtml.value);
            });
        }

        if (spreadsheetGrid) {
            spreadsheetGrid.addEventListener('input', function () {
                hiddenHtml.value = serializeSpreadsheet();
                updatePreview(hiddenHtml.value);
            });
        }

        addRowButton?.addEventListener('click', function () {
            const firstRow = spreadsheetGrid?.querySelector('tbody tr');
            if (!firstRow) return;
            const newRow = firstRow.cloneNode(true);
            newRow.querySelectorAll('td').forEach(function (cell) { cell.textContent = ''; });
            spreadsheetGrid.querySelector('tbody').appendChild(newRow);
            hiddenHtml.value = serializeSpreadsheet();
            updatePreview(hiddenHtml.value);
        });

        addColumnButton?.addEventListener('click', function () {
            spreadsheetGrid?.querySelectorAll('tr').forEach(function (row) {
                const cell = document.createElement('td');
                cell.contentEditable = 'true';
                cell.className = 'border border-neutral-200 px-3 py-2 min-w-[140px]';
                cell.textContent = 'New Field';
                row.appendChild(cell);
            });
            hiddenHtml.value = serializeSpreadsheet();
            updatePreview(hiddenHtml.value);
        });

        modeSelect?.addEventListener('change', syncEditorState);

        templateFileInput?.addEventListener('change', function (event) {
            const file = event.target.files?.[0];
            if (!file) {
                return;
            }

            const extension = (file.name.split('.').pop() || '').toLowerCase();
            if (['xls', 'xlsx'].includes(extension)) {
                modeSelect.value = 'spreadsheet';
            } else if (extension === 'pdf') {
                modeSelect.value = 'pdf';
            } else {
                modeSelect.value = 'word';
            }

            syncEditorState();
        });

        previewButton?.addEventListener('click', function () {
            syncEditorState();
            const previewWindow = window.open('', '_blank', 'noopener,noreferrer');
            if (!previewWindow) return;
            previewWindow.document.open();
            previewWindow.document.write(previewFrame?.srcdoc || '');
            previewWindow.document.close();
        });

        printButton?.addEventListener('click', function () {
            syncEditorState();
            if (!previewFrame?.contentWindow) return;
            previewFrame.contentWindow.focus();
            previewFrame.contentWindow.print();
        });

        form?.addEventListener('submit', function () {
            if (modeSelect.value === 'spreadsheet') {
                hiddenHtml.value = serializeSpreadsheet();
            } else if (window.tinymce && tinymce.get('word-editor')) {
                hiddenHtml.value = tinymce.get('word-editor').getContent();
            } else if (wordEditor) {
                hiddenHtml.value = wordEditor.value;
            }
            document.getElementById('template_html').value = hiddenHtml.value;
        });

        document.querySelectorAll('.placeholder-token').forEach(function (button) {
            button.addEventListener('click', function () {
                const token = button.dataset.token || '';
                if (modeSelect.value === 'spreadsheet') {
                    const cell = spreadsheetGrid?.querySelector('td[contenteditable="true"]:focus');
                    if (cell) {
                        cell.textContent = token;
                        hiddenHtml.value = serializeSpreadsheet();
                        updatePreview(hiddenHtml.value);
                    }
                    return;
                }

                if (window.tinymce && tinymce.get('word-editor')) {
                    tinymce.get('word-editor').execCommand('mceInsertContent', false, token);
                    hiddenHtml.value = tinymce.get('word-editor').getContent();
                    updatePreview(hiddenHtml.value);
                    return;
                }

                wordEditor.value += token;
                hiddenHtml.value = wordEditor.value;
                updatePreview(hiddenHtml.value);
            });
        });

        syncEditorState();
    });
</script>
