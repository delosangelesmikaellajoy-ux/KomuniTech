@extends('layouts.app')

@section('header')
    <header class="bg-gradient-to-r from-[#6BB1F3] to-[#A2D3F9] shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-[#0B1F3A] font-semibold">
            <h2 class="font-cute text-xl text-[#0B1F3A] leading-tight">
                {{ __('My Request History') }}
            </h2>
        </div>
    </header>
@endsection

@section('content')
    <div class="py-12 w-full">
        <!-- Main Container (light nude) -->
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 bg-[#FDF5E6] shadow-xl rounded-lg p-10">
            
            @forelse($requests as $req)
                <!-- Gradient Request Card -->
                <div class="bg-gradient-to-b from-[#6BB1F3] to-[#A2D3F9] overflow-hidden shadow-lg rounded-lg p-6 mb-6">
                    <!-- Request summary -->
                    <div class="flex justify-between items-center mb-2">
                        <div class="font-semibold text-[#0B1F3A]">{{ $req->document_type }}</div>
                        <div class="text-sm text-[#0B1F3A]">{{ $req->created_at->format('M d, Y') }}</div>
                    </div>

                    <div class="text-sm mb-4 text-[#0B1F3A]">
                        <span class="font-semibold">Purpose:</span> {{ $req->purpose }} <br>
                        <span class="font-semibold">Status:</span> 
                        <span class="@if($req->status === 'Pending') text-yellow-600 
                                     @elseif($req->status === 'Approved') text-green-600 
                                     @elseif($req->status === 'Rejected') text-red-600 
                                     @endif font-bold">
                            {{ $req->status }}
                        </span>
                        @if($req->status === 'Rejected' && $req->remarks)
                            <span class="ml-2 text-red-700 font-semibold">Reason: {{ $req->remarks }}</span>
                        @endif
                        @if($req->payment_method)
                            <div class="mt-2">
                                <span class="font-semibold">Payment:</span> {{ $req->payment_method }}
                                <span class="ml-2 text-sm text-[#0B1F3A]">({{ $req->payment_status ?? 'N/A' }})</span>
                            </div>
                        @endif
                        @if($req->gcash_reference)
                            <div class="mt-1 text-sm text-[#0B1F3A]">Ref: {{ $req->gcash_reference }}</div>
                        @endif
                        @if($req->gcash_proof)
                            <div class="mt-1 text-sm text-[#0B1F3A]">
                                Proof: <a href="{{ asset('storage/' . $req->gcash_proof) }}" target="_blank" class="underline">View</a>
                            </div>
                        @endif
                    </div>

                    <!-- ID Photo -->
                    <div class="mb-4">
                        <span class="font-semibold text-[#0B1F3A]">ID Photo:</span><br>
                        @if($req->id_photo)
                            <img src="{{ asset('storage/' . $req->id_photo) }}" alt="ID Photo" class="w-24 h-auto rounded border border-[#0B1F3A]">
                        @else
                            <span class="text-gray-700">No photo uploaded</span>
                        @endif
                    </div>

                    <!-- Timeline -->
                    <div class="border-t border-[#0B1F3A] pt-4">
                        <div class="font-semibold mb-2 text-[#0B1F3A]">History</div>
                        <ul class="text-sm space-y-1 text-[#0B1F3A]">
                            @foreach($req->history as $log)
                                <li>
                                    <span class="font-semibold">{{ $log->action }}</span>
                                    <span class="text-gray-700">— {{ $log->created_at->format('M d, Y h:i A') }}</span>
                                    @if($log->remarks)
                                        <span class="ml-2 text-gray-700">({{ $log->remarks }})</span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @empty
                <!-- Empty state card -->
                <div class="bg-gradient-to-b from-[#6BB1F3] to-[#A2D3F9] shadow-lg rounded-lg p-6 text-center text-[#0B1F3A]">
                    No request history yet.
                </div>
            @endforelse

            <!-- Pagination -->
            <div class="mt-6">
                {{ $requests->links() }}
            </div>
        </div>
    </div>
@endsection
