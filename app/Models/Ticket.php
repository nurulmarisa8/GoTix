<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model {
    protected $fillable = ['event_id', 'ticket_name', 'ticket_description', 'price', 'quota', 'available_quota', 'image_url'];
    
    public function event(): BelongsTo {
        return $this->belongsTo(Event::class);
    }
    
    public function bookings(): HasMany {
        return $this->hasMany(Booking::class);
    }
    
    public function getTotalSold() {
        return $this->quota - $this->available_quota;
    }
}
