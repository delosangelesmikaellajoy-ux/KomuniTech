@extends('layouts.app')

@section('header')
    <header class="bg-gradient-to-r from-[#6BB1F3] to-[#A2D3F9] shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-[#0B1F3A] font-semibold">
            <h2 class="font-cute text-xl text-[#0B1F3A] leading-tight">
                {{ __('Request Barangay Document') }}
            </h2>
        </div>
    </header>
@endsection

@section('content')
    <div class="py-12 w-full">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Main Container with gradient background -->
            <div class="bg-gradient-to-b from-[#6BB1F3] to-[#A2D3F9] overflow-hidden shadow-xl rounded-lg p-10">
                @if(session('success'))
                    <div class="mb-4 text-green-600 font-semibold">{{ session('success') }}</div>
                @endif

                <!-- Form in 2-column grid -->
                <form action="{{ route('document_requests.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @csrf

                    <div class="md:col-span-2 bg-white rounded-lg shadow p-5 border border-[#E0C9A6]">
                        <p class="font-semibold text-[#0B1F3A]">Your Assigned Barangay:</p>
                        <p class="mt-1 text-lg text-[#0B1F3A]">{{ Auth::user()->barangay ?? 'Not assigned' }}</p>
                    </div>

                    <div class="md:col-span-2 bg-white rounded-lg shadow p-5 border border-[#E0C9A6]">
                        <h3 class="font-semibold text-[#0B1F3A]">Price Summary</h3>
                        <div class="mt-3 grid grid-cols-1 sm:grid-cols-3 gap-3 text-[#0B1F3A]">
                            <div class="rounded-lg bg-[#FDF5E6] p-4 border border-[#D1D5DB]">
                                <span class="block text-sm font-semibold">Base Price</span>
                                <span id="base-price" class="text-xl font-bold">₱0.00</span>
                            </div>
                            <div class="rounded-lg bg-[#FDF5E6] p-4 border border-[#D1D5DB]">
                                <span class="block text-sm font-semibold">Service Fee</span>
                                <span class="text-xl font-bold">₱{{ number_format(\App\Models\DocumentRequest::SERVICE_FEE, 2) }}</span>
                            </div>
                            <div class="rounded-lg bg-[#FDF5E6] p-4 border border-[#D1D5DB]">
                                <span class="block text-sm font-semibold">Total Amount</span>
                                <span id="total-amount" class="text-xl font-bold">₱0.00</span>
                            </div>
                        </div>
                    </div>

                    <!-- Full Name -->
                    <div>
                        <label for="fullname" class="block font-semibold text-[#0B1F3A]">Full Name</label>
                        <input type="text" name="fullname" value="{{ old('fullname') }}"
                               class="mt-1 block w-full h-12 rounded-lg bg-[#FDF5E6] border border-[#E0C9A6] focus:ring-[#3B82F6] focus:border-[#3B82F6]" required>
                    </div>

                    <!-- Date of Birth -->
                    <div>
                        <label for="dob" class="block font-semibold text-[#0B1F3A]">Date of Birth</label>
                        <input type="date" name="dob"
                               class="mt-1 block w-full h-12 rounded-lg bg-[#FDF5E6] border border-[#E0C9A6] focus:ring-[#3B82F6] focus:border-[#3B82F6]" required>
                    </div>

                    <!-- Sex -->
                    <div>
                        <label for="sex" class="block font-semibold text-[#0B1F3A]">Sex</label>
                        <select name="sex"
                                class="mt-1 block w-full h-12 rounded-lg bg-[#FDF5E6] border border-[#E0C9A6] focus:ring-[#3B82F6] focus:border-[#3B82F6]" required>
                            <option value="">Select</option>
                            <option value="Male" {{ old('sex') === 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('sex') === 'Female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>

                    <!-- Civil Status -->
                    <div>
                        <label for="civil_status" class="block font-semibold text-[#0B1F3A]">Civil Status</label>
                        <select name="civil_status"
                                class="mt-1 block w-full h-12 rounded-lg bg-[#FDF5E6] border border-[#E0C9A6] focus:ring-[#3B82F6] focus:border-[#3B82F6]" required>
                            <option value="">Select</option>
                            <option value="Single" {{ old('civil_status') === 'Single' ? 'selected' : '' }}>Single</option>
                            <option value="Married" {{ old('civil_status') === 'Married' ? 'selected' : '' }}>Married</option>
                            <option value="Widowed" {{ old('civil_status') === 'Widowed' ? 'selected' : '' }}>Widowed</option>
                            <option value="Separated" {{ old('civil_status') === 'Separated' ? 'selected' : '' }}>Separated</option>
                        </select>
                    </div>

                    <!-- Address -->
                    <div>
                        <label for="address" class="block font-semibold text-[#0B1F3A]">Complete Address</label>
                        <input type="text" name="address" value="{{ old('address') }}"
                               class="mt-1 block w-full h-12 rounded-lg bg-[#FDF5E6] border border-[#E0C9A6] focus:ring-[#3B82F6] focus:border-[#3B82F6]" required>
                    </div>

                    <!-- Document Type -->
                    <div>
                        <label for="document_type_id" class="block font-semibold text-[#0B1F3A]">Document Requested</label>
                        <select name="document_type_id"
                                class="mt-1 block w-full h-12 rounded-lg bg-[#FDF5E6] border border-[#E0C9A6] focus:ring-[#3B82F6] focus:border-[#3B82F6]" required>
                            <option value="">Select</option>
                            @foreach($documentTypes as $type)
                                <option value="{{ $type->id }}"
                                        data-base-price="{{ $type->base_price }}"
                                        {{ old('document_type_id') == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                        @if($documentTypes->isEmpty())
                            <p class="mt-2 text-sm text-red-600">No active document types are available for your barangay. Please contact your Barangay Admin.</p>
                        @endif
                    </div>

                    <!-- Purpose -->
                    <div class="md:col-span-2">
                        <label for="purpose" class="block font-semibold text-[#0B1F3A]">Purpose of Request</label>
                        <textarea name="purpose"
                                  class="mt-1 block w-full h-24 rounded-lg bg-[#FDF5E6] border border-[#E0C9A6] focus:ring-[#3B82F6] focus:border-[#3B82F6]" required>{{ old('purpose') }}</textarea>
                    </div>

                    <!-- Valid ID -->
                    <div>
                        <label for="id_presented" class="block font-semibold text-[#0B1F3A]">Valid ID Presented</label>
                        <input type="text" name="id_presented" value="{{ old('id_presented') }}" placeholder="e.g., Driver’s License, ID No."
                               class="mt-1 block w-full h-12 rounded-lg bg-[#FDF5E6] border border-[#E0C9A6] focus:ring-[#3B82F6] focus:border-[#3B82F6]" required>
                    </div>

                    <!-- Upload ID Photo -->
                    <div>
                        <label for="id_photo" class="block font-semibold text-[#0B1F3A]">Upload ID Photo</label>
                        <input type="file" name="id_photo" accept="image/*"
                               class="mt-1 block w-full h-12 rounded-lg bg-[#FDF5E6] border border-[#E0C9A6] focus:ring-[#3B82F6] focus:border-[#3B82F6]" required>
                        <small class="text-gray-600">Accepted formats: JPG, JPEG, PNG (max 2MB)</small>
                    </div>

                    <!-- Contact Number -->
                    <div>
                        <label for="contact_number" class="block font-semibold text-[#0B1F3A]">Contact Number</label>
                        <input type="text" name="contact_number" value="{{ old('contact_number') }}"
                               class="mt-1 block w-full h-12 rounded-lg bg-[#FDF5E6] border border-[#E0C9A6] focus:ring-[#3B82F6] focus:border-[#3B82F6]" required>
                    </div>

                    <!-- Payment Method -->
                    <div class="md:col-span-2">
                        <label for="payment_method" class="block font-semibold text-[#0B1F3A]">Payment Method</label>
                        <select id="payment_method" name="payment_method" onchange="toggleGcashFields()"
                                class="mt-1 block w-full h-12 rounded-lg bg-[#FDF5E6] border border-[#E0C9A6] focus:ring-[#3B82F6] focus:border-[#3B82F6]" required>
                            <option value="">Select Payment Method</option>
                            <option value="GCash" {{ old('payment_method') === 'GCash' ? 'selected' : '' }}>GCash</option>
                            <option value="COD" {{ old('payment_method') === 'COD' ? 'selected' : '' }}>Cash on Delivery (COD)</option>
                        </select>
                        @error('payment_method')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div id="gcash-details" class="md:col-span-2 hidden">
                        <div class="mb-4">
                            <label for="gcash_reference" class="block font-semibold text-[#0B1F3A]">GCash Reference Number (optional)</label>
                            <input type="text" name="gcash_reference" value="{{ old('gcash_reference') }}"
                                   class="mt-1 block w-full h-12 rounded-lg bg-[#FDF5E6] border border-[#E0C9A6] focus:ring-[#3B82F6] focus:border-[#3B82F6]">
                        </div>

                        <div>
                            <label for="gcash_proof" class="block font-semibold text-[#0B1F3A]">Upload GCash Proof (optional)</label>
                            <input type="file" name="gcash_proof" accept="image/*"
                                   class="mt-1 block w-full h-12 rounded-lg bg-[#FDF5E6] border border-[#E0C9A6] focus:ring-[#3B82F6] focus:border-[#3B82F6]">
                            @error('gcash_proof')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end items-end md:col-span-2">
                        <button type="submit"
                            class="px-6 py-3 bg-blue-700 text-white font-semibold rounded-lg shadow-md hover:bg-blue-800 transition transform hover:scale-105">
                              Submit Request
                        </button>
                    </div>
                </form>

                <script>
                    const serviceFee = Number({{ \App\Models\DocumentRequest::SERVICE_FEE }});

                    function toggleGcashFields() {
                        const paymentMethod = document.getElementById('payment_method').value;
                        const gcashSection = document.getElementById('gcash-details');
                        gcashSection.style.display = paymentMethod === 'GCash' ? 'block' : 'none';
                    }

                    function updatePriceSummary() {
                        const selectedOption = document.querySelector('[name="document_type_id"] option:checked');
                        const basePrice = selectedOption ? Number(selectedOption.dataset.basePrice || 0) : 0;
                        const total = basePrice + serviceFee;

                        document.getElementById('base-price').textContent = `₱${basePrice.toFixed(2)}`;
                        document.getElementById('total-amount').textContent = `₱${total.toFixed(2)}`;
                    }

                    document.addEventListener('DOMContentLoaded', function () {
                        const documentTypeSelect = document.querySelector('[name="document_type_id"]');
                        documentTypeSelect.addEventListener('change', updatePriceSummary);
                        updatePriceSummary();
                        toggleGcashFields();
                    });
                </script>
            </div>
        </div>
    </div>
@endsection
