<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('document_type')->nullable()->after('description');
            $table->string('barangay')->nullable()->after('document_type');
            $table->decimal('base_price', 10, 2)->nullable()->after('barangay');
            $table->decimal('service_fee', 10, 2)->nullable()->after('base_price');
            $table->decimal('total_amount', 10, 2)->nullable()->after('service_fee');
            $table->string('payment_status')->nullable()->after('total_amount');
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn([
                'document_type',
                'barangay',
                'base_price',
                'service_fee',
                'total_amount',
                'payment_status',
            ]);
        });
    }
};
