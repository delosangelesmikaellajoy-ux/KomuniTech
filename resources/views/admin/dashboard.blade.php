@extends('layouts.app')

@section('header')
    <!-- Header with nude background -->
    <header class="bg-[#FDF5E6] shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-[#0B1F3A] font-semibold">
            <h2 class="font-cute text-xl text-[#0B1F3A] leading-tight">
                {{ __('Welcome Barangay Admin!') }}
            </h2>
        </div>
    </header>
@endsection

@section('content')
    <div class="py-12 px-6 lg:px-8 w-full">
        <!-- Main Container (still nude background) -->
        <div class="bg-[#FDF5E6] shadow-xl rounded-lg p-10 max-w-6xl mx-auto">

            <!-- Request Summary (colors unchanged) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                <!-- Pending -->
                <a href="{{ route('admin.document_requests.pending') }}"
                   class="bg-gradient-to-b from-yellow-300 to-yellow-200 rounded-lg shadow-md p-6 text-center border-2 border-yellow-600 hover:scale-105 transition transform block">
                    <div class="text-3xl font-bold text-[#0B1F3A]">{{ $pendingCount }}</div>
                    <div class="text-lg font-semibold text-[#0B1F3A]">Pending Requests</div>
                </a>

                <!-- Approved -->
                <a href="{{ route('admin.document_requests.approved') }}"
                   class="bg-gradient-to-b from-green-300 to-green-200 rounded-lg shadow-md p-6 text-center border-2 border-green-600 hover:scale-105 transition transform block">
                    <div class="text-3xl font-bold text-[#0B1F3A]">{{ $approvedCount }}</div>
                    <div class="text-lg font-semibold text-[#0B1F3A]">Approved Requests</div>
                </a>

                <!-- Rejected -->
                <a href="{{ route('admin.document_requests.rejected') }}"
                   class="bg-gradient-to-b from-red-300 to-red-200 rounded-lg shadow-md p-6 text-center border-2 border-red-600 hover:scale-105 transition transform block">
                    <div class="text-3xl font-bold text-[#0B1F3A]">{{ $rejectedCount }}</div>
                    <div class="text-lg font-semibold text-[#0B1F3A]">Rejected Requests</div>
                </a>
            </div>

            <!-- Quick Actions (colors unchanged, still blue gradient) -->
            <div class="bg-gradient-to-b from-[#6BB1F3] to-[#A2D3F9] rounded-lg shadow-lg border-2 border-[#0B1F3A] p-8">
                <h3 class="text-2xl font-bold text-[#0B1F3A] mb-6 text-center">Quick Actions</h3>
                <p class="text-[#0B1F3A] mb-8 text-center">
                    Manage and monitor barangay document requests efficiently.
                </p>

                <div class="flex flex-wrap justify-center gap-6">
                    <!-- Link to manage requests -->
                    <a href="{{ route('admin.document_requests.index') }}"
                       class="px-6 py-3 bg-[#3B82F6] text-white font-semibold rounded-lg shadow-md hover:bg-[#2563EB] transition transform hover:scale-105 border-2 border-[#1E40AF]">
                        Manage Document Requests
                    </a>
                    <!-- Link to manage announcements -->
                        <a href="{{ route('admin.announcements.index') }}"
                            class="px-6 py-3 bg-[#10B981] text-white font-semibold rounded-lg shadow-md hover:bg-[#059669] transition transform hover:scale-105 border-2 border-[#047857]">
                            Manage Announcements
                        </a>

                </div>
            </div>

        </div>
    </div>
@endsection
