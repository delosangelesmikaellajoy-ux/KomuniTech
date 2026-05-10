<?php

// database/migrations/xxxx_xx_xx_create_document_requests_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('document_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Personal info
            $table->string('fullname');
            $table->date('dob');
            $table->enum('sex', ['Male', 'Female']);
            $table->enum('civil_status', ['Single', 'Married', 'Widowed', 'Separated']);
            $table->string('address', 500);

            // Request details
            $table->enum('document_type', [
                'Barangay Clearance',
                'Certificate of Residency',
                'Indigency Certificate',
                'Business Clearance'
            ]);
            $table->string('purpose', 255);

            // ID and contact
            $table->string('id_presented', 255);
            $table->string('contact_number', 30);

            // Workflow/status
            $table->enum('status', ['Pending', 'Approved', 'Rejected'])->default('Pending');
            $table->text('remarks')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('document_requests');
    }
};
