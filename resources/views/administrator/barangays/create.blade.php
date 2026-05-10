@extends('layouts.app')

@section('header')
    <header class="bg-gradient-to-r from-[#6BB1F3] to-[#A2D3F9] shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-[#0B1F3A] font-semibold">
            <h2 class="font-cute text-xl text-[#0B1F3A] leading-tight">{{ __('Register Barangay Admin') }}</h2>
        </div>
    </header>
@endsection

@section('content')
    <div class="py-12 px-6 lg:px-8 w-full">
        <div class="max-w-3xl mx-auto bg-[#FDF5E6] shadow-xl rounded-lg p-10">
            @if(session('success'))
                <div class="mb-6 text-green-700 font-semibold text-center">{{ session('success') }}</div>
            @endif

            <form action="{{ route('administrator.barangay_admins.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="name" class="block font-semibold text-[#0B1F3A]">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                           class="mt-1 w-full rounded-lg border border-[#E0C9A6] px-3 py-2 bg-white" required>
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div>
                    <label for="email" class="block font-semibold text-[#0B1F3A]">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                           class="mt-1 w-full rounded-lg border border-[#E0C9A6] px-3 py-2 bg-white" required>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div>
                    <label for="barangay" class="block font-semibold text-[#0B1F3A]">Barangay</label>
                    <input type="text" name="barangay" id="barangay" value="{{ old('barangay') }}"
                           class="mt-1 w-full rounded-lg border border-[#E0C9A6] px-3 py-2 bg-white" required>
                    <x-input-error :messages="$errors->get('barangay')" class="mt-2" />
                </div>

                <div>
                    <label for="password" class="block font-semibold text-[#0B1F3A]">Password</label>
                    <input type="password" name="password" id="password"
                           class="mt-1 w-full rounded-lg border border-[#E0C9A6] px-3 py-2 bg-white" required>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-3 bg-[#0B1F3A] text-white rounded-lg hover:bg-[#112f4a] transition">Create Barangay Admin</button>
                </div>
            </form>
        </div>
    </div>
@endsection
