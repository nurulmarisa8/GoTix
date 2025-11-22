<?php
// app/Http/Controllers/User/BookingController.php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /** Memproses pemesanan tiket (pengurangan kuota)[cite: 615]. */
    public function bookTicket(Request $request) {
        // Logika validasi dan transaksi kuota tiket
        DB::beginTransaction();
        try {
            $ticket = Ticket::findOrFail($request->ticket_id);
            // ... kurangi kuota, buat booking ...
            DB::commit();
            return redirect()->route('user.booking.history')->with('success', 'Pemesanan berhasil.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Pemesanan gagal.');
        }
    }

    /** Menampilkan riwayat pemesanan tiket[cite: 616]. */
    public function showBookingHistory() {
        $bookings = Auth::user()->bookings()->with('ticket.event')->latest()->paginate(10);
        return view('user.bookings.history', compact('bookings'));
    }

    /** Membatalkan pesanan (pengembalian kuota)[cite: 622]. */
    public function cancelBooking(Booking $booking) {
        // Logika validasi dan pengembalian kuota tiket
        // ...
        return back()->with('success', 'Pemesanan dibatalkan.');
    }
}