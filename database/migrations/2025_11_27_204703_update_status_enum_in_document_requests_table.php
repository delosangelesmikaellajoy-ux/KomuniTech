<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('document_requests', function (Blueprint $table) {
            DB::statement("ALTER TABLE document_requests MODIFY status ENUM('Pending', 'Approved', 'Rejected', 'Cancelled') NOT NULL");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('document_requests', function (Blueprint $table) {
            DB::statement("ALTER TABLE document_requests MODIFY status ENUM('Pending', 'Approved', 'Rejected') NOT NULL");
        });
    }
};
