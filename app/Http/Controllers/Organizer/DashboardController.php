<?php
// app/Http/Controllers/Organizer/DashboardController.php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /** Tampilkan Organizer Dashboard. */
    public function index() {
        $myEvents = Auth::user()->events;
        $totalBookings = 0;
        
        // Hitung total booking dari semua event miliknya
        foreach ($myEvents as $event) {
            $totalBookings += $event->bookings()->count();
        }
        
        return view('organizer.dashboard', compact('myEvents', 'totalBookings'));
    }
    
    /** Halaman yang dilihat jika akun Organizer masih Pending[cite: 646]. */
    public function pending() {
        return view('organizer.pending');
    }
}