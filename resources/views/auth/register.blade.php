@extends('layouts.main')

@section('content')
<div class="flex items-center justify-center min-h-[80vh] py-10">
    <div class="w-full max-w-md bg-slate-800 rounded-2xl shadow-2xl p-8 border border-slate-700">
        <h2 class="text-3xl font-bold text-center text-white mb-6">Daftar Akun</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf
            
            <div class="mb-4">
                <label class="block mb-2 text-sm font-medium text-slate-300">Nama Lengkap</label>
                <input type="text" name="name" class="bg-slate-900 border border-slate-600 text-white text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5" required>
            </div>

            <div class="mb-4">
                <label class="block mb-2 text-sm font-medium text-slate-300">Email</label>
                <input type="email" name="email" class="bg-slate-900 border border-slate-600 text-white text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5" required>
            </div>

            <div class="mb-4">
                <label class="block mb-2 text-sm font-medium text-slate-300">Daftar Sebagai</label>
                <select name="role" class="bg-slate-900 border border-slate-600 text-white text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5">
                    <option value="user">Pengunjung (Beli Tiket)</option>
                    <option value="organizer">Event Organizer (Buat Acara)</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block mb-2 text-sm font-medium text-slate-300">Password</label>
                <input type="password" name="password" class="bg-slate-900 border border-slate-600 text-white text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5" required>
            </div>

            <div class="mb-6">
                <label class="block mb-2 text-sm font-medium text-slate-300">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="bg-slate-900 border border-slate-600 text-white text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5" required>
            </div>

            <button type="submit" class="w-full text-white bg-purple-600 hover:bg-purple-700 focus:ring-4 focus:outline-none focus:ring-purple-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mb-4">
                Daftar
            </button>
            
            <div class="text-center text-sm text-slate-400">
                Sudah punya akun? <a href="{{ route('login') }}" class="text-purple-400 hover:underline">Login disini</a>
            </div>
        </form>
    </div>
</div>
@endsection
