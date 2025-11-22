<?php
// app/Http/Controllers/Admin/UserController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /** Menampilkan daftar semua pengguna (kecuali Admin). */
    public function index() {
        $users = User::where('role', '!=', 'admin')->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    /** Tampilkan daftar Organizer berstatus "Pending". */
    public function showPendingOrganizers() {
        $pendingOrganizers = User::where('role', 'organizer')
                                  ->where('status_approval', 'pending')
                                  ->paginate(10);
        return view('admin.users.verification', compact('pendingOrganizers'));
    }

    /** Menyetujui atau menolak Organizer. */
    public function approveRejectOrganizer(Request $request, User $organizer) {
        $request->validate(['status' => 'required|in:approved,rejected']);
        
        $organizer->update(['status_approval' => $request->status]);
        
        // Logika untuk tombol Delete Account jika Rejected [cite: 647]
        if ($request->status == 'rejected' && $request->action == 'delete') {
             $organizer->delete(); 
             return back()->with('success', 'Organizer ditolak dan akun dihapus.');
        }

        return back()->with('success', 'Status Organizer berhasil diperbarui.');
    }

    // ... metode untuk edit/delete user lainnya ...
}