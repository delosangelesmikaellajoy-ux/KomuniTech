@extends('layouts.app')

@section('header')
    <header class="bg-gradient-to-r from-[#6BB1F3] to-[#A2D3F9] shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-[#0B1F3A] font-semibold">
            <h2 class="font-cute text-xl text-[#0B1F3A] leading-tight">{{ __('Barangay Request Reports') }}</h2>
        </div>
    </header>
@endsection

@section('content')
    <div class="py-12 px-6 lg:px-8 w-full">
        <div class="max-w-6xl mx-auto bg-[#FDF5E6] shadow-xl rounded-lg p-10">
            @if(session('success'))
                <div class="mb-6 text-green-700 font-semibold text-center">{{ session('success') }}</div>
            @endif
            @if(session('warning'))
                <div class="mb-6 text-yellow-700 font-semibold text-center">{{ session('warning') }}</div>
            @endif

            <div class="grid gap-6 mb-8 md:grid-cols-3">
                <div class="bg-white p-6 rounded-lg shadow border-l-4 border-[#0B1F3A]">
                    <h3 class="text-lg font-semibold text-[#0B1F3A]">Total Revenue</h3>
                    <p class="text-3xl font-bold text-[#0B1F3A]">₱{{ number_format($serviceFees, 2) }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow border-l-4 border-[#6BB1F3]">
                    <h3 class="text-lg font-semibold text-[#0B1F3A]">Total Fee Records</h3>
                    <p class="text-3xl font-bold text-[#0B1F3A]">{{ $requests->total() }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow border-l-4 border-[#A2D3F9]">
                    <h3 class="text-lg font-semibold text-[#0B1F3A]">Export</h3>
                    <a href="{{ route('admin.reports.export', request()->query()) }}" class="inline-block mt-4 px-5 py-3 bg-[#3B82F6] text-white rounded-lg hover:bg-[#2563EB] transition">Download CSV</a>
                </div>
            </div>

            <form method="GET" action="{{ route('admin.reports.index') }}" class="grid gap-4 md:grid-cols-4 mb-8">
                <div>
                    <label class="block font-semibold text-[#0B1F3A]">From</label>
                    <input type="date" name="from_date" value="{{ request('from_date') }}" class="mt-1 w-full rounded-lg border border-[#E0C9A6] px-3 py-2 bg-white">
                </div>
                <div>
                    <label class="block font-semibold text-[#0B1F3A]">To</label>
                    <input type="date" name="to_date" value="{{ request('to_date') }}" class="mt-1 w-full rounded-lg border border-[#E0C9A6] px-3 py-2 bg-white">
                </div>
                <div>
                    <label class="block font-semibold text-[#0B1F3A]">Document Type</label>
                    <select name="document_type" class="mt-1 w-full rounded-lg border border-[#E0C9A6] px-3 py-2 bg-white">
                        <option value="">All</option>
                        @foreach(\App\Models\DocumentRequest::documentTypePrices() as $type => $price)
                            <option value="{{ $type }}" {{ request('document_type') === $type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block font-semibold text-[#0B1F3A]">Status</label>
                    <select name="status" class="mt-1 w-full rounded-lg border border-[#E0C9A6] px-3 py-2 bg-white">
                        <option value="">All</option>
                        <option value="Pending" {{ request('status') === 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Approved" {{ request('status') === 'Approved' ? 'selected' : '' }}>Approved</option>
                        <option value="Rejected" {{ request('status') === 'Rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
                <div class="md:col-span-4 text-right">
                    <button type="submit" class="px-6 py-3 bg-[#0B1F3A] text-white rounded-lg hover:bg-[#112f4a] transition">Filter</button>
                </div>
            </form>

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white rounded-lg overflow-hidden">
                    <thead class="bg-[#6BB1F3] text-[#0B1F3A]">
                        <tr>
                            <th class="px-4 py-3 text-left">ID</th>
                            <th class="px-4 py-3 text-left">Document</th>
                            <th class="px-4 py-3 text-left">Barangay</th>
                            <th class="px-4 py-3 text-left">Base Price</th>
                            <th class="px-4 py-3 text-left">Fee</th>
                            <th class="px-4 py-3 text-left">Total</th>
                            <th class="px-4 py-3 text-left">Payment</th>
                            <th class="px-4 py-3 text-left">Status</th>
                            <th class="px-4 py-3 text-left">Submitted</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($requests as $req)
                            <tr class="border-t border-gray-200">
                                <td class="px-4 py-3">{{ $req->id }}</td>
                                <td class="px-4 py-3">{{ $req->document_type }}</td>
                                <td class="px-4 py-3">{{ $req->barangay ?? 'N/A' }}</td>
                                <td class="px-4 py-3">₱{{ number_format($req->base_price, 2) }}</td>
                                <td class="px-4 py-3">₱{{ number_format($req->service_fee, 2) }}</td>
                                <td class="px-4 py-3">₱{{ number_format($req->total_amount, 2) }}</td>
                                <td class="px-4 py-3">{{ $req->payment_method }}<br><span class="text-xs text-gray-500">{{ $req->payment_status }}</span></td>
                                <td class="px-4 py-3">{{ $req->status }}</td>
                                <td class="px-4 py-3">{{ $req->created_at->format('Y-m-d') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-4 py-6 text-center text-gray-500">No records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">{{ $requests->links() }}</div>
        </div>
    </div>
@endsection
