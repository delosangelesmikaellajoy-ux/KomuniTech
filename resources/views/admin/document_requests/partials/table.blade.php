<table class="min-w-full bg-white border border-gray-300 rounded-lg overflow-hidden">
    <thead class="bg-[#6BB1F3] text-white">
        <tr>
            <th class="px-4 py-2 text-left">Full Name</th>
            <th class="px-4 py-2 text-left">Barangay</th>
            <th class="px-4 py-2 text-left">Document Type</th>
            <th class="px-4 py-2 text-left">Base Price</th>
            <th class="px-4 py-2 text-left">Service Fee</th>
            <th class="px-4 py-2 text-left">Total Amount</th>
            <th class="px-4 py-2 text-left">Payment</th>
            <th class="px-4 py-2 text-left">Status</th>
            <th class="px-4 py-2 text-left">Submitted At</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($requests as $request)
            <tr class="border-t border-gray-200">
                <td class="px-4 py-2">{{ $request->fullname }}</td>
                <td class="px-4 py-2">{{ $request->barangay ?? '—' }}</td>
                <td class="px-4 py-2">{{ $request->document_type }}</td>
                <td class="px-4 py-2">₱{{ number_format($request->base_price, 2) }}</td>
                <td class="px-4 py-2">₱{{ number_format($request->service_fee, 2) }}</td>
                <td class="px-4 py-2">₱{{ number_format($request->total_amount, 2) }}</td>
                <td class="px-4 py-2">
                    {{ $request->payment_method ?? '—' }} 
                    @if($request->payment_status)
                        <span class="block text-xs text-gray-500">{{ $request->payment_status }}</span>
                    @endif
                </td>
                <td class="px-4 py-2">{{ $request->status }}</td>
                <td class="px-4 py-2">{{ $request->created_at->format('M d, Y') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="px-4 py-4 text-center text-gray-500">No requests found.</td>
            </tr>
        @endforelse
    </tbody>
</table>
