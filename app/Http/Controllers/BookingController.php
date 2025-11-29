<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    // --- 1. PROSES BELI TIKET ---
    public function store(Request $request)
    {
        // Validasi Input
        $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // Ambil Data Tiket
        $ticket = Ticket::findOrFail($request->ticket_id);

        // Cek Apakah Kuota Cukup
        if ($ticket->quota < $request->quantity) {
            return redirect()->back()->with('error', 'Maaf, tiket habis atau kuota tidak mencukupi!');
        }

        // Hitung Total Harga
        $totalPrice = $ticket->price * $request->quantity;

        // Simpan ke Database (Create Booking)
        Booking::create([
            'user_id' => Auth::id(),
            'ticket_id' => $ticket->id,
            'event_id' => $ticket->event_id,
            'quantity' => $request->quantity,
            'total_price' => $totalPrice,
            'status' => 'pending', 
        ]);

        // Kurangi Stok/Kuota Tiket
        $ticket->decrement('quota', $request->quantity);

        return redirect()->route('booking.history')->with('success', 'Tiket berhasil dipesan!');
    }

    // --- 2. RIWAYAT PEMESANAN (HISTORY) ---
    public function history()
    {
        // Ambil booking milik user yang sedang login
        $bookings = Booking::where('user_id', Auth::id())
                           ->with(['ticket.event']) // Load data tiket & event terkait
                           ->orderBy('created_at', 'desc')
                           ->get();
                           
        return view('bookings.history', compact('bookings'));
    }

    // --- 3. BATALKAN PESANAN ---
    public function cancel($id)
    {
        $booking = Booking::where('user_id', Auth::id())->findOrFail($id);

        // Hanya bisa batal kalau status masih pending (opsional: approved juga bisa kalau mau refund)
        // Di sini kita izinkan cancel pending saja agar aman.
        if ($booking->status === 'pending') {
            $booking->update(['status' => 'canceled']);
            
            // Balikin Quota Tiket ke database
            $booking->ticket->increment('quota', $booking->quantity);
            
            return redirect()->back()->with('success', 'Pesanan berhasil dibatalkan.');
        }

        return redirect()->back()->with('error', 'Pesanan yang sudah lunas tidak dapat dibatalkan.');
    }
}