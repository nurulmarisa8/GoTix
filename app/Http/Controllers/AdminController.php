<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Booking; 
use App\Models\Event;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // --- 1. DASHBOARD ADMIN ---
    public function dashboard()
        {
            // 1. Statistik Utama
            $totalUsers = User::count();
            $totalEvents = Event::count();
            $totalRevenue = Booking::where('status', 'approved')->sum('total_price');

            // 2. Data Organizer Pending (Yang butuh persetujuan segera) - NEW
            $pendingOrganizers = User::where('role', 'organizer')
                                    ->where('organizer_status', 'pending')
                                    ->latest()
                                    ->take(5) // Ambil 5 teratas
                                    ->get();

            // 3. Transaksi Terbaru (Global) - NEW
            $recentBookings = Booking::with(['user', 'event'])
                                    ->where('status', 'approved')
                                    ->latest()
                                    ->take(5)
                                    ->get();

            return view('admin.dashboard', compact('totalUsers', 'totalEvents', 'totalRevenue', 'pendingOrganizers', 'recentBookings'));
        }

    // --- 2. MANAGE USERS ---
    public function manageUsers()
    {
        // Ambil semua user, urutkan agar yang 'pending' ada di atas
        $users = User::orderBy('organizer_status', 'desc')->get(); 
        return view('admin.users.index', compact('users'));
    }

    // --- 3. APPROVE / REJECT ORGANIZER ---
    public function approveOrganizer(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:approved,rejected'
        ]);

        $user->update([
            'organizer_status' => $request->status
        ]);

        $msg = $request->status == 'approved' ? 'Organizer diterima!' : 'Organizer ditolak!';

        return redirect()->back()->with('success', $msg);
    }

    // --- 4. REPORTS (LAPORAN PENJUALAN) ---
    // Ini bagian yang tadi hilang/error
    public function reports()
    {
        // Ambil data transaksi yang statusnya 'approved'
        $reports = Booking::with(['user', 'event'])
                          ->where('status', 'approved') 
                          ->latest()
                          ->get();
                          
        $totalRevenue = $reports->sum('total_price');

        return view('admin.reports.index', compact('reports', 'totalRevenue'));
    }
}