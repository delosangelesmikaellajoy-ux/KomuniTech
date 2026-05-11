@php
    $isEdit = $documentType->exists;
    $editorMode = old('template_mode', $documentType->template_editor_mode ?? 'word');
    $templateContent = old('editable_template_content', $documentType->editable_template_content ?? $documentType->template_html ?? '');
    $templateFileUrl = $documentType->template_file_url;
@endphp

<form id="document-type-form" action="{{ $isEdit ? route('admin.document_types.update', $documentType) : route('admin.document_types.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <x-card shadow="md" border class="lg:col-span-1">
            <div class="p-6 space-y-6">
                <div>
                    <h2 class="text-xl font-bold text-neutral-900">Document Details</h2>
                    <p class="text-sm text-neutral-600 mt-1">Required fields for document type, price, and template upload.</p>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-neutral-800">Document Type</label>
                    <input type="text" name="name" value="{{ old('name', $documentType->name) }}" class="w-full rounded-xl border border-neutral-300 px-4 py-3 focus:border-primary-500 focus:ring-primary-500" required>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-neutral-800">Price</label>
                    <input type="number" name="base_price" step="0.01" min="0" value="{{ old('base_price', $documentType->base_price ?? 0) }}" class="w-full rounded-xl border border-neutral-300 px-4 py-3 focus:border-primary-500 focus:ring-primary-500" required>
                    <p class="text-xs text-neutral-500">Service fee of ₱20 is added automatically on request generation.</p>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-neutral-800">Template Upload</label>
                    <input type="file" name="template_file" accept=".doc,.docx,.pdf,.xls,.xlsx" class="block w-full text-sm text-neutral-600 file:mr-4 file:rounded-xl file:border-0 file:bg-primary-600 file:px-4 file:py-3 file:text-white hover:file:bg-primary-700">
                    <p class="text-xs text-neutral-500">Allowed: .doc, .docx, .pdf, .xls, .xlsx. Max 20MB.</p>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-neutral-800">Editor Mode</label>
                    <select id="template_mode" name="template_mode" class="w-full rounded-xl border border-neutral-300 px-4 py-3 focus:border-primary-500 focus:ring-primary-500">
                        <option value="word" @selected($editorMode === 'word')>Word-like Editor</option>
                        <option value="spreadsheet" @selected($editorMode === 'spreadsheet')>Spreadsheet-like Editor</option>
                        <option value="pdf" @selected($editorMode === 'pdf')>PDF Preview Editor</option>
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="flex items-center gap-2 text-sm font-semibold text-neutral-800">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $documentType->is_active) ? 'checked' : '' }}>
                        Active (Available for requests)
                    </label>
                </div>

                @if($templateFileUrl)
                    <div class="rounded-xl border border-neutral-200 bg-neutral-50 p-4 space-y-3">
                        <div class="flex items-center justify-between gap-3">
                            <div>
                                <p class="text-sm font-semibold text-neutral-900">Current Template File</p>
                                <p class="text-xs text-neutral-500">{{ $documentType->template_file_name ?? basename($documentType->template_file_path) }}</p>
                            </div>
                            <x-badge variant="primary" size="sm">{{ strtoupper($documentType->template_file_type ?? 'FILE') }}</x-badge>
                        </div>
                        <div class="flex gap-2 flex-wrap">
                            <a href="{{ $templateFileUrl }}" target="_blank" class="inline-flex items-center gap-2 rounded-lg bg-white px-3 py-2 text-sm font-medium text-neutral-700 ring-1 ring-neutral-200 hover:bg-neutral-100">
                                <i class="fas fa-eye"></i>Open File
                            </a>
                            <a href="{{ $templateFileUrl }}" download class="inline-flex items-center gap-2 rounded-lg bg-white px-3 py-2 text-sm font-medium text-neutral-700 ring-1 ring-neutral-200 hover:bg-neutral-100">
                                <i class="fas fa-download"></i>Download
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </x-card>

        <x-card shadow="md" border class="lg:col-span-2">
            <div class="p-6 space-y-6">
                <div class="flex items-start justify-between gap-4 flex-wrap">
                    <div>
                        <h2 class="text-xl font-bold text-neutral-900">Editable Template Workspace</h2>
                        <p class="text-sm text-neutral-600 mt-1">Edit content, use placeholders, preview output, and print when needed.</p>
                    </div>
                    <div class="flex gap-2 flex-wrap no-print">
                        <button type="button" id="preview-template" class="inline-flex items-center gap-2 rounded-xl bg-primary-600 px-4 py-2 text-sm font-medium text-white hover:bg-primary-700">
                            <i class="fas fa-eye"></i>Preview
                        </button>
                        <button type="button" id="print-template" class="inline-flex items-center gap-2 rounded-xl bg-neutral-200 px-4 py-2 text-sm font-medium text-neutral-800 hover:bg-neutral-300">
                            <i class="fas fa-print"></i>Print
                        </button>
                    </div>
                </div>

                <div class="rounded-xl border border-neutral-200 bg-neutral-50 p-4">
                    <p class="text-sm font-semibold text-neutral-800 mb-2">Dynamic Placeholders</p>
                    <div class="flex flex-wrap gap-2 text-xs">
                        @foreach(['{{name}}', '{{address}}', '{{date}}', '{{document_number}}', '@{{ fullname }}', '@{{ address }}', '@{{ release_date }}'] as $placeholder)
                            <button type="button" class="rounded-full bg-white px-3 py-1 ring-1 ring-neutral-200 hover:bg-primary-50 hover:text-primary-700 placeholder-token" data-token="{{ $placeholder }}">{{ $placeholder }}</button>
                        @endforeach
                    </div>
                </div>

                <div id="word-workspace" class="workspace-panel space-y-3">
                    <label class="block text-sm font-semibold text-neutral-800">Word / PDF / Generic Template Editor</label>
                    <textarea id="editable_template_content" name="editable_template_content" class="hidden">{!! $templateContent !!}</textarea>
                    <textarea id="word-editor" class="w-full min-h-[420px] rounded-2xl border border-neutral-300 px-4 py-3 font-mono text-sm focus:border-primary-500 focus:ring-primary-500">{!! $templateContent !!}</textarea>
                    <p class="text-xs text-neutral-500">This editor accepts formatted HTML and placeholders for generated documents.</p>
                </div>

                <div id="spreadsheet-workspace" class="workspace-panel hidden space-y-3">
                    <div class="flex items-center justify-between gap-3 flex-wrap">
                        <label class="block text-sm font-semibold text-neutral-800">Spreadsheet-style Template Editor</label>
                        <div class="flex gap-2">
                            <button type="button" id="add-row" class="rounded-lg bg-white px-3 py-2 text-sm font-medium text-neutral-700 ring-1 ring-neutral-200 hover:bg-neutral-100">Add Row</button>
                            <button type="button" id="add-column" class="rounded-lg bg-white px-3 py-2 text-sm font-medium text-neutral-700 ring-1 ring-neutral-200 hover:bg-neutral-100">Add Column</button>
                        </div>
                    </div>
                    <div class="overflow-x-auto rounded-2xl border border-neutral-200 bg-white p-3">
                        <table id="spreadsheet-grid" class="min-w-full border-collapse text-sm">
                            <tbody>
                                <tr>
                                    <td contenteditable="true" class="border border-neutral-200 px-3 py-2 min-w-[140px]">@{{ fullname }}</td>
                                    <td contenteditable="true" class="border border-neutral-200 px-3 py-2 min-w-[140px]">@{{ address }}</td>
                                    <td contenteditable="true" class="border border-neutral-200 px-3 py-2 min-w-[140px]">@{{ date }}</td>
                                </tr>
                                <tr>
                                    <td contenteditable="true" class="border border-neutral-200 px-3 py-2">Placeholder</td>
                                    <td contenteditable="true" class="border border-neutral-200 px-3 py-2">Value</td>
                                    <td contenteditable="true" class="border border-neutral-200 px-3 py-2">Value</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <textarea id="spreadsheet-template-json" class="hidden">{!! $templateContent !!}</textarea>
                    <p class="text-xs text-neutral-500">Spreadsheet mode stores the grid as HTML for printable document generation.</p>
                </div>

                <div class="rounded-2xl border border-neutral-200 overflow-hidden">
                    <div class="flex items-center justify-between px-4 py-3 bg-neutral-100 border-b border-neutral-200">
                        <p class="text-sm font-semibold text-neutral-800">Live Preview</p>
                        <span class="text-xs text-neutral-500">Print-ready</span>
                    </div>
                    <iframe id="template-preview-frame" class="w-full min-h-[460px] bg-white" title="Template Preview"></iframe>
                </div>

                <textarea id="template_html" name="template_html" class="hidden">{!! $templateContent !!}</textarea>

                <div class="flex flex-wrap gap-3 pt-2 no-print">
                    <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-success-600 px-5 py-3 text-sm font-semibold text-white hover:bg-success-700">
                        <i class="fas fa-save"></i>{{ $isEdit ? 'Save Changes' : 'Create Document Type' }}
                    </button>
                    <a href="{{ route('admin.document_types.index') }}" class="inline-flex items-center gap-2 rounded-xl bg-neutral-200 px-5 py-3 text-sm font-semibold text-neutral-800 hover:bg-neutral-300">
                        <i class="fas fa-arrow-left"></i>Cancel
                    </a>
                </div>
            </div>
        </x-card>
    </div>
</form>
