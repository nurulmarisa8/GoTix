<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

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

    public function getImageUrlAttribute($value) {
        if ($value) {
            // If the image URL starts with 'http', it's likely an external URL, return as-is
            if (Str::startsWith($value, ['http://', 'https://'])) {
                return $value;
            }
            // Use asset helper for public symlinked files
            // Only add 'storage/' if it's not already part of the path
            if (!Str::startsWith($value, 'storage/')) {
                $value = 'storage/' . $value;
            }
            return asset($value);
        }
        return $value;
    }

    public function getAverageRating() {
        return $this->reviews()->avg('rating') ?? 0;
    }
}
