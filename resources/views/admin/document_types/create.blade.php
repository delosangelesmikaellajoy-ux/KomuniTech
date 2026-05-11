@extends('layouts.app')

@section('header')
    <header class="bg-gradient-to-r from-primary-50 to-primary-100 border-b border-primary-200">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between gap-4 flex-wrap">
                <div>
                    <h1 class="text-3xl font-bold text-primary-900"><i class="fas fa-file-invoice mr-3"></i>Add Document Type</h1>
                    <p class="text-primary-700 mt-1">Create a new document type, upload a template, and edit it in-app.</p>
                </div>
            </div>
        </div>
    </header>
@endsection

@section('content')
    <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if ($errors->any())
            <x-alert variant="error" class="mb-6">
                <div class="font-medium">Please fix the following issues:</div>
                <ul class="text-sm mt-1 space-y-1 list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </x-alert>
        @endif

        @include('admin.document_types.partials.form', ['documentType' => $documentType])
    </div>
@endsection

@section('scripts')
    @include('admin.document_types.partials.scripts')
@endsection