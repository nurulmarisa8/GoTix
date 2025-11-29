@extends('layouts.main')

@section('content')
<div class="flex items-center justify-center min-h-[80vh]">
    <div class="w-full max-w-md bg-slate-800 rounded-2xl shadow-2xl p-8 border border-slate-700 relative overflow-hidden">
        
        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-purple-600 to-pink-600"></div>

        <h2 class="text-3xl font-bold text-center text-white mb-2">Welcome Back! 👋</h2>
        <p class="text-slate-400 text-center mb-8 text-sm">Login untuk mengakses tiketmu.</p>

        @if(session('success'))
            <div class="bg-green-600/20 border border-green-500 text-green-400 p-3 rounded mb-4 text-sm text-center">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <div class="mb-5">
                <label for="email" class="block mb-2 text-sm font-medium text-slate-300">Email Address</label>
                <input type="email" name="email" id="email" class="bg-slate-900 border border-slate-600 text-white text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 placeholder-gray-500" placeholder="name@company.com" required autofocus>
                @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="mb-6">
                <label for="password" class="block mb-2 text-sm font-medium text-slate-300">Password</label>
                <input type="password" name="password" id="password" class="bg-slate-900 border border-slate-600 text-white text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5" required>
            </div>

            <button type="submit" class="w-full text-white bg-gradient-to-r from-purple-600 to-pink-600 hover:bg-gradient-to-l focus:ring-4 focus:outline-none focus:ring-purple-800 font-bold rounded-lg text-sm px-5 py-3 text-center transition transform hover:scale-105">
                Masuk Sekarang
            </button>
            
            <div class="text-center text-sm text-slate-400 mt-6">
                Belum punya akun? <a href="{{ route('register') }}" class="text-purple-400 hover:text-pink-400 font-bold hover:underline transition">Daftar disini</a>
            </div>
        </form>
    </div>
</div>
@endsection