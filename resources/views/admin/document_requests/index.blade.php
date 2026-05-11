
@extends('layouts.app')

@section('header')
    <header class="bg-gradient-to-r from-primary-50 to-primary-100 border-b border-primary-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <h1 class="text-4xl font-bold text-primary-900 flex items-center gap-3">
                <i class="fas fa-hourglass-half text-primary-600 text-3xl"></i>
                Manage Document Requests
            </h1>
            <p class="text-primary-700 mt-2">Review and approve pending requests from citizens</p>
        </div>
    </header>
@endsection

@section('content')
<div x-data="{ previewOpen: false, previewSrc: '', previewName: '', closePreview() { this.previewOpen = false; this.previewSrc = ''; this.previewName = ''; } }" x-effect="document.body.classList.toggle('overflow-hidden', previewOpen)" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Success/Error Alerts --}}
    @if(session('success'))
        <x-alert variant="success" dismissible>
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
        </x-alert>
    @endif

    @if($errors->any())
        <x-alert variant="error" dismissible>
            <i class="fas fa-exclamation-circle mr-2"></i>
            {{ $errors->first() }}
        </x-alert>
    @endif

    {{-- Use controller-provided, status-specific datasets --}}
    @php
        $pendingRequests = $pendingRequests ?? collect();
        $approvedRequests = $approvedRequests ?? collect();
        $rejectedRequests = $rejectedRequests ?? collect();
    @endphp

    {{-- Pending Requests Section --}}
    <div class="mb-12">
        <div class="flex items-center gap-3 mb-6">
            <div class="bg-warning-100 p-3 rounded-lg">
                <i class="fas fa-clock text-warning-600 text-xl"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-neutral-900">Pending Requests <span class="text-sm text-neutral-600">({{ count($pendingRequests) }})</span></h2>
                <p class="text-neutral-600 text-sm">Awaiting your action and approval</p>
            </div>
        </div>

        @if(count($pendingRequests) > 0)
            <x-card shadow="md" border>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-neutral-100 border-b border-neutral-200">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold text-neutral-900">Requester</th>
                                <th class="px-4 py-3 text-left font-semibold text-neutral-900">Document</th>
                                <th class="px-4 py-3 text-right font-semibold text-neutral-900">Amount</th>
                                <th class="px-4 py-3 text-center font-semibold text-neutral-900">Payment</th>
                                <th class="px-4 py-3 text-center font-semibold text-neutral-900">ID Photo</th>
                                <th class="px-4 py-3 text-left font-semibold text-neutral-900">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-200">
                            @foreach($pendingRequests as $req)
                                <tr class="hover:bg-neutral-50 transition">
                                    <td class="px-4 py-3">
                                        <div class="font-semibold text-neutral-900">{{ $req->fullname }}</div>
                                        <div class="text-xs text-neutral-600">{{ $req->contact_number }}</div>
                                        <div class="text-xs text-neutral-500">{{ $req->barangay ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="font-medium text-neutral-900">{{ $req->document_type_name }}</div>
                                        <div class="text-xs text-neutral-600">{{ Str::limit($req->purpose, 40) }}</div>
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <div class="font-semibold text-neutral-900">₱{{ number_format($req->total_amount, 2) }}</div>
                                        <div class="text-xs text-neutral-600">₱{{ number_format($req->base_price, 2) }} + ₱{{ number_format($req->service_fee, 2) }}</div>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="text-sm text-neutral-900">{{ $req->payment_method ?? '—' }}</div>
                                        <x-badge :variant="str_contains((string) $req->payment_status, 'Verified') || str_contains((string) $req->payment_status, 'Pay') ? 'success' : 'warning'" size="sm">
                                            {{ $req->payment_status ?? 'Pending' }}
                                        </x-badge>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        @php
                                            $photoExists = $req->id_photo && \Illuminate\Support\Facades\Storage::disk('public')->exists($req->id_photo);
                                            $photoUrl = $photoExists ? url('storage/' . ltrim($req->id_photo, '/')) : null;
                                        @endphp

                                        @if($photoUrl)
                                            <button
                                                type="button"
                                                class="inline-flex flex-col items-center group cursor-zoom-in"
                                                @click="previewOpen = true; previewSrc = @js($photoUrl); previewName = @js($req->fullname)"
                                            >
                                                <img
                                                    src="{{ $photoUrl }}"
                                                    alt="ID Photo"
                                                    loading="lazy"
                                                    class="w-16 h-16 rounded-xl object-cover border-2 border-neutral-200 shadow-sm group-hover:border-primary-500 group-hover:shadow-md transition"
                                                    onerror="this.style.display='none'; this.nextElementSibling.classList.remove('hidden');"
                                                >
                                                <span class="hidden mt-1 text-[11px] text-neutral-500 group-hover:text-primary-600">Click to preview</span>
                                                <span class="hidden inline-flex items-center justify-center w-16 h-16 bg-neutral-100 border-2 border-neutral-200 rounded-xl text-neutral-400">
                                                    <i class="fas fa-image"></i>
                                                </span>
                                            </button>
                                        @else
                                            <span class="inline-flex items-center justify-center w-16 h-16 bg-neutral-100 border-2 border-dashed border-neutral-300 rounded-xl text-neutral-400">
                                                <i class="fas fa-image"></i>
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex gap-1 flex-wrap">
                                            {{-- Approve Toggle --}}
                                            <button 
                                                type="button" 
                                                onclick="const form = document.getElementById('approve-{{ $req->id }}'); form.classList.toggle('hidden');"
                                                class="px-2 py-1 bg-success-100 text-success-700 rounded text-xs font-medium hover:bg-success-200 transition whitespace-nowrap"
                                            >
                                                <i class="fas fa-check mr-1"></i>Approve
                                            </button>

                                            {{-- Reject Toggle --}}
                                            <button 
                                                type="button"
                                                onclick="const form = document.getElementById('reject-{{ $req->id }}'); form.classList.toggle('hidden');"
                                                class="px-2 py-1 bg-error-100 text-error-700 rounded text-xs font-medium hover:bg-error-200 transition whitespace-nowrap"
                                            >
                                                <i class="fas fa-times mr-1"></i>Reject
                                            </button>
                                        </div>

                                        {{-- Approve Form --}}
                                        <form id="approve-{{ $req->id }}" action="{{ route('admin.document_requests.update', $req->id) }}" method="POST" class="hidden mt-2 p-2 bg-success-50 border border-success-200 rounded" onsubmit="event.target.style.opacity='0.6'; event.target.style.pointerEvents='none';">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="Approved">
                                            <div class="flex gap-1 items-end flex-wrap">
                                                <div class="flex-1">
                                                    <label class="block text-xs font-semibold text-neutral-700 mb-1">Release Date</label>
                                                    <input type="date" name="release_date" class="px-2 py-1 border border-neutral-300 rounded text-xs w-full" required min="{{ now()->format('Y-m-d') }}">
                                                </div>
                                                <button type="submit" class="px-2 py-1 bg-success-600 text-white rounded text-xs font-medium hover:bg-success-700 whitespace-nowrap">Confirm</button>
                                                <button type="button" onclick="document.getElementById('approve-{{ $req->id }}').classList.add('hidden')" class="px-2 py-1 bg-neutral-200 text-neutral-700 rounded text-xs whitespace-nowrap">Cancel</button>
                                            </div>
                                        </form>

                                        {{-- Reject Form --}}
                                        <form id="reject-{{ $req->id }}" action="{{ route('admin.document_requests.update', $req->id) }}" method="POST" class="hidden mt-2 p-2 bg-error-50 border border-error-200 rounded" onsubmit="if(!confirm('Are you sure you want to REJECT this request? This action cannot be undone.')) return false; event.target.style.opacity='0.6'; event.target.style.pointerEvents='none';">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="Rejected">
                                            <div class="flex gap-1 items-end flex-wrap">
                                                <input type="text" name="remarks" placeholder="Enter reason..." class="px-2 py-1 border border-neutral-300 rounded text-xs flex-1 min-w-max" maxlength="255" required>
                                                <button type="submit" class="px-2 py-1 bg-error-600 text-white rounded text-xs font-medium hover:bg-error-700 whitespace-nowrap">Reject</button>
                                                <button type="button" onclick="document.getElementById('reject-{{ $req->id }}').classList.add('hidden')" class="px-2 py-1 bg-neutral-200 text-neutral-700 rounded text-xs whitespace-nowrap">Cancel</button>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </x-card>
        @else
            <x-card shadow="sm">
                <div class="text-center py-12">
                    <i class="fas fa-check-circle text-success-400 text-4xl mb-3 block"></i>
                    <p class="text-neutral-600 font-medium">All pending requests processed!</p>
                    <p class="text-neutral-500 text-sm">No pending requests at this time.</p>
                </div>
            </x-card>
        @endif
    </div>

    {{-- Approved Requests Section --}}
    <div class="mb-12">
        <div class="flex items-center gap-3 mb-6">
            <div class="bg-success-100 p-3 rounded-lg">
                <i class="fas fa-check-circle text-success-600 text-xl"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-neutral-900">Approved Requests <span class="text-sm text-neutral-600">({{ count($approvedRequests) }})</span></h2>
                <p class="text-neutral-600 text-sm">Ready for download and distribution</p>
            </div>
        </div>

        @if(count($approvedRequests) > 0)
            <x-card shadow="md" border>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-neutral-100 border-b border-neutral-200">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold text-neutral-900">Requester</th>
                                <th class="px-4 py-3 text-left font-semibold text-neutral-900">Document</th>
                                <th class="px-4 py-3 text-left font-semibold text-neutral-900">Release Date</th>
                                <th class="px-4 py-3 text-right font-semibold text-neutral-900">Amount</th>
                                <th class="px-4 py-3 text-left font-semibold text-neutral-900">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-200">
                            @foreach($approvedRequests as $req)
                                <tr class="hover:bg-neutral-50 transition">
                                    <td class="px-4 py-3">
                                        <div class="font-semibold text-neutral-900">{{ $req->fullname }}</div>
                                        <div class="text-xs text-neutral-600">{{ $req->contact_number }}</div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="font-medium text-neutral-900">{{ $req->document_type_name }}</div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="font-medium text-neutral-900">{{ $req->release_date?->format('M d, Y') ?? '—' }}</div>
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <div class="font-semibold text-neutral-900">₱{{ number_format($req->total_amount, 2) }}</div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex gap-1 flex-wrap">
                                            <a href="{{ route('admin.document_requests.preview', $req->id) }}" target="_blank" class="inline-flex items-center gap-1 px-2 py-1 bg-primary-100 text-primary-700 rounded text-xs font-medium hover:bg-primary-200 transition" title="Preview document">
                                                <i class="fas fa-eye"></i>Preview
                                            </a>
                                            <a href="{{ route('admin.document_requests.download', [$req->id, 'word']) }}" class="inline-flex items-center gap-1 px-2 py-1 bg-neutral-200 text-neutral-700 rounded text-xs font-medium hover:bg-neutral-300 transition" title="Download as Word">
                                                <i class="fas fa-file-word"></i>.doc
                                            </a>
                                            <a href="{{ route('admin.document_requests.download', [$req->id, 'pdf']) }}" class="inline-flex items-center gap-1 px-2 py-1 bg-neutral-200 text-neutral-700 rounded text-xs font-medium hover:bg-neutral-300 transition" title="Download as PDF">
                                                <i class="fas fa-file-pdf"></i>PDF
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </x-card>
        @else
            <x-card shadow="sm">
                <div class="text-center py-12">
                    <i class="fas fa-inbox text-neutral-400 text-4xl mb-3 block"></i>
                    <p class="text-neutral-600 font-medium">No approved requests</p>
                </div>
            </x-card>
        @endif
    </div>

    {{-- Rejected Requests Section --}}
    <div>
        <div class="flex items-center gap-3 mb-6">
            <div class="bg-error-100 p-3 rounded-lg">
                <i class="fas fa-ban text-error-600 text-xl"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-neutral-900">Rejected Requests <span class="text-sm text-neutral-600">({{ count($rejectedRequests) }})</span></h2>
                <p class="text-neutral-600 text-sm">Requests that did not meet requirements</p>
            </div>
        </div>

        @if(count($rejectedRequests) > 0)
            <x-card shadow="md" border>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-neutral-100 border-b border-neutral-200">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold text-neutral-900">Requester</th>
                                <th class="px-4 py-3 text-left font-semibold text-neutral-900">Document</th>
                                <th class="px-4 py-3 text-left font-semibold text-neutral-900">Reason</th>
                                <th class="px-4 py-3 text-left font-semibold text-neutral-900">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-200">
                            @foreach($rejectedRequests as $req)
                                <tr class="hover:bg-neutral-50 transition">
                                    <td class="px-4 py-3">
                                        <div class="font-semibold text-neutral-900">{{ $req->fullname }}</div>
                                        <div class="text-xs text-neutral-600">{{ $req->contact_number }}</div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="font-medium text-neutral-900">{{ $req->document_type_name }}</div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <p class="text-neutral-700">{{ $req->remarks ?? '—' }}</p>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="text-sm text-neutral-600">{{ $req->updated_at->format('M d, Y') }}</div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </x-card>
        @else
            <x-card shadow="sm">
                <div class="text-center py-12">
                    <i class="fas fa-check-circle text-success-400 text-4xl mb-3 block"></i>
                    <p class="text-neutral-600 font-medium">No rejected requests</p>
                </div>
            </x-card>
        @endif
    </div>

    {{-- Pagination Info --}}
    @if(method_exists($pendingRequests, 'hasPages') && $pendingRequests->hasPages())
        <div class="mt-8 pt-6 border-t border-neutral-200">
            <p class="text-sm text-neutral-600 mb-4">Showing pending requests on this page.</p>
            {{ $pendingRequests->links() }}
        </div>
    @endif

    <div x-show="previewOpen" x-transition.opacity x-cloak class="fixed inset-0 z-[70] flex items-center justify-center bg-black/60 p-4" @click.self="closePreview()" @keydown.escape.window="closePreview()">
        <div class="w-full max-w-3xl overflow-hidden rounded-2xl bg-white shadow-2xl">
            <div class="flex items-center justify-between border-b border-neutral-200 px-4 py-3">
                <div>
                    <h3 class="font-semibold text-neutral-900">ID Photo Preview</h3>
                    <p class="text-sm text-neutral-500" x-text="previewName"></p>
                </div>
                <button type="button" class="rounded-lg p-2 hover:bg-neutral-100" @click="closePreview()" aria-label="Close preview">
                    <i class="fas fa-times text-neutral-600"></i>
                </button>
            </div>
            <div class="flex min-h-[320px] items-center justify-center bg-neutral-950">
                <img :src="previewSrc" alt="ID Preview" class="max-h-[80vh] w-full object-contain" onerror="this.outerHTML='<div class=\'p-8 text-center text-white\'><i class=\'fas fa-triangle-exclamation text-3xl mb-3 block\'></i><p>Unable to load preview image.</p></div>'">
            </div>
        </div>
    </div>
</div>
