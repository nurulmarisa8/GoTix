<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use App\Models\Booking;

class OrganizerController extends Controller
{
    // --- DASHBOARD ORGANIZER ---
    public function dashboard()
    {
        $organizerId = Auth::id();
        
        // 1. Statistik Event
        $myEvents = Event::where('organizer_id', $organizerId)->count();
        
        // 2. Statistik Tiket Terjual (Hanya yang Approved)
        $ticketsSold = Booking::whereHas('event', function($q) use ($organizerId) {
            $q->where('organizer_id', $organizerId);
        })->where('status', 'approved')->count();

        // 3. Statistik Pendapatan
        $totalRevenue = Booking::whereHas('event', function($q) use ($organizerId) {
            $q->where('organizer_id', $organizerId);
        })->where('status', 'approved')->sum('total_price');

        // 4. Transaksi Terbaru (Ambil Pending & Approved & Canceled)
        $recentBookings = Booking::whereHas('event', function($q) use ($organizerId) {
            $q->where('organizer_id', $organizerId);
        })
        ->with(['user', 'ticket', 'event'])
        ->latest()
        ->take(10)
        ->get();

        return view('organizer.dashboard', compact('myEvents', 'ticketsSold', 'totalRevenue', 'recentBookings'));
    }

    // --- TERIMA PESANAN (APPROVE) ---
    public function approveBooking($id)
    {
        $booking = Booking::findOrFail($id);

        // Security Check: Pastikan ini booking milik event organizer yang login
        if($booking->event->organizer_id !== Auth::id()){
            abort(403, 'Unauthorized action.');
        }

        $booking->update(['status' => 'approved']);

        return redirect()->back()->with('success', 'Pesanan berhasil disetujui!');
    }

    // --- TOLAK PESANAN (REJECT) - INI YANG TADI ERROR ---
    public function rejectBooking($id)
    {
        $booking = Booking::findOrFail($id);

        // Security Check
        if($booking->event->organizer_id !== Auth::id()){
            abort(403, 'Unauthorized action.');
        }

        // Cek jika belum dibatalkan sebelumnya
        if ($booking->status !== 'canceled') {
            
            // 1. Ubah status jadi Canceled
            $booking->update(['status' => 'canceled']);
            
            // 2. KEMBALIKAN KUOTA TIKET (PENTING)
            $booking->ticket->increment('quota', $booking->quantity);

            return redirect()->back()->with('success', 'Pesanan ditolak dan kuota dikembalikan.');
        }

        return redirect()->back()->with('error', 'Pesanan sudah dibatalkan sebelumnya.');
    }

    // --- HALAMAN STATUS AKUN ---
    public function pendingPage()
    {
        return view('organizer.pending');
    }

    public function rejectedPage()
    {
        return view('organizer.rejected');
    }
}