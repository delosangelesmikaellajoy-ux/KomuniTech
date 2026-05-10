@extends('layouts.app')

@section('header')
    <header class="bg-gradient-to-r from-[#6BB1F3] to-[#A2D3F9] shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-[#0B1F3A] font-semibold">
            <h2 class="font-cute text-2xl text-[#0B1F3A] leading-tight">
                {{ __('Audit Logs') }}
            </h2>
        </div>
    </header>
@endsection

@section('content')
    <div class="py-12 px-6 lg:px-12 w-full">
        <!-- Bigger full-width container -->
        <div class="w-full max-w-full mx-auto bg-[#FDF5E6] shadow-xl rounded-lg p-12">

            <table class="w-full border-collapse rounded-lg overflow-hidden shadow-lg">
                <thead>
                    <tr class="bg-gradient-to-r from-[#6BB1F3] to-[#A2D3F9] text-[#0B1F3A]">
                        <th class="px-6 py-4 text-left font-semibold">Request</th>
                        <th class="px-6 py-4 text-left font-semibold">Action</th>
                        <th class="px-6 py-4 text-left font-semibold">Remarks</th>
                        <th class="px-6 py-4 text-left font-semibold">By</th>
                        <th class="px-6 py-4 text-left font-semibold">When</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        <!-- Highlighted row -->
                        <tr class="bg-gradient-to-r from-[#E0F2FE] to-[#F0F9FF] border-b hover:from-[#BAE6FD] hover:to-[#E0F2FE] transition">
                            <td class="px-6 py-4">
                                <div class="font-semibold text-[#0B1F3A]">#{{ $log->document_request_id }}</div>
                                <div class="text-xs text-gray-600">
                                    {{ optional($log->request)->document_type }}
                                </div>
                            </td>
                            <td class="px-6 py-4 text-[#0B1F3A] font-semibold">
                                {{ $log->action }}
                            </td>
                            <td class="px-6 py-4 text-sm text-[#0B1F3A]">
                                {{ $log->remarks ?? '—' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-[#0B1F3A]">
                                {{ optional($log->causer)->name ?? 'System' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-[#0B1F3A]">
                                {{ $log->created_at->format('M d, Y h:i A') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-[#0B1F3A] bg-gradient-to-r from-[#6BB1F3] to-[#A2D3F9] rounded-lg">
                                No logs yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-8">
                {{ $logs->links() }}
            </div>
        </div>
    </div>
@endsection
