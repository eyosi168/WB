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
        Schema::table('report_messages', function (Blueprint $table) {
            // Adds the nullable attachment_path column right after the message column
            $table->string('attachment_path')->nullable()->after('message');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('report_messages', function (Blueprint $table) {
            // Drops the column if you ever need to rollback
            $table->dropColumn('attachment_path');
        });
    }
};
