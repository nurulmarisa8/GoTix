<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use App\Models\Booking;

class OrganizerController extends Controller
{
    // Dashboard: Hanya bisa diakses jika status = approved
public function dashboard()
    {
        $organizerId = Auth::id();
        
        $myEvents = Event::where('organizer_id', $organizerId)->count();
        
        // Tetap hitung yang approved untuk statistik terjual
        $ticketsSold = Booking::whereHas('event', function($q) use ($organizerId) {
            $q->where('organizer_id', $organizerId);
        })->where('status', 'approved')->count();

        $totalRevenue = Booking::whereHas('event', function($q) use ($organizerId) {
            $q->where('organizer_id', $organizerId);
        })->where('status', 'approved')->sum('total_price');

        // PERBAIKAN: Ambil semua transaksi (Pending & Approved) agar bisa di-ACC
        $recentBookings = Booking::whereHas('event', function($q) use ($organizerId) {
            $q->where('organizer_id', $organizerId);
        })
        ->with(['user', 'ticket', 'event'])
        ->latest()
        ->take(10) // Tampilkan 10 terakhir
        ->get();

        return view('organizer.dashboard', compact('myEvents', 'ticketsSold', 'totalRevenue', 'recentBookings'));
    }

    // --- TAMBAHKAN METHOD BARU INI ---
    public function approveBooking($id)
    {
        $booking = Booking::findOrFail($id);

        // Security: Pastikan booking ini milik event si organizer
        if($booking->event->organizer_id !== Auth::id()){
            abort(403, 'Bukan event anda');
        }

        $booking->update(['status' => 'approved']);

        return redirect()->back()->with('success', 'Pesanan berhasil disetujui!');
    }

    // Halaman jika akun masih ditinjau
    public function pendingPage()
    {
        return view('organizer.pending');
    }

    // Halaman jika akun ditolak
    public function rejectedPage()
    {
        return view('organizer.rejected');
    }
}