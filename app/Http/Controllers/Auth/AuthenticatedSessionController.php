<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
        {
            $request->authenticate();

            $request->session()->regenerate();

            // --- LOGIKA CUSTOM GOTIX ---
            $user = Auth::user();

            // 1. Cek Organizer
            if ($user->role === 'organizer') {
                if ($user->organizer_status === 'rejected') {
                    Auth::guard('web')->logout(); // Logout paksa jika ditolak
                    return redirect()->route('organizer.rejected');
                }
                if ($user->organizer_status === 'pending') {
                    // Jangan logout, tapi arahkan ke pending page
                    return redirect()->route('organizer.pending');
                }
                return redirect()->intended(route('organizer.dashboard'));
            }
            
            // 2. Cek Admin
            if ($user->role === 'admin') {
                return redirect()->intended(route('admin.dashboard'));
            } 
            
            // 3. User Biasa
            return redirect()->intended(route('home'));
        }
    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
