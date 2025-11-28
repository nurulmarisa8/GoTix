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

        // If the email address changes, reset email verification
        if ($validated['email'] !== $user->email) {
            $user->email = $validated['email'];
            $user->email_verified_at = null;
        } else {
            $user->email = $validated['email'];
        }
        
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }
        
        $user->save();

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully');
    }

    public function destroy(Request $request) {
        $user = auth()->user();

        // Validate password
        $request->validate([
            'password' => 'required',
        ]);

        // Use the 'userDeletion' error bag to match tests
        if (!\Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'The provided password does not match our records.'], 'userDeletion');
        }

        // Logout and delete the user
        \Illuminate\Support\Facades\Auth::logout();
        $user->delete();

        return redirect()->route('home');
    }
}