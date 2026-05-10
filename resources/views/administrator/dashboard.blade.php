@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8">
    <!-- Page Title -->
    <h1 class="text-3xl font-bold text-[#0B1F3A] mb-6">Administrator Dashboard</h1>

    <!-- Welcome Message -->
    <p class="text-lg text-gray-700 mb-8">
        Welcome back, {{ Auth::user()->name }}! You have full system-wide control here.
    </p>

    <!-- Dashboard Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Card: Barangays -->
        <div class="bg-white shadow-lg rounded-lg p-6 border-l-4 border-[#6BB1F3]">
            <h2 class="text-xl font-semibold text-[#0B1F3A]">All Barangays</h2>
            <p class="text-gray-600 mt-2">View and manage all barangays in the system.</p>
            <a href="{{ route('administrator.barangays.index') }}" 
               class="mt-4 inline-block bg-[#6BB1F3] text-[#0B1F3A] font-semibold px-4 py-2 rounded-lg hover:bg-[#A2D3F9] transition">
                Manage Barangays
            </a>
        </div>

        <!-- Card: Barangay Admins -->
        <div class="bg-white shadow-lg rounded-lg p-6 border-l-4 border-[#A2D3F9]">
            <h2 class="text-xl font-semibold text-[#0B1F3A]">Barangay Admins</h2>
            <p class="text-gray-600 mt-2">Assign and manage barangay administrators.</p>
            <div class="mt-4 flex flex-wrap gap-3">
                <a href="{{ route('administrator.barangay_admins.index') }}" 
                   class="inline-block bg-[#A2D3F9] text-[#0B1F3A] font-semibold px-4 py-2 rounded-lg hover:bg-[#6BB1F3] transition">
                    Manage Admins
                </a>
                <a href="{{ route('administrator.barangay_admins.create') }}" 
                   class="inline-block bg-[#0B1F3F] text-white font-semibold px-4 py-2 rounded-lg hover:bg-[#163f69] transition">
                    Register Barangay Admin
                </a>
            </div>
        </div>

        <!-- Card: System Overview -->
        <div class="bg-white shadow-lg rounded-lg p-6 border-l-4 border-[#0B1F3A]">
            <h2 class="text-xl font-semibold text-[#0B1F3A]">System Overview</h2>
            <p class="text-gray-600 mt-2">Quick stats about requests and users.</p>
            <ul class="mt-4 text-gray-700 space-y-1">
                <li>Total Requests: {{ \App\Models\DocumentRequest::count() }}</li>
                <li>Total Users: {{ \App\Models\User::count() }}</li>
            </ul>
        </div>
    </div>
</div>
@endsection
