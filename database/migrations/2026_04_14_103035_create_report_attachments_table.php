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
        Schema::create('report_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained()->onDelete('cascade');
        
        // The path where the file is stored in MinIO (e.g., "reports/1/evidence.pdf")
        $table->string('file_path');
        
        // Original name of the file (e.g., "secret_document.pdf")
        $table->string('file_name');
        
        // Type of file (image/png, application/pdf, etc.)
        $table->string('mime_type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_attachments');
    }
};
