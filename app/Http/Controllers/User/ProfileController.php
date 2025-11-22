<?php
// app/Http/Controllers/User/ProfileController.php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /** Tampilkan halaman Profile Management[cite: 639]. */
    public function edit() {
        return view('user.profile.edit', ['user' => Auth::user()]);
    }

    /** Perbarui informasi akun. */
    public function update(Request $request) {
        // Logika validasi dan pembaruan nama, email, password, dll.
        Auth::user()->update($request->all());
        
        return redirect()->route('user.profile.edit')->with('success', 'Informasi akun berhasil diperbarui.');
    }
}