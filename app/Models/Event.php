<?php
// app/Models/Event.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'organizer_id',
        'nama_acara',
        'deskripsi',
        'tanggal_waktu',
        'lokasi',
        'gambar_acara',
        // Tambahkan kolom lain sesuai kebutuhan migrasi
    ];

    /**
     * Mendefinisikan relasi: Event dimiliki oleh satu Organizer (User).
     */
    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    /**
     * Mendefinisikan relasi: Satu Event dapat memiliki banyak jenis Ticket.
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
    
    /**
     * Mendefinisikan relasi: Satu Event dapat memiliki banyak FavoriteEvent.
     */
    public function favorites()
    {
        return $this->hasMany(FavoriteEvent::class);
    }
}