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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organizer_id')->constrained('users')->onDelete('cascade'); // Relasi ke User (Organizer)
            $table->string('name'); // Nama Konser
            $table->text('description'); // Lineup, Info
            $table->date('event_date');
            $table->time('event_time');
            $table->string('location'); // Venue
            $table->string('image')->nullable(); // Poster Konser
            $table->string('category'); // Rock, Jazz, Pop, dll
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
