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
        Schema::create('report_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained()->onDelete('cascade');
        
        // Who sent it? 'admin' or 'whistleblower'
        $table->string('sender_type'); 
        
        // If an admin sent it, which admin? (Nullable for whistleblower)
        $table->foreignId('user_id')->nullable()->constrained();
        
        // The message content (we will encrypt this later)
        $table->text('message');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_messages');
    }
};
