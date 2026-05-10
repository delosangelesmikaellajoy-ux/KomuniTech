@extends('layouts.app')

@section('header')
    <header class="bg-gradient-to-r from-[#6BB1F3] to-[#A2D3F9] shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-[#0B1F3A] font-semibold">
            <h2 class="font-cute text-xl text-[#0B1F3A] leading-tight">{{ __('Registered Barangays') }}</h2>
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
                            <th class="px-4 py-3 text-left">Barangay</th>
                            <th class="px-4 py-3 text-left">Barangay Admin</th>
                            <th class="px-4 py-3 text-left">Active Users</th>
                            <th class="px-4 py-3 text-left">Subscription</th>
                            <th class="px-4 py-3 text-left">Approved Revenue</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($barangays as $entry)
                            <tr class="border-t border-gray-200">
                                <td class="px-4 py-3">{{ $entry['barangay'] }}</td>
                                <td class="px-4 py-3">{{ $entry['admin']->name }}</td>
                                <td class="px-4 py-3">{{ $entry['active_users'] }}</td>
                                <td class="px-4 py-3">
                                    @if($entry['subscription'])
                                        <span class="font-semibold">{{ $entry['subscription']->status }}</span><br>
                                        <span class="text-xs text-gray-500">Expires {{ $entry['subscription']->expires_at?->format('Y-m-d') ?? 'N/A' }}</span>
                                    @else
                                        <span class="text-red-600 font-semibold">No subscription</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">₱{{ number_format($entry['total_revenue'] ?? 0, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-6 text-center text-gray-500">No barangays registered yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
