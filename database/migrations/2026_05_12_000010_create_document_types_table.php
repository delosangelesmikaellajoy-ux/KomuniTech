<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('document_types', function (Blueprint $table) {
            $table->id();
            $table->string('barangay');
            $table->string('name');
            $table->decimal('base_price', 10, 2)->default(0);
            $table->text('template_html')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['barangay', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('document_types');
    }
};
