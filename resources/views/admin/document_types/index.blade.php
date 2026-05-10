@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto mt-8 bg-[#FDF5E6] shadow-lg rounded-lg p-6">
    <h2 class="text-2xl font-bold text-[#0B1F3A] mb-4">Document Types Management</h2>

    <a href="{{ route('admin.document_types.create') }}"
       class="px-4 py-2 bg-green-500 text-white rounded-lg shadow hover:bg-green-600">
       + Add New Document Type
    </a>

    <div class="mt-6 overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300 rounded-lg">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Base Price</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($documentTypes as $documentType)
                    <tr>
                        <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $documentType->name }}
                        </td>
                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">
                            ₱{{ number_format($documentType->base_price, 2) }}
                        </td>
                        <td class="px-4 py-2 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $documentType->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $documentType->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-4 py-2 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('admin.document_types.edit', $documentType) }}"
                               class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                            <form action="{{ route('admin.document_types.destroy', $documentType) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="text-red-600 hover:text-red-900"
                                        onclick="return confirm('Are you sure you want to delete this document type?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-2 text-center text-gray-500">
                            No document types found. <a href="{{ route('admin.document_types.create') }}" class="text-blue-500">Create one now</a>.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection