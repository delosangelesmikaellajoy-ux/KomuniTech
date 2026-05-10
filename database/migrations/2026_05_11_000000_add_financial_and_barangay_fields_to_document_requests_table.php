<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('document_requests', function (Blueprint $table) {
            $table->string('barangay')->nullable()->after('contact_number');
            $table->decimal('base_price', 10, 2)->default(0)->after('document_type');
            $table->decimal('service_fee', 10, 2)->default(20)->after('base_price');
            $table->decimal('total_amount', 10, 2)->default(20)->after('service_fee');
        });
    }

    public function down(): void
    {
        Schema::table('document_requests', function (Blueprint $table) {
            $table->dropColumn(['total_amount', 'service_fee', 'base_price', 'barangay']);
        });
    }
};
