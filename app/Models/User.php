<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     * (Atribut yang boleh diisi secara massal via create/update)
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'organizer_status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function events() {
        return $this->hasMany(Event::class);
    }

    public function bookings() {
        return $this->hasMany(Booking::class);
    }

    public function favorites() {
        return $this->belongsToMany(Event::class, 'favorites', 'user_id', 'event_id');
    }
}
