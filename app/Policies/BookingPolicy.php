<?php

namespace App\Policies;
use App\Models\Booking;
use App\Models\User;

class BookingPolicy {
    public function view(User $user, Booking $booking): bool {
        return $user->id === $booking->user_id || $user->role === 'admin';
    }

    public function cancel(User $user, Booking $booking): bool {
        return $user->id === $booking->user_id;
    }

    public function update(User $user, Booking $booking): bool {
        // Organizer can approve/reject bookings for events they created
        return $user->id === $booking->ticket->event->user_id || $user->role === 'admin';
    }
}
