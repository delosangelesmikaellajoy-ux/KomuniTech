@extends('layouts.app')

@section('header')
    <header class="bg-gradient-to-r from-[#A2D3F9] to-[#6BB1F3] shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-[#0B1F3A] font-semibold">
            <h2 class="font-cute text-xl text-[#0B1F3A] leading-tight">{{ __('Barangay Admins') }}</h2>
        </div>
    </header>
@endsection

@section('content')
    <div class="py-12 px-6 lg:px-8 w-full">
        <div class="max-w-7xl mx-auto bg-[#FDF5E6] shadow-xl rounded-lg p-10">
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white rounded-lg overflow-hidden">
                    <thead class="bg-[#0B1F3A] text-white">
                        <tr>
                            <th class="px-4 py-3 text-left">Name</th>
                            <th class="px-4 py-3 text-left">Barangay</th>
                            <th class="px-4 py-3 text-left">Email</th>
                            <th class="px-4 py-3 text-left">Subscription Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($admins as $admin)
                            <tr class="border-t border-gray-200">
                                <td class="px-4 py-3">{{ $admin->name }}</td>
                                <td class="px-4 py-3">{{ $admin->barangay ?? 'Unassigned' }}</td>
                                <td class="px-4 py-3">{{ $admin->email }}</td>
                                <td class="px-4 py-3">
                                    @if($admin->subscription)
                                        <span class="font-semibold">{{ $admin->subscription->status }}</span>
                                    @else
                                        <span class="text-red-600 font-semibold">Not subscribed</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-6 text-center text-gray-500">No barangay admins found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
