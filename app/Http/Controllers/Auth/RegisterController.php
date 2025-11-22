<?php
// app/Http/Controllers/Auth/RegisterController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller
{
    /** Tampilkan halaman register (Hanya untuk User dan Event Organizer). */
    public function showRegistrationForm() {
        return view('auth.register');
    }

    /** Proses pendaftaran. */
    public function register(Request $request) {
        // ... Validasi data ...
        
        // Atur status approval untuk Organizer menjadi 'pending'
        $statusApproval = ($request->role === 'organizer') ? 'pending' : 'approved';

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role, // Registered User atau Event Organizer
            'status_approval' => $statusApproval,
        ]);
        
        // ... Logika Redirect ...

        return redirect()->route('login')->with('success', 'Pendaftaran berhasil. Silakan login.');
    }
}