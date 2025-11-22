<?php
// app/Models/Booking.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'ticket_id',
        'quantity',
        'total_price',
        'status', // pending, approved, cancelled
        // Tambahkan kolom lain seperti booking_code, dll.
    ];

    /**
     * Mendefinisikan relasi: Booking dimiliki oleh satu User (Registered User).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mendefinisikan relasi: Booking mengacu pada satu jenis Ticket.
     */
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
    
    /**
     * Relasi pintas: Mendapatkan Event melalui Ticket
     */
    public function event()
    {
        return $this->hasOneThrough(Event::class, Ticket::class);
    }
}