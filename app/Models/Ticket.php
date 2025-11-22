<?php
// app/Models/Ticket.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'event_id',
        'nama_tiket',
        'deskripsi_tiket',
        'harga_tiket',
        'kuota', // Kuota tiket
    ];

    /**
     * Mendefinisikan relasi: Ticket adalah milik satu Event.
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Mendefinisikan relasi: Satu jenis Ticket dapat memiliki banyak Booking.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}