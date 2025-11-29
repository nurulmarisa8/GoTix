@extends('layouts.main') {{-- Pakai layout main biar gak bisa akses sidebar dashboard --}}

@section('content')
<div class="flex items-center justify-center min-h-[60vh]">
    <div class="bg-slate-800 p-8 rounded-2xl shadow-2xl text-center max-w-md border border-slate-700">
        <div class="text-6xl mb-4">⏳</div>
        <h2 class="text-2xl font-bold text-white mb-2">Akun Sedang Ditinjau</h2>
        <p class="text-slate-400">
            Halo, <span class="font-bold text-purple-400">{{ Auth::user()->name }}</span>. 
            Pendaftaran Anda sebagai Organizer sedang diperiksa oleh Admin. Mohon tunggu persetujuan untuk mulai membuat konser.
        </p>
    </div>
</div>
@endsection