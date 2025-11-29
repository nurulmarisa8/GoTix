<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_id',
        'ticket_id',
        'quantity',
        'total_price',
        'status',
    ];

    // --- 1. Relasi ke Pembeli (User) ---
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // --- 2. Relasi ke Event (INI YANG TADI HILANG) ---
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    // --- 3. Relasi ke Jenis Tiket ---
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}