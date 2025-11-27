<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model {
    protected $fillable = ['user_id', 'ticket_id', 'quantity', 'total_price', 'status', 'cancel_deadline'];
    protected $casts = ['cancel_deadline' => 'datetime', 'cancelled_at' => 'datetime'];
    
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
    
    public function ticket(): BelongsTo {
        return $this->belongsTo(Ticket::class);
    }
    
    public function canBeCancelled(): bool {
        return $this->status === 'approved' && now()->lessThan($this->cancel_deadline);
    }
}
