<?php

namespace App\Http\Controllers;
use App\Models\Booking;
use App\Models\Ticket;
use Illuminate\Http\Request;

class BookingController extends Controller {
    public function __construct() {
        $this->middleware(['auth']);
    }
    
    public function store(Request $request, Ticket $ticket) {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $ticket->available_quota
        ]);
        
        $totalPrice = $ticket->price * $validated['quantity'];
        
        $booking = Booking::create([
            'user_id' => auth()->id(),
            'ticket_id' => $ticket->id,
            'quantity' => $validated['quantity'],
            'total_price' => $totalPrice,
            'cancel_deadline' => now()->addDays(3)
        ]);
        
        $ticket->update(['available_quota' => $ticket->available_quota - $validated['quantity']]);
        
        return redirect()->route('booking.show', $booking)->with('success', 'Booking pending approval');
    }
    
    public function show(Booking $booking) {
        $this->authorize('view', $booking);
        return view('bookings.show', compact('booking'));
    }
    
    public function history() {
        $bookings = auth()->user()->bookings()->with('ticket.event')->paginate(10);
        return view('bookings.history', compact('bookings'));
    }
    
    public function cancel(Booking $booking) {
        $this->authorize('cancel', $booking);
        
        if (!$booking->canBeCancelled()) {
            return back()->withErrors('Cannot cancel this booking');
        }
        
        $booking->update(['status' => 'cancelled', 'cancelled_at' => now()]);
        $booking->ticket->update(['available_quota' => $booking->ticket->available_quota + $booking->quantity]);
        
        return back()->with('success', 'Booking cancelled');
    }

    public function organizerBookings() {
    $organizer = auth()->user();
    $bookings = Booking::whereIn('ticket_id', function($query) use ($organizer) {
        $query->select('id')
            ->from('tickets')
            ->whereIn('event_id', $organizer->events()->pluck('id'));
    })
    ->with('user', 'ticket.event')
    ->paginate(15);
    
    return view('organizer.bookings.index', compact('bookings'));
}

    public function approveBooking(Booking $booking) {
        $this->authorize('update', $booking->ticket->event);
        $booking->update(['status' => 'approved']);
        return back()->with('success', 'Booking approved');
    }

    public function rejectBooking(Booking $booking) {
        $this->authorize('update', $booking->ticket->event);
        
        if ($booking->status === 'pending') {
            $booking->update(['status' => 'rejected']);
            $booking->ticket->update(['available_quota' => $booking->ticket->available_quota + $booking->quantity]);
        }
        
        return back()->with('success', 'Booking rejected');
    }
}

