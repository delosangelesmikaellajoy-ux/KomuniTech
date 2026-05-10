@extends('layouts.app')

@section('header')
    <header class="bg-gradient-to-r from-[#6BB1F3] to-[#A2D3F9] shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-[#0B1F3A] font-semibold">
            <h2 class="font-cute text-xl text-[#0B1F3A] leading-tight">
                {{ __('Manage Document Requests') }}
            </h2>
        </div>
    </header>
@endsection

@section('content')
    <div class="py-12 px-6 lg:px-8 w-full">
        <div class="max-w-6xl mx-auto bg-[#FDF5E6] shadow-xl rounded-lg p-10">

            @if(session('success'))
                <div class="mb-6 text-green-700 font-semibold text-center">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 text-red-700 font-semibold text-center">
                    {{ $errors->first() }}
                </div>
            @endif

            <table class="w-full border-collapse rounded-lg overflow-hidden shadow-lg">
                <thead>
                    <tr class="bg-gradient-to-r from-[#6BB1F3] to-[#A2D3F9] text-[#0B1F3A]">
                        <th class="px-4 py-3 text-left font-semibold">Name</th>
                        <th class="px-4 py-3 text-left font-semibold">Barangay</th>
                        <th class="px-4 py-3 text-left font-semibold">Document</th>
                        <th class="px-4 py-3 text-left font-semibold">Base Price</th>
                        <th class="px-4 py-3 text-left font-semibold">Service Fee</th>
                        <th class="px-4 py-3 text-left font-semibold">Total Amount</th>
                        <th class="px-4 py-3 text-left font-semibold">Payment Method</th>
                        <th class="px-4 py-3 text-left font-semibold">Payment Status</th>
                        <th class="px-4 py-3 text-left font-semibold">Purpose</th>
                        <th class="px-4 py-3 text-left font-semibold">ID Photo</th>
                        <th class="px-4 py-3 text-left font-semibold">Status</th>
                        <th class="px-4 py-3 text-left font-semibold">Remarks</th>
                        <th class="px-4 py-3 text-left font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requests as $req)
                        <!-- Highlighted row -->
                        <tr class="bg-gradient-to-r from-[#E0F2FE] to-[#F0F9FF] border-b hover:from-[#BAE6FD] hover:to-[#E0F2FE] transition">
                            <td class="px-4 py-3">
                                <div class="font-semibold text-[#0B1F3A]">{{ $req->fullname }}</div>
                                <div class="text-xs text-gray-500">{{ $req->contact_number }}</div>
                                <div class="text-xs text-gray-500">{{ $req->address }}</div>
                            </td>
                            <td class="px-4 py-3 text-[#0B1F3A]">{{ $req->barangay ?? '—' }}</td>
                            <td class="px-4 py-3 text-[#0B1F3A]">{{ $req->document_type_name }}</td>
                            <td class="px-4 py-3 text-[#0B1F3A]">₱{{ number_format($req->base_price, 2) }}</td>
                            <td class="px-4 py-3 text-[#0B1F3A]">₱{{ number_format($req->service_fee, 2) }}</td>
                            <td class="px-4 py-3 text-[#0B1F3A]">₱{{ number_format($req->total_amount, 2) }}</td>
                            <td class="px-4 py-3 text-[#0B1F3A]">{{ $req->payment_method ?? '—' }}</td>
                            <td class="px-4 py-3 text-[#0B1F3A]">{{ $req->payment_status ?? '—' }}</td>
                            <td class="px-4 py-3 text-[#0B1F3A]">
                                {{ $req->purpose }}
                                @if($req->gcash_reference)
                                    <div class="text-xs text-gray-600">Ref: {{ $req->gcash_reference }}</div>
                                @endif
                                @if($req->gcash_proof)
                                    <div class="text-xs text-gray-600">Proof: <a href="{{ asset('storage/' . $req->gcash_proof) }}" target="_blank" class="underline">View</a></div>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @if($req->id_photo)
                                    <img src="{{ asset('storage/' . $req->id_photo) }}" alt="ID Photo" class="w-20 h-auto rounded border border-[#0B1F3A]">
                                @else
                                    <span class="text-sm text-gray-500">No photo</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <span class="@if($req->status === 'Pending') text-yellow-600 
                                             @elseif($req->status === 'Approved') text-green-600 
                                             @elseif($req->status === 'Rejected') text-red-600 
                                             @endif font-bold">
                                    {{ $req->status }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-[#0B1F3A]">
                                {{ $req->remarks ?? '—' }}
                            </td>
                            <td class="px-4 py-3">
                                <div class="grid grid-cols-2 gap-3">
                                    {{-- Approve with Release Date --}}
                                    <form action="{{ route('admin.document_requests.update', $req->id) }}" method="POST" class="w-full">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="Approved">

                                        <label class="block text-sm font-semibold text-[#0B1F3A] mb-1">Release Date</label>
                                        <input type="date" name="release_date" class="w-full border rounded px-3 py-2 mb-2" required>

                                        <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition transform hover:scale-105">
                                            Approve
                                        </button>
                                    </form>

                                    {{-- Reject --}}
                                    <form action="{{ route('admin.document_requests.update', $req->id) }}" method="POST" class="w-full">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="Rejected">
                                        <input
                                            type="text"
                                            name="remarks"
                                            class="form-input w-full mt-2 px-3 py-2 rounded border border-[#0B1F3A]"
                                            placeholder="Reason (required)"
                                            required
                                        >
                                        <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition transform hover:scale-105">
                                             Reject
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="13" class="px-4 py-6 text-center text-[#0B1F3A]">
                                No requests found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-6">
                {{ $requests->links() }}
            </div>
        </div>
    </div>
@endsection
