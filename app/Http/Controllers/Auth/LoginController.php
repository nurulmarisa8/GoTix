<?php
// app/Http/Controllers/Auth/LoginController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /** Tampilkan halaman login. */
    public function showLoginForm() {
        return view('auth.login');
    }

    /** Proses otentikasi. */
    public function login(Request $request) {
        // ... Logika Autentikasi ...

        // Cek Status Organizer Pending [cite: 646]
        if (Auth::user()->role === 'organizer' && Auth::user()->status_approval === 'pending') {
             Auth::logout(); // Logout jika belum di-approve
             return redirect()->route('organizer.pending');
        }

        // Redirect sesuai peran (Admin, Organizer, Registered User)
        return redirect()->intended(route('dashboard'));
    }
}