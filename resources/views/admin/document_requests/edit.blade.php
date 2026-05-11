@extends('layouts.app')

@section('header')
    <header class="bg-gradient-to-r from-primary-50 to-primary-100 border-b border-primary-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <h1 class="text-4xl font-bold text-primary-900 flex items-center gap-3">
                <i class="fas fa-edit text-primary-600 text-3xl"></i>
                Edit Document: {{ $documentRequest->document_type }}
            </h1>
            <p class="text-primary-700 mt-2">Customize the document content before final release</p>
        </div>
    </header>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    @if(session('success'))
        <x-alert variant="success" dismissible>
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
        </x-alert>
    @endif

    @if($errors->any())
        <x-alert variant="error" dismissible>
            <i class="fas fa-exclamation-circle mr-2"></i>
            {{ $errors->first() }}
        </x-alert>
    @endif

    <x-card shadow="md" border>
        <div class="p-6">
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-neutral-900 mb-2">Request Details</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div><strong>Requester:</strong> {{ $documentRequest->fullname }}</div>
                    <div><strong>Document Type:</strong> {{ $documentRequest->document_type }}</div>
                    <div><strong>Barangay:</strong> {{ $documentRequest->barangay }}</div>
                    <div><strong>Status:</strong> {{ $documentRequest->status }}</div>
                </div>
            </div>

            <form action="{{ route('admin.document_requests.update_generated', $documentRequest) }}" method="POST" id="edit-form">
                @csrf
                @method('POST')

                <div class="mb-6">
                    <label for="html_content" class="block text-sm font-medium text-neutral-700 mb-2">
                        Document Content
                    </label>
                    <textarea
                        id="html_content"
                        name="html_content"
                        class="w-full h-96 border border-neutral-300 rounded-lg p-4 text-sm"
                        placeholder="Edit the document content here..."
                    >{{ $htmlContent }}</textarea>
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="px-6 py-3 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition font-medium">
                        <i class="fas fa-save mr-2"></i>Save Changes
                    </button>
                    <a href="{{ route('admin.document_requests.index') }}" class="px-6 py-3 bg-neutral-200 text-neutral-700 rounded-lg hover:bg-neutral-300 transition font-medium">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Requests
                    </a>
                    <a href="{{ route('admin.document_requests.preview', $documentRequest) }}" target="_blank" class="px-6 py-3 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition font-medium">
                        <i class="fas fa-eye mr-2"></i>Preview
                    </a>
                </div>
            </form>
        </div>
    </x-card>
</div>
@endsection

@section('scripts')
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#html_content',
        height: 500,
        menubar: false,
        plugins: 'lists link image code table paste',
        toolbar: 'undo redo | formatselect | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | table | code',
        content_style: 'body { font-family: Arial, sans-serif; font-size: 14px; }',
        setup: function (editor) {
            editor.on('change', function () {
                editor.save();
            });
        }
    });
</script>
@endsection