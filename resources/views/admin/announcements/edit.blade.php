@extends('layouts.app')

@section('header')
    <header class="bg-gradient-to-r from-[#6BB1F3] to-[#A2D3F9] shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-[#0B1F3A] font-semibold">
            <h2 class="text-xl font-bold text-[#0B1F3A]">Edit Announcement</h2>
        </div>
    </header>
@endsection

@section('content')
    <div class="py-12 px-6 lg:px-8 w-full">
        <div class="max-w-4xl mx-auto bg-[#FDF5E6] shadow-xl rounded-lg p-10">
            <form action="{{ route('admin.announcements.update', $announcement->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="title" class="block text-[#0B1F3A] font-semibold mb-2">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $announcement->title) }}"
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#6BB1F3]">
                </div>

                <div class="mb-6">
                    <label for="content" class="block text-[#0B1F3A] font-semibold mb-2">Content</label>
                    <textarea name="content" id="content" rows="6"
                              class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#6BB1F3]">{{ old('content', $announcement->content) }}</textarea>
                </div>

                <button type="submit"
                        class="px-6 py-2 bg-[#3B82F6] text-white font-semibold rounded-lg shadow-md hover:bg-[#2563EB] transition transform hover:scale-105">
                    Update Announcement
                </button>
            </form>
        </div>
    </div>
@endsection
