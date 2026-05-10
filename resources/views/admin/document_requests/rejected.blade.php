@extends('layouts.app')

@section('header')
    <header class="bg-gradient-to-r from-red-300 to-red-200 shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <!-- Smaller heading -->
            <h2 class="font-cute text-xl font-bold text-[#0B1F3A] leading-tight">
                {{ __('Rejected Requests') }}
            </h2>
        </div>
    </header>
@endsection

@section('content')
    <div class="px-4">
        <!-- Nude container with red highlight line -->
        <div class="bg-[#FDF5E6] shadow-xl rounded-lg p-8 w-full max-w-4xl mx-auto mt-8 border-t-4 border-red-500">
            <div class="bg-white rounded-lg shadow-md p-6">
                @include('admin.document_requests.partials.table', ['requests' => $requests])
            </div>
        </div>
    </div>
@endsection
