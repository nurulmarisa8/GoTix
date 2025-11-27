<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable {
    protected $fillable = ['name', 'email', 'password', 'role', 'organizer_status'];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = ['email_verified_at' => 'datetime'];
    
    public function events(): HasMany {
        return $this->hasMany(Event::class);
    }
    
    public function bookings(): HasMany {
        return $this->hasMany(Booking::class);
    }
    
    public function favorites(): BelongsToMany {
        return $this->belongsToMany(Event::class, 'favorites');
    }
    
    public function reviews(): HasMany {
        return $this->hasMany(Review::class);
    }
}
