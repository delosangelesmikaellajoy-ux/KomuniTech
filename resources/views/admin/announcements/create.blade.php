@extends('layouts.app')

@section('header')
    <header class="bg-[#FDF5E6] shadow">
        <div class="max-w-7xl mx-auto py-4 px-6 text-[#0B1F3A] font-semibold">
            <h2 class="text-xl font-bold">Add Announcement</h2>
        </div>
    </header>
@endsection

@section('content')
<div class="max-w-3xl mx-auto mt-8 bg-[#FDF5E6] shadow-lg rounded-lg p-6">
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
    <form action="{{ route('admin.announcements.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block text-[#0B1F3A] font-semibold mb-1">Title</label>
            <input type="text" name="title" value="{{ old('title') }}"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2" required>
        </div>

        <div class="mb-4">
            <label class="block text-[#0B1F3A] font-semibold mb-1">Content</label>
            <textarea name="content" rows="5"
                      class="w-full border border-gray-300 rounded-lg px-4 py-2" required>{{ old('content') }}</textarea>
        </div>

        <button type="submit"
                class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
            Post Announcement
        </button>
    </form>
</div>
@endsection
