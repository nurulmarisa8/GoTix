<?php
// app/Http/Controllers/Organizer/BookingController.php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /** Tampilkan daftar pemesanan untuk acara Organizer saat ini. */
    public function index() {
        // Ambil semua Booking untuk event yang dimiliki Organizer
        $bookings = Booking::whereHas('event', function ($query) {
            $query->where('organizer_id', Auth::id());
        })->with('user', 'ticket.event')->paginate(15);
        
        return view('organizer.bookings.index', compact('bookings'));
    }

    /** Menyetujui atau membatalkan pesanan tiket[cite: 610]. */
    public function updateStatus(Request $request, Booking $booking) {
        $request->validate(['status' => 'required|in:approved,cancelled']);

        if ($request->status == 'cancelled' && $booking->status != 'cancelled') {
            // Jika dibatalkan, kuota tiket harus dikembalikan [cite: 622]
            $booking->ticket->increment('kuota', $booking->quantity);
        }
        
        $booking->update(['status' => $request->status]);

        return back()->with('success', 'Status pemesanan berhasil diperbarui.');
    }
}