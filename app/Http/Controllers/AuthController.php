<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller {
    public function showLogin() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // First, check if the credentials are valid
        if (Auth::validate($credentials)) {
            $user = User::where('email', $credentials['email'])->first();

            // Log the user in first
            Auth::login($user);

            // Then, check the user's role and status
            if ($user->role === 'organizer') {
                if ($user->organizer_status !== 'approved') {
                    // If organizer is pending, redirect to pending page
                    return redirect()->route('pending');
                }
            }

            // If checks pass, redirect to intended route
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors(['email' => 'Email atau password salah.']);
    }

    public function showRegister() {
        return view('auth.register');
    }

    public function register(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:user,organizer'
        ]);

        $role = $validated['role'];

        // Logging untuk debugging
        \Log::info('Register attempt:', [
            'email' => $validated['email'],
            'role' => $role,
            'input_role' => $request->input('role')
        ]);

        // Set organizer status to 'pending' if registering as organizer, otherwise null
        $organizerStatus = ($role === 'organizer') ? 'pending' : null;

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $role,
            'organizer_status' => $organizerStatus
        ]);

        // Logging untuk hasil pembuatan user
        \Log::info('User created:', [
            'id' => $user->id,
            'email' => $user->email,
            'role' => $user->role,
            'organizer_status' => $user->organizer_status
        ]);

        // Redirect organizer to pending page if they registered as organizer
        if ($role === 'organizer') {
            // Log the user in first so they can access the pending page
            Auth::login($user);
            // Then redirect to pending page
            return redirect()->route('pending');
        }

        // For 'user' role, log them in and redirect to dashboard
        Auth::login($user);
        return redirect()->route('dashboard');
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('home');
    }
}
