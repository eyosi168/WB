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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            // The unique ID they get (e.g., RPT-4829)
        $table->string('tracking_id')->unique(); 
        
        // We will hash the 6-digit passcode for safety
        $table->string('passcode'); 
        
        // Relationships
        $table->foreignId('bureau_id')->constrained();
        $table->foreignId('category_id')->constrained();
        
        // The actual report - we will encrypt this later in the Model
        $table->text('description'); 
        
        // Status tracking
        $table->string('status')->default('pending'); // pending, investigating, closed
        $table->string('priority')->default('medium');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
