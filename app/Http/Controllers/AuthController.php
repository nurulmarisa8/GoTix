<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // --- Tampilkan Form Login ---
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // --- Proses Login (Dengan Logika Cek Status Organizer) ---
    public function login(Request $request)
    {
        // 1. Validasi Input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Coba Login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // --- LOGIKA KHUSUS ORGANIZER ---
            if ($user->role === 'organizer') {
                // Jika status Rejected
                if ($user->organizer_status === 'rejected') {
                    return redirect()->route('organizer.rejected');
                }
                // Jika status Pending -> Lempar ke halaman Peringatan
                if ($user->organizer_status === 'pending') {
                    return redirect()->route('organizer.pending');
                }
                // Jika Approved -> Masuk Dashboard
                return redirect()->intended(route('organizer.dashboard'));
            }
            
            // --- LOGIKA ADMIN ---
            if ($user->role === 'admin') {
                return redirect()->intended(route('admin.dashboard'));
            } 
            
            // --- LOGIKA USER BIASA ---
            return redirect()->intended(route('home'));
        }

        // 3. Jika Gagal Login
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // --- Tampilkan Form Register ---
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // --- Proses Register (Set Status Pending & Auto Login) ---
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:organizer,user', 
        ]);

        // Set default status
        $organizerStatus = null;
        
        // KUNCI: Jika dia milih organizer, PAKSA jadi pending
        if ($request->role === 'organizer') {
            $organizerStatus = 'pending';
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'organizer_status' => $organizerStatus, // Pastikan variabel ini masuk
        ]);

        Auth::login($user);

        // Redirect paksa ke pending page jika role organizer
        if ($user->role === 'organizer') {
            return redirect()->route('organizer.pending');
        }

        return redirect()->route('home')->with('success', 'Registrasi berhasil!');
    }

    // --- Logout ---
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}