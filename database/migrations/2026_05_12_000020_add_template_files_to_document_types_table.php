<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('document_types', function (Blueprint $table) {
            $table->string('template_file_path')->nullable()->after('template_html');
            $table->string('template_file_name')->nullable()->after('template_file_path');
            $table->string('template_file_mime')->nullable()->after('template_file_name');
            $table->string('template_file_type', 20)->nullable()->after('template_file_mime');
            $table->unsignedBigInteger('template_file_size')->nullable()->after('template_file_type');
            $table->longText('editable_template_content')->nullable()->after('template_file_size');
        });
    }

    public function down(): void
    {
        Schema::table('document_types', function (Blueprint $table) {
            $table->dropColumn([
                'template_file_path',
                'template_file_name',
                'template_file_mime',
                'template_file_type',
                'template_file_size',
                'editable_template_content',
            ]);
        });
    }
};
