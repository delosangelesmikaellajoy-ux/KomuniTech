<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('generated_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_request_id')->constrained('document_requests')->cascadeOnDelete();
            $table->foreignId('document_type_id')->nullable()->constrained('document_types')->nullOnDelete();
            $table->longText('html_content');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('generated_documents');
    }
};
