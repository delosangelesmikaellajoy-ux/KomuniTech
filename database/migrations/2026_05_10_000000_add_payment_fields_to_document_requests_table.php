<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('document_requests', function (Blueprint $table) {
            $table->enum('payment_method', ['GCash', 'COD'])->default('COD')->after('contact_number');
            $table->enum('payment_status', ['Pending Verification', 'Pay on Pickup/Delivery', 'Verified'])
                ->default('Pay on Pickup/Delivery')
                ->after('payment_method');
            $table->string('gcash_reference')->nullable()->after('payment_status');
            $table->string('gcash_proof')->nullable()->after('gcash_reference');
        });
    }

    public function down(): void
    {
        Schema::table('document_requests', function (Blueprint $table) {
            $table->dropColumn(['gcash_proof', 'gcash_reference', 'payment_status', 'payment_method']);
        });
    }
};
