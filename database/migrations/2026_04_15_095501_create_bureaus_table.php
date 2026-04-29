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
      
        Schema::create('bureaus', function (Blueprint $table) {
            $table->id();
            // The self-referencing parent ID
            $table->foreignId('parent_id')->nullable()->constrained('bureaus')->cascadeOnDelete();
            
            $table->string('name');
            // Optional: Helps identify if this is a Division, Department, etc.
            $table->string('level_type')->nullable(); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bureaus');
    }
};
