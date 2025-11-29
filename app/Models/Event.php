<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $guarded = [];

    // Relasi: Event milik satu Organizer
    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    // Relasi: Event punya banyak jenis tiket
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
