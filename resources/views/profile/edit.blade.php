@extends('layouts.app')

@section('header')
    <header class="bg-gradient-to-r from-[#6BB1F3] to-[#A2D3F9] shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-[#0B1F3A] leading-tight">
                {{ __('My Profile') }}
            </h2>
        </div>
    </header>
@endsection

@section('content')
<div class="py-12 px-6 lg:px-8 w-full">
    <div class="bg-[#FDF5E6] shadow-xl rounded-lg p-10 max-w-4xl mx-auto space-y-8 border-2 border-[#0B1F3A]">

        {{-- Update Profile --}}
        <div class="bg-gradient-to-b from-[#6BB1F3] to-[#A2D3F9] rounded-lg p-8 shadow-lg border-2 border-[#0B1F3A]">
            <h3 class="text-2xl font-bold text-[#0B1F3A] mb-6 text-center">Update Profile Information</h3>
            <div class="bg-white p-6 rounded-lg shadow border border-gray-300">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        {{-- Update Password --}}
        <div class="bg-gradient-to-b from-[#6BB1F3] to-[#A2D3F9] rounded-lg p-8 shadow-lg border-2 border-[#0B1F3A]">
            <h3 class="text-2xl font-bold text-[#0B1F3A] mb-6 text-center">Update Password</h3>
            <div class="bg-white p-6 rounded-lg shadow border border-gray-300">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        {{-- Delete User --}}
        <div class="bg-gradient-to-b from-[#6BB1F3] to-[#A2D3F9] rounded-lg p-8 shadow-lg border-2 border-[#0B1F3A]">
            <h3 class="text-2xl font-bold text-[#0B1F3A] mb-6 text-center">Delete Account</h3>
            <div class="bg-white p-6 rounded-lg shadow border border-gray-300">
                @include('profile.partials.delete-user-form')
            </div>
        </div>

    </div>
</div>
@endsection
