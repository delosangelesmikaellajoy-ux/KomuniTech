@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-8 bg-[#FDF5E6] shadow-lg rounded-lg p-6">
    <h2 class="text-2xl font-bold text-[#0B1F3A] mb-4"> Announcements</h2>

    <a href="{{ route('admin.announcements.create') }}"
       class="px-4 py-2 bg-green-500 text-white rounded-lg shadow hover:bg-green-600">
       + New Announcement
    </a>

    <div class="mt-6">
        @forelse ($announcements as $announcement)
            <div class="border-b border-gray-300 pb-4 mb-4">
                <h3 class="text-lg font-semibold">{{ $announcement->title }}</h3>
                <p class="text-gray-700">{{ $announcement->content }}</p>
                <p class="text-sm text-gray-500">Posted {{ $announcement->created_at->diffForHumans() }}</p>

                <div class="mt-2 flex gap-2">
                    <a href="{{ route('admin.announcements.edit', $announcement) }}"
                       class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">Edit</a>
                    <form action="{{ route('admin.announcements.destroy', $announcement) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-gray-500">No announcements yet.</p>
        @endforelse
    </div>
</div>
@endsection
