<?php

namespace App\Http\Controllers;
use App\Models\Event;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller {
    public function index() {
        return view('dashboard.index');
    }
    
    public function adminDashboard() {
        $totalUsers = User::count();
        $totalEvents = Event::count();
        $totalBookings = Booking::count();
        $totalRevenue = Booking::where('status', 'approved')->sum('total_price');
        
        $recentBookings = Booking::with('user', 'ticket.event')
            ->latest()
            ->take(10)
            ->get();
        
        $pendingOrganizers = User::where('role', 'organizer')
            ->where('organizer_status', 'pending')
            ->count();
        
        $bookingsByStatus = Booking::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();
        
        return view('admin.dashboard', compact(
            'totalUsers', 'totalEvents', 'totalBookings', 'totalRevenue',
            'recentBookings', 'pendingOrganizers', 'bookingsByStatus'
        ));
    }
}
