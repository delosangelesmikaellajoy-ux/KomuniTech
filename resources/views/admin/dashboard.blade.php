@extends('layouts.app')

@section('header')
    <header class="bg-gradient-to-r from-primary-50 to-primary-100 border-b border-primary-200">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold text-primary-900">
                        <i class="fas fa-chart-line mr-3"></i>Barangay Admin Dashboard
                    </h1>
                    <p class="text-primary-700 mt-2">Monitor and manage document requests efficiently</p>
                </div>
                <div class="text-right hidden md:block">
                    <p class="text-primary-700 text-sm">Welcome back,</p>
                    <p class="text-primary-900 font-semibold">{{ Auth::user()->name }}</p>
                </div>
            </div>
        </div>
    </header>
@endsection

@section('content')
    <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Key Metrics Row -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <!-- Pending Requests Card -->
            <a href="{{ route('admin.document_requests.pending') }}" class="transform hover:scale-105 transition">
                <x-card class="border bg-gradient-to-br from-warning-50 to-warning-100 border-warning-200 cursor-pointer h-full">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-warning-700 text-sm font-medium mb-1">Pending Requests</p>
                            <p class="text-4xl font-bold text-warning-900">{{ $pendingCount }}</p>
                        </div>
                        <div class="text-warning-300 opacity-20">
                            <i class="fas fa-hourglass-half text-6xl"></i>
                        </div>
                    </div>
                    <p class="text-xs text-warning-600 mt-3">Awaiting review</p>
                </x-card>
            </a>

            <!-- Approved Requests Card -->
            <a href="{{ route('admin.document_requests.approved') }}" class="transform hover:scale-105 transition">
                <x-card class="border bg-gradient-to-br from-success-50 to-success-100 border-success-200 cursor-pointer h-full">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-success-700 text-sm font-medium mb-1">Approved Requests</p>
                            <p class="text-4xl font-bold text-success-900">{{ $approvedCount }}</p>
                        </div>
                        <div class="text-success-300 opacity-20">
                            <i class="fas fa-check-circle text-6xl"></i>
                        </div>
                    </div>
                    <p class="text-xs text-success-600 mt-3">Ready for pickup/delivery</p>
                </x-card>
            </a>

            <!-- Rejected Requests Card -->
            <a href="{{ route('admin.document_requests.rejected') }}" class="transform hover:scale-105 transition">
                <x-card class="border bg-gradient-to-br from-error-50 to-error-100 border-error-200 cursor-pointer h-full">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-error-700 text-sm font-medium mb-1">Rejected Requests</p>
                            <p class="text-4xl font-bold text-error-900">{{ $rejectedCount }}</p>
                        </div>
                        <div class="text-error-300 opacity-20">
                            <i class="fas fa-times-circle text-6xl"></i>
                        </div>
                    </div>
                    <p class="text-xs text-error-600 mt-3">Not approved</p>
                </x-card>
            </a>

            <!-- Service Fees Collected -->
            <div class="transform hover:scale-105 transition">
                <x-card class="border bg-gradient-to-br from-primary-50 to-primary-100 border-primary-200 h-full">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-primary-700 text-sm font-medium mb-1">Service Fees</p>
                            <p class="text-4xl font-bold text-primary-900">₱{{ number_format($collectedServiceFees, 2) }}</p>
                        </div>
                        <div class="text-primary-300 opacity-20">
                            <i class="fas fa-peso-sign text-6xl"></i>
                        </div>
                    </div>
                    <p class="text-xs text-primary-600 mt-3">Collected from approvals</p>
                </x-card>
            </div>
        </div>

        <!-- Quick Actions Section -->
        <x-card class="border mb-8">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-neutral-900 mb-2">
                    <i class="fas fa-bolt text-warning-600 mr-2"></i>Quick Actions
                </h2>
                <p class="text-neutral-600 text-sm">Access key administrative features</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <!-- Manage Requests -->
                <a href="{{ route('admin.document_requests.index') }}" 
                   class="flex items-center gap-4 p-4 bg-primary-50 rounded-lg border border-primary-200 hover:border-primary-400 hover:bg-primary-100 transition">
                    <div class="flex-shrink-0 w-12 h-12 bg-primary-200 rounded-lg flex items-center justify-center text-primary-700 text-xl">
                        <i class="fas fa-tasks"></i>
                    </div>
                    <div class="flex-grow">
                        <h3 class="font-semibold text-neutral-900">Manage Requests</h3>
                        <p class="text-xs text-neutral-600">Review and approve documents</p>
                    </div>
                    <i class="fas fa-arrow-right text-neutral-400"></i>
                </a>

                <!-- Document Types -->
                <a href="{{ route('admin.document_types.index') }}" 
                   class="flex items-center gap-4 p-4 bg-success-50 rounded-lg border border-success-200 hover:border-success-400 hover:bg-success-100 transition">
                    <div class="flex-shrink-0 w-12 h-12 bg-success-200 rounded-lg flex items-center justify-center text-success-700 text-xl">
                        <i class="fas fa-file-invoice"></i>
                    </div>
                    <div class="flex-grow">
                        <h3 class="font-semibold text-neutral-900">Document Types</h3>
                        <p class="text-xs text-neutral-600">Manage pricing & templates</p>
                    </div>
                    <i class="fas fa-arrow-right text-neutral-400"></i>
                </a>

                <!-- Announcements -->
                <a href="{{ route('admin.announcements.index') }}" 
                   class="flex items-center gap-4 p-4 bg-info-50 rounded-lg border border-info-200 hover:border-info-400 hover:bg-info-100 transition">
                    <div class="flex-shrink-0 w-12 h-12 bg-info-200 rounded-lg flex items-center justify-center text-info-700 text-xl">
                        <i class="fas fa-bullhorn"></i>
                    </div>
                    <div class="flex-grow">
                        <h3 class="font-semibold text-neutral-900">Announcements</h3>
                        <p class="text-xs text-neutral-600">Post updates to users</p>
                    </div>
                    <i class="fas fa-arrow-right text-neutral-400"></i>
                </a>
            </div>
        </x-card>

        <!-- Info Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Getting Started -->
            <x-card class="border bg-neutral-50">
                <h3 class="text-lg font-bold text-neutral-900 mb-4 flex items-center">
                    <i class="fas fa-lightbulb text-warning-600 mr-2"></i>Getting Started
                </h3>
                <ul class="space-y-3 text-sm text-neutral-700">
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-success-600 mr-3 flex-shrink-0 mt-0.5"></i>
                        <span>Set up document types and configure pricing</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-success-600 mr-3 flex-shrink-0 mt-0.5"></i>
                        <span>Review pending document requests</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-success-600 mr-3 flex-shrink-0 mt-0.5"></i>
                        <span>Approve or reject with feedback</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-success-600 mr-3 flex-shrink-0 mt-0.5"></i>
                        <span>Post announcements to keep users informed</span>
                    </li>
                </ul>
            </x-card>

            <!-- System Info -->
            <x-card class="border bg-neutral-50">
                <h3 class="text-lg font-bold text-neutral-900 mb-4 flex items-center">
                    <i class="fas fa-info-circle text-info-600 mr-2"></i>System Information
                </h3>
                <dl class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-neutral-600">Your Barangay:</dt>
                        <dd class="font-semibold text-neutral-900">{{ Auth::user()->barangay }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-neutral-600">Account Status:</dt>
                        <dd class="flex items-center">
                            <i class="fas fa-check-circle text-success-600 mr-2"></i>
                            <span class="font-semibold text-success-700">Active</span>
                        </dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-neutral-600">Role:</dt>
                        <dd class="font-semibold text-neutral-900">Barangay Administrator</dd>
                    </div>
                </dl>
            </x-card>
        </div>
    </div>
@endsection
