@extends('layouts.app')

@section('header')
    <header class="bg-[#FDF5E6] shadow">
        <div class="max-w-7xl mx-auto py-4 px-6 text-[#0B1F3A] font-semibold">
            <h2 class="text-xl font-bold">Edit Document Type</h2>
        </div>
    </header>
@endsection

@section('content')
<div class="max-w-4xl mx-auto mt-8 bg-[#FDF5E6] shadow-lg rounded-lg p-6">
    <!-- Success/Error messages -->
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form -->
    <form action="{{ route('admin.document_types.update', $documentType) }}" method="POST">
        @csrf @method('PUT')

        <div class="mb-4">
            <label class="block text-[#0B1F3A] font-semibold mb-1">Document Name</label>
            <input type="text" name="name" value="{{ old('name', $documentType->name) }}"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2" required>
        </div>

        <div class="mb-4">
            <label class="block text-[#0B1F3A] font-semibold mb-1">Base Price (₱)</label>
            <input type="number" name="base_price" value="{{ old('base_price', $documentType->base_price) }}" step="0.01" min="0"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2" required>
            <p class="text-sm text-gray-600 mt-1">Service fee of ₱20 will be automatically added to this base price.</p>
        </div>

        <div class="mb-4">
            <label class="block text-[#0B1F3A] font-semibold mb-1">
                Document Template (HTML)
                <span class="text-sm font-normal text-gray-600">
                    Use placeholders like {{ fullname }}, {{ address }}, etc. for dynamic data.
                </span>
            </label>
            <textarea name="template_html" rows="15"
                      class="w-full border border-gray-300 rounded-lg px-4 py-2 font-mono text-sm"
                      placeholder="Enter HTML template here...">{{ old('template_html', $documentType->template_html) }}</textarea>
        </div>

        <div class="mb-4">
            <label class="flex items-center">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $documentType->is_active) ? 'checked' : '' }}
                       class="mr-2">
                <span class="text-[#0B1F3A] font-semibold">Active (Available for requests)</span>
            </label>
        </div>

        <div class="flex gap-4">
            <button type="submit"
                    class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                Update Document Type
            </button>
            <a href="{{ route('admin.document_types.index') }}"
               class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection