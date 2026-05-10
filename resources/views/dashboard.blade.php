@extends('layouts.app')

@section('header')
    <header class="bg-gradient-to-r from-[#6BB1F3] to-[#A2D3F9] shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-[#0B1F3A] font-semibold">
            <h2 class="font-semibold text-xl text-[#0B1F3A] leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </div>
    </header>
@endsection

@section('content')
    <div class="py-12 px-6 lg:px-8 w-full">
        <div class="bg-[#FDF5E6] shadow-xl rounded-lg p-10 max-w-5xl mx-auto">
            
            <!-- Barangay Document Services -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-8 border border-[#E0C9A6]">
                <p class="font-semibold text-[#0B1F3A]">Assigned Barangay</p>
                <p class="mt-2 text-lg text-[#0B1F3A]">{{ Auth::user()->barangay ?? 'Not assigned' }}</p>
            </div>

            <div class="bg-gradient-to-b from-[#6BB1F3] to-[#A2D3F9] rounded-lg p-8 mb-8 shadow-lg border-2 border-[#0B1F3A]">
                <h3 class="text-2xl font-bold text-[#0B1F3A] mb-6 text-center">Barangay Document Services</h3>
                <p class="text-[#0B1F3A] mb-8 text-center">
                    You can request official barangay documents directly from here.
                </p>

                <div class="flex flex-wrap justify-center gap-6">
                    <a href="{{ route('document_requests.create') }}" 
                       class="px-6 py-3 bg-[#4ADE80] text-white font-semibold rounded-lg shadow-md hover:bg-[#22C55E] transition transform hover:scale-105 border-2 border-[#15803D]">
                        Request Document
                    </a>

                    <a href="{{ route('document_requests.pending') }}" 
                       class="px-6 py-3 bg-[#3B82F6] text-white font-semibold rounded-lg shadow-md hover:bg-[#2563EB] transition transform hover:scale-105 border-2 border-[#1E40AF]">
                        My Requests
                    </a>

                    <a href="{{ route('document_requests.history') }}" 
                       class="px-6 py-3 bg-[#F59E0B] text-white font-semibold rounded-lg shadow-md hover:bg-[#D97706] transition transform hover:scale-105 border-2 border-[#B45309]">
                        My Request History
                    </a>
                </div>
            </div>

            <!-- My Recent Requests (latest 3 only, no delete button) -->
            <div class="bg-gradient-to-b from-[#6BB1F3] to-[#A2D3F9] rounded-lg p-8 mb-8 shadow-lg border-2 border-[#0B1F3A]">
                <h3 class="text-2xl font-bold text-[#0B1F3A] mb-6 text-center">My Recent Requests</h3>
                @forelse($requests->take(3) as $request)
                    <div class="bg-white shadow rounded p-4 mb-4">
                        <p><strong>Document:</strong> {{ $request->document_type }}</p>
                        <p><strong>Status:</strong> {{ ucfirst($request->status) }}</p>
                        @if($request->release_date)
                            <p><strong>Pickup Date:</strong> {{ \Carbon\Carbon::parse($request->release_date)->format('M d, Y') }}</p>
                        @endif

                        <!-- Cancel Button (only if Pending) -->
                        @if($request->status === 'Pending')
                            <form action="{{ route('document_requests.cancel', $request->id) }}" method="POST" class="mt-3">
                                @csrf
                                @method('PATCH')
                                <button type="submit" 
                                        class="px-4 py-2 bg-yellow-600 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-700 transition transform hover:scale-105">
                                    Cancel Request
                                </button>
                            </form>
                        @endif
                    </div>
                @empty
                    <p class="text-center text-gray-500">You have no recent requests.</p>
                @endforelse
            </div>

            <!-- Announcements -->
            <div class="bg-gradient-to-b from-[#6BB1F3] to-[#A2D3F9] rounded-lg p-8 shadow-lg border-2 border-[#0B1F3A]">
                <h3 class="text-2xl font-bold text-[#0B1F3A] mb-6 text-center">Announcements</h3>
                <p class="text-[#0B1F3A] mb-6 text-center">
                    Stay updated with the latest barangay news and community updates.
                </p>

                @forelse($announcements as $announcement)
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
                    <p class="text-center text-gray-500">No announcements at the moment.</p>
                @endforelse

                <!-- View All button with dark navy gradient -->
                <div class="text-center mt-6">
                    <a href="{{ route('user.announcements.index') }}"
                       class="px-6 py-2 bg-gradient-to-r from-[#0B1F3A] to-[#1E3A5F] text-white font-semibold rounded-lg shadow-md hover:from-[#1E3A5F] hover:to-[#0B1F3A] transition transform hover:scale-105 border border-[#0B1F3A]/30">
                        View All Announcements
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
