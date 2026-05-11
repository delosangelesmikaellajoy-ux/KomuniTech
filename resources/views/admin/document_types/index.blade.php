@extends('layouts.app')

@section('header')
    <header class="bg-gradient-to-r from-primary-50 to-primary-100 border-b border-primary-200">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-primary-900">
                        <i class="fas fa-file-invoice mr-3"></i>Document Types Management
                    </h1>
                    <p class="text-primary-700 mt-1">Create and manage document types available for requests</p>
                </div>
                <a href="{{ route('admin.document_types.create') }}" class="inline-flex items-center px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition shadow-md">
                    <i class="fas fa-plus mr-2"></i>Add New Document Type
                </a>
            </div>
        </div>
    </header>
@endsection

@section('content')
    <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Alerts -->
        @if(session('success'))
            <x-alert variant="success" class="mb-6">
                <div class="font-medium">Success!</div>
                <div class="text-sm">{{ session('success') }}</div>
            </x-alert>
        @endif

        @if($errors->any())
            <x-alert variant="error" class="mb-6">
                <div class="font-medium">Error</div>
                <ul class="text-sm mt-1 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </x-alert>
        @endif

        <!-- Documents Table -->
        @if($documentTypes->count())
            <x-card class="overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <x-table-head>
                            <x-table-cell-head>Document Name</x-table-cell-head>
                            <x-table-cell-head>Template</x-table-cell-head>
                            <x-table-cell-head align="center">Mode</x-table-cell-head>
                            <x-table-cell-head align="right">Base Price</x-table-cell-head>
                            <x-table-cell-head align="center">Status</x-table-cell-head>
                            <x-table-cell-head align="right">Actions</x-table-cell-head>
                        </x-table-head>
                        <x-table-body>
                            @foreach($documentTypes as $doc)
                                <x-table-row>
                                    <x-table-cell>
                                        <div class="font-medium text-neutral-900">{{ $doc->name }}</div>
                                        <div class="text-xs text-neutral-500 mt-1">Service Fee: +₱20.00</div>
                                    </x-table-cell>
                                    <x-table-cell>
                                        @if($doc->template_file_name)
                                            <div class="text-sm font-medium text-neutral-900">{{ $doc->template_file_name }}</div>
                                            <div class="text-xs text-neutral-500">{{ strtoupper($doc->template_file_type ?? 'FILE') }}</div>
                                        @else
                                            <div class="text-sm text-neutral-500">No template uploaded</div>
                                        @endif
                                    </x-table-cell>
                                    <x-table-cell align="center">
                                        <x-badge variant="primary" size="sm">
                                            {{ ucfirst($doc->template_editor_mode) }}
                                        </x-badge>
                                    </x-table-cell>
                                    <x-table-cell align="right">
                                        <span class="font-semibold text-neutral-900">₱{{ number_format($doc->base_price, 2) }}</span>
                                    </x-table-cell>
                                    <x-table-cell align="center">
                                        @if($doc->is_active)
                                            <x-badge variant="success" size="sm">
                                                <i class="fas fa-check mr-1"></i>Active
                                            </x-badge>
                                        @else
                                            <x-badge variant="neutral" size="sm">
                                                <i class="fas fa-times mr-1"></i>Inactive
                                            </x-badge>
                                        @endif
                                    </x-table-cell>
                                    <x-table-cell align="right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('admin.document_types.edit', $doc) }}" 
                                               class="inline-flex items-center px-3 py-1 text-sm rounded-lg bg-primary-100 text-primary-700 hover:bg-primary-200 transition">
                                                <i class="fas fa-edit mr-1"></i>Edit
                                            </a>
                                            <form action="{{ route('admin.document_types.destroy', $doc) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center px-3 py-1 text-sm rounded-lg bg-error-100 text-error-700 hover:bg-error-200 transition">
                                                    <i class="fas fa-trash mr-1"></i>Delete
                                                </button>
                                            </form>
                                        </div>
                                    </x-table-cell>
                                </x-table-row>
                            @endforeach
                        </x-table-body>
                    </table>
                </div>
            </x-card>
        @else
            <x-card class="text-center py-12">
                <div class="text-neutral-400 mb-4">
                    <i class="fas fa-inbox text-4xl"></i>
                </div>
                <p class="text-neutral-600 font-medium mb-4">No document types created yet.</p>
                <a href="{{ route('admin.document_types.create') }}" class="inline-flex items-center px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition">
                    <i class="fas fa-plus mr-2"></i>Create Your First Document Type
                </a>
            </x-card>
        @endif
    </div>
@endsection