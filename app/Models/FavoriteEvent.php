<?php
// app/Models/FavoriteEvent.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoriteEvent extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'event_id',
    ];

    /**
     * Mendefinisikan relasi: FavoriteEvent dimiliki oleh satu User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mendefinisikan relasi: FavoriteEvent mengacu pada satu Event.
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}