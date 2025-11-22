<?php
// app/Models/User.php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     * Termasuk 'role' dan 'status_approval' untuk Organizer.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // admin, organizer, registered_user
        'status_approval', // pending, approved, rejected (khusus organizer)
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Mendefinisikan relasi: Seorang User (sebagai Organizer) dapat memiliki banyak Event.
     */
    public function events()
    {
        return $this->hasMany(Event::class, 'organizer_id');
    }

    /**
     * Mendefinisikan relasi: Seorang User (sebagai Registered User) dapat memiliki banyak Booking.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Mendefinisikan relasi: Seorang User (sebagai Registered User) dapat memiliki banyak FavoriteEvent.
     */
    public function favorites()
    {
        return $this->hasMany(FavoriteEvent::class);
    }
}