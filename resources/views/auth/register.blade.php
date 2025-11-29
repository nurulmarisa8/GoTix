@extends('layouts.main')

@section('content')
<div class="flex items-center justify-center min-h-[80vh] py-10">
    <div class="w-full max-w-md bg-slate-800 rounded-2xl shadow-2xl p-8 border border-slate-700 relative overflow-hidden">
        
        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-pink-600 to-purple-600"></div>

        <h2 class="text-3xl font-bold text-center text-white mb-2">Buat Akun Baru 🚀</h2>
        <p class="text-slate-400 text-center mb-8 text-sm">Bergabunglah dengan GoTix sekarang.</p>

        <form method="POST" action="{{ route('register') }}">
            @csrf
            
            <div class="mb-4">
                <label class="block mb-2 text-sm font-medium text-slate-300">Nama Lengkap</label>
                <input type="text" name="name" class="bg-slate-900 border border-slate-600 text-white text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5" placeholder="John Doe" required>
                @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block mb-2 text-sm font-medium text-slate-300">Email</label>
                <input type="email" name="email" class="bg-slate-900 border border-slate-600 text-white text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5" placeholder="name@example.com" required>
                @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block mb-2 text-sm font-medium text-slate-300">Daftar Sebagai</label>
                <select name="role" class="bg-slate-900 border border-slate-600 text-white text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 cursor-pointer">
                    <option value="user">Pengunjung (Beli Tiket)</option>
                    <option value="organizer">Event Organizer (Buat Acara)</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block mb-2 text-sm font-medium text-slate-300">Password</label>
                <input type="password" name="password" class="bg-slate-900 border border-slate-600 text-white text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5" required>
                @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="mb-6">
                <label class="block mb-2 text-sm font-medium text-slate-300">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="bg-slate-900 border border-slate-600 text-white text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5" required>
            </div>

            <button type="submit" class="w-full text-white bg-gradient-to-r from-purple-600 to-pink-600 hover:bg-gradient-to-l focus:ring-4 focus:outline-none focus:ring-purple-800 font-bold rounded-lg text-sm px-5 py-3 text-center transition transform hover:scale-105">
                Daftar
            </button>
            
            <div class="text-center text-sm text-slate-400 mt-6">
                Sudah punya akun? <a href="{{ route('login') }}" class="text-purple-400 hover:text-pink-400 font-bold hover:underline transition">Login disini</a>
            </div>
        </form>
    </div>
</div>
@endsection