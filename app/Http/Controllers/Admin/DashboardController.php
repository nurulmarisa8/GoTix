<?php
// app/Http/Controllers/Admin/DashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Booking;

class DashboardController extends Controller
{
    /**
     * Tampilkan Admin Dashboard.
     * Menampilkan statistik seperti total pengguna, total pengajuan pending, dll.
     */
    public function index()
    {
        $totalUsers = User::count();
        $pendingOrganizers = User::where('role', 'organizer')
                                 ->where('status_approval', 'pending')
                                 ->count();
        $totalEvents = \App\Models\Event::count();

        return view('admin.dashboard', compact('totalUsers', 'pendingOrganizers', 'totalEvents'));
    }
}