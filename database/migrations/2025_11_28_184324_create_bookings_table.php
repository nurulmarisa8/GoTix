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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('ticket_id')->constrained('tickets')->onDelete('cascade');
            
            // --- TAMBAHKAN BARIS INI ---
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            // ---------------------------
            
            $table->integer('quantity');
            $table->decimal('total_price', 12, 2);
            
            // Pastikan statusnya konsisten (pending, approved, canceled)
            $table->enum('status', ['pending', 'approved', 'canceled'])->default('pending');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
