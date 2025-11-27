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
        
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->role === 'organizer' && $user->organizer_status !== 'approved') {
                Auth::logout();
                return redirect()->route('pending');
            }
            return redirect()->intended(route('dashboard'));
        }
        
        return back()->withErrors(['email' => 'Invalid credentials']);
    }
    
    public function showRegister() {
        return view('auth.register');
    }
    
    public function register(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed'
        ]);
        
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'user'
        ]);
        
        Auth::login($user);
        return redirect()->route('home');
    }
    
    public function logout() {
        Auth::logout();
        return redirect()->route('home');
    }
}
