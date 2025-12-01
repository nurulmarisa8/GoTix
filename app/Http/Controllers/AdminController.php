<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Booking; 
use App\Models\Event;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // 1. Statistik
        $totalUsers = User::count();
        $totalEvents = Event::count();
        $totalRevenue = Booking::where('status', 'approved')->sum('total_price');

        $incomingOrders = Booking::with(['user', 'event', 'ticket'])
                                 ->where('status', 'pending')
                                 ->latest()
                                 ->take(10)
                                 ->get();

        return view('admin.dashboard', compact('totalUsers', 'totalEvents', 'totalRevenue', 'incomingOrders'));
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

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }
    

    // UPDATE USER (SIMPAN PERUBAHAN) ---
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:admin,organizer,user',
        ]);

        // Logika khusus: Jika diubah jadi Organizer, otomatis Approved
        $organizerStatus = $user->organizer_status;
        if ($request->role === 'organizer' && $user->role !== 'organizer') {
            $organizerStatus = 'approved'; 
        } elseif ($request->role !== 'organizer') {
            $organizerStatus = null;
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'organizer_status' => $organizerStatus,
        ]);

        return redirect()->route('admin.users')->with('success', 'Data pengguna berhasil diperbarui!');
    }

    // --- 7. HAPUS USER ---
    public function destroyUser($id)
    {
        // Cegah Admin menghapus dirinya sendiri
        if (auth()->id() == $id) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun sendiri!');
        }

        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'Pengguna berhasil dihapus!');
    }

    // --- 8. KELOLA TRANSAKSI (SEMUA) ---
    public function manageBookings()
    {
        // Ambil semua booking, urutkan: Pending paling atas
        $bookings = Booking::with(['user', 'event', 'ticket'])
                           ->orderByRaw("FIELD(status, 'pending', 'approved', 'canceled')")
                           ->latest()
                           ->get();

        return view('admin.bookings.index', compact('bookings'));
    }

    // --- 9. ADMIN APPROVE ---
    public function approveBooking($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update(['status' => 'approved']);

        return redirect()->back()->with('success', 'Transaksi berhasil disetujui (ACC).');
    }

    // --- 10. ADMIN REJECT ---
    public function rejectBooking($id)
    {
        $booking = Booking::findOrFail($id);

        if ($booking->status !== 'canceled') {
            $booking->update(['status' => 'canceled']);
            // Kembalikan kuota tiket
            $booking->ticket->increment('quota', $booking->quantity);
            
            return redirect()->back()->with('success', 'Transaksi ditolak dan kuota dikembalikan.');
        }

        return redirect()->back()->with('error', 'Transaksi sudah dibatalkan sebelumnya.');
    }
}