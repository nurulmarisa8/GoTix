<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Event extends Model {
    protected $fillable = ['user_id', 'name', 'description', 'event_date', 'location', 'image_url', 'status'];
    protected $casts = ['event_date' => 'datetime'];
    
    public function organizer(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function tickets(): HasMany {
        return $this->hasMany(Ticket::class);
    }
    
    public function bookings(): HasMany {
        return $this->hasMany(Booking::class, 'ticket_id', 'id');
    }
    
    public function favoritedBy(): BelongsToMany {
        return $this->belongsToMany(User::class, 'favorites');
    }
    
    public function reviews(): HasMany {
        return $this->hasMany(Review::class);
    }
    
    public function getAverageRating() {
        return $this->reviews()->avg('rating') ?? 0;
    }
}
