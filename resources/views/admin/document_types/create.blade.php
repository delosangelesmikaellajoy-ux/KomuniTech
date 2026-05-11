@extends('layouts.app')

@section('header')
    <header class="bg-gradient-to-r from-[#6BB1F3] to-[#A2D3F9] shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-[#0B1F3A] font-semibold">
            <h2 class="font-cute text-xl text-[#0B1F3A] leading-tight">{{ __('Create Document Type') }}</h2>
        </div>
    </header>
@endsection

@section('content')
    <div class="py-12 w-full">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-lg p-10 border border-[#E0C9A6]">
                @if ($errors->any())
                    <div class="mb-4 text-red-600 font-semibold">
                        Please fix the following issues:
                        <ul class="text-sm mt-1 space-y-1 list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @php
                    $existingTypes = \App\Models\DocumentType::where('barangay', auth()->user()->barangay)->get();
                @endphp

                @if($existingTypes->count() > 0)
                    <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <h3 class="text-sm font-semibold text-blue-800 mb-2">Existing Document Types</h3>
                        <div class="text-sm text-blue-700">
                            <p class="mb-2">The following document types already exist for your barangay:</p>
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach($existingTypes as $type)
                                    <li>{{ $type->name }} (₱{{ number_format($type->base_price, 2) }})</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <form action="{{ route('admin.document_types.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label for="name" class="block font-semibold text-[#0B1F3A]">Document Type Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="mt-1 block w-full h-12 rounded-lg bg-[#FDF5E6] border border-[#E0C9A6] focus:ring-[#3B82F6] focus:border-[#3B82F6]" required>
                    </div>

                    <div>
                        <label for="base_price" class="block font-semibold text-[#0B1F3A]">Base Price (₱)</label>
                        <input type="number" name="base_price" step="0.01" min="0" value="{{ old('base_price', 0) }}" class="mt-1 block w-full h-12 rounded-lg bg-[#FDF5E6] border border-[#E0C9A6] focus:ring-[#3B82F6] focus:border-[#3B82F6]" required>
                        <p class="text-sm text-gray-500 mt-2">Service fee of ₱20 will be added automatically when users request this document.</p>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="h-4 w-4 text-[#0B1F3A] focus:ring-[#3B82F6] border-gray-300 rounded">
                        <label for="is_active" class="ml-2 block text-sm text-[#0B1F3A]">Active (Available for requests)</label>
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" class="px-6 py-3 bg-[#0B1F3A] text-white rounded-lg hover:bg-[#112f4a] transition">
                            <i class="fas fa-plus mr-2"></i>Create Document Type
                        </button>
                        <a href="{{ route('admin.document_types.index') }}" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                            <i class="fas fa-arrow-left mr-2"></i>Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection