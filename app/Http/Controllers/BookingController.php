<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    // 1. BELI TIKET
    public function store(Request $request)
    {
        $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $ticket = Ticket::findOrFail($request->ticket_id);

        if ($ticket->quota < $request->quantity) {
            return redirect()->back()->with('error', 'Tiket habis atau kuota tidak cukup!');
        }

        $totalPrice = $ticket->price * $request->quantity;

        Booking::create([
            'user_id' => Auth::id(),
            'ticket_id' => $ticket->id,
            'event_id' => $ticket->event_id,
            'quantity' => $request->quantity,
            'total_price' => $totalPrice,
            'status' => 'pending', // <--- Default PENDING (Menunggu ACC)
        ]);

        $ticket->decrement('quota', $request->quantity);

        return redirect()->route('booking.history')->with('success', 'Tiket berhasil dipesan! Tunggu konfirmasi organizer.');
    }

    // 2. LIHAT HISTORY
    public function history()
    {
        $bookings = Booking::where('user_id', Auth::id())
                           ->with(['ticket.event'])
                           ->orderBy('created_at', 'desc')
                           ->get();
                           
        return view('bookings.history', compact('bookings'));
    }

    // 3. BATALKAN PESANAN
    public function cancel($id)
    {
        $booking = Booking::where('user_id', Auth::id())->findOrFail($id);

        if ($booking->status === 'pending') {
            $booking->update(['status' => 'canceled']);
            
            // KEMBALIKAN KUOTA TIKET
            $booking->ticket->increment('quota', $booking->quantity);
            
            return redirect()->back()->with('success', 'Pesanan berhasil dibatalkan.');
        }

        return redirect()->back()->with('error', 'Pesanan yang sudah diproses tidak bisa dibatalkan.');
    }
}