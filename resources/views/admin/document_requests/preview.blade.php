@extends('layouts.app')

@section('header')
    <header class="bg-[#FDF5E6] shadow">
        <div class="max-w-7xl mx-auto py-4 px-6 text-[#0B1F3A] font-semibold">
            <h2 class="text-xl font-bold">Preview Generated Document</h2>
        </div>
    </header>
@endsection

@section('content')
    <div class="max-w-6xl mx-auto mt-8 bg-white shadow rounded p-6">
        <div class="flex justify-between items-center mb-4">
            <div>
                <a href="{{ route('admin.document_requests.download', [$documentRequest->id, 'word']) }}" class="px-3 py-2 bg-gray-700 text-white rounded mr-2">Download .doc</a>
                <a href="{{ route('admin.document_requests.download', [$documentRequest->id, 'pdf']) }}" class="px-3 py-2 bg-gray-800 text-white rounded mr-2">Download PDF</a>
            </div>
            <div>
                <button onclick="window.print()" class="px-3 py-2 bg-indigo-600 text-white rounded">Print</button>
            </div>
        </div>

        <div id="generated-document" class="prose max-w-none border p-6">
            {!! $generatedHtml !!}
        </div>
    </div>
@endsection
