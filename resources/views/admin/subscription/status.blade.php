@extends('layouts.app')

@section('header')
    <header class="bg-gradient-to-r from-[#FDF5E6] to-[#A2D3F9] shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-[#0B1F3A] font-semibold">
            <h2 class="font-cute text-xl text-[#0B1F3A] leading-tight">{{ __('Subscription Status') }}</h2>
        </div>
    </header>
@endsection

@section('content')
    <div class="py-12 px-6 lg:px-8 w-full">
        <div class="max-w-3xl mx-auto bg-[#FDF5E6] shadow-xl rounded-lg p-10">
            @if(session('success'))
                <div class="mb-6 text-green-700 font-semibold text-center">{{ session('success') }}</div>
            @endif
            @if(session('warning'))
                <div class="mb-6 text-yellow-700 font-semibold text-center">{{ session('warning') }}</div>
            @endif

            <div class="bg-white rounded-lg shadow p-8">
                <h3 class="text-2xl font-semibold text-[#0B1F3A] mb-4">Current Subscription</h3>

                @if($subscription)
                    <div class="space-y-3 text-[#0B1F3A]">
                        <p><span class="font-semibold">Status:</span> {{ $subscription->status }}</p>
                        <p><span class="font-semibold">Amount:</span> ₱{{ number_format($subscription->amount, 2) }}</p>
                        <p><span class="font-semibold">Starts At:</span> {{ $subscription->starts_at?->format('Y-m-d') ?? 'N/A' }}</p>
                        <p><span class="font-semibold">Expires At:</span> {{ $subscription->expires_at?->format('Y-m-d') ?? 'N/A' }}</p>
                        <p><span class="font-semibold">Payment Reference:</span> {{ $subscription->payment_reference ?? 'N/A' }}</p>
                    </div>
                @else
                    <div class="text-[#0B1F3A] mb-6">
                        <p>No subscription record found for your barangay account.</p>
                    </div>
                @endif

                <div class="mt-8">
                    <h3 class="text-xl font-semibold text-[#0B1F3A] mb-4">Pay Subscription</h3>
                    <p class="text-gray-700 mb-4">A one-time fee of ₱1,500 is required to activate your barangay account.</p>

                    <form action="{{ route('admin.subscription.pay') }}" method="POST" class="space-y-4">
                        @csrf

                        <div>
                            <label for="payment_reference" class="block font-semibold text-[#0B1F3A]">Payment Reference (optional)</label>
                            <input type="text" name="payment_reference" id="payment_reference" value="{{ old('payment_reference') }}"
                                   class="mt-1 w-full rounded-lg border border-[#E0C9A6] px-3 py-2 bg-white" placeholder="e.g. transaction ID">
                        </div>

                        <button type="submit" class="px-6 py-3 bg-[#0B1F3A] text-white rounded-lg hover:bg-[#112f4a] transition">Record Subscription Payment</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
