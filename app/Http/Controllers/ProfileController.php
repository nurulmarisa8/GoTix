<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller {
    public function __construct() {
        $this->middleware('auth');
    }

    public function show() {
        $user = auth()->user();
        return view('profile.show', compact('user'));
    }

    public function edit() {
        $user = auth()->user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request) {
        $user = auth()->user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed'
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }
        
        $user->save();

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully');
    }
}