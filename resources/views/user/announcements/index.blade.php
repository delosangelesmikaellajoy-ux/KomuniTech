@extends('layouts.app')

@section('header')
    <header class="bg-gradient-to-r from-[#6BB1F3] to-[#A2D3F9] shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-[#0B1F3A] font-semibold">
            <h2 class="font-semibold text-xl text-[#0B1F3A] leading-tight">
                {{ __('Barangay Announcements') }}
            </h2>
        </div>
    </header>
@endsection

@section('content')
<div class="py-12 px-6 lg:px-8 w-full">
    <div class="bg-[#FDF5E6] shadow-xl rounded-lg p-10 max-w-5xl mx-auto">

        <!-- Main Announcements Card -->
        <div class="bg-gradient-to-b from-[#6BB1F3] to-[#A2D3F9] rounded-lg p-8 shadow-lg border-2 border-[#0B1F3A]">
            <h3 class="text-2xl font-bold text-[#0B1F3A] mb-6 text-center">
                Latest Barangay Announcements
            </h3>
            <p class="text-[#0B1F3A] mb-6 text-center">
                Stay updated with all community advisories and updates.
            </p>

            @forelse ($announcements as $announcement)
                <div class="bg-white rounded-lg shadow p-4 border border-gray-300 mb-4">
                    <h4 class="text-lg font-semibold text-[#0B1F3A]">
                        {{ $announcement->title }}
                    </h4>
                    <p class="text-sm text-gray-500">
                        Posted {{ $announcement->created_at->format('M d, Y') }}
                    </p>
                    <p class="mt-2 text-[#0B1F3A]">
                        {{ $announcement->content }}
                    </p>
                </div>
            @empty
                <p class="text-center text-gray-500">No announcements available.</p>
            @endforelse

            <!-- Back / View All Button -->
            <div class="text-center mt-6">
                <a href="{{ route('dashboard') }}"
                   class="px-6 py-2 bg-gradient-to-r from-[#0B1F3A] to-[#1E3A5F] text-white font-semibold rounded-lg shadow-md hover:from-[#1E3A5F] hover:to-[#0B1F3A] transition transform hover:scale-105 border border-[#0B1F3A]/30">
                    Back to Dashboard
                </a>
            </div>
        </div>

    </div>
</div>
@endsection
