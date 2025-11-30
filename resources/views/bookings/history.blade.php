@extends('layouts.dashboard')

@section('content')

<div class="mb-6 flex justify-between items-end">
    <div>
        <h2 class="text-2xl font-bold text-white">Tiket Saya</h2>
        <p class="text-slate-400">Daftar konser yang akan kamu datangi.</p>
    </div>
    <a href="{{ route('home') }}" class="text-sm text-purple-400 hover:text-purple-300 font-medium transition">
        + Cari Event Lain
    </a>
</div>

<div class="grid grid-cols-1 gap-6">
    @forelse($bookings as $booking)
    <div class="bg-slate-800 rounded-2xl overflow-hidden border border-slate-700 flex flex-col md:flex-row hover:border-purple-500 transition group shadow-lg">
        
        <div class="md:w-48 h-48 md:h-auto relative flex-shrink-0">
            <img src="{{ $booking->event->image ? asset('storage/'.$booking->event->image) : 'https://placehold.co/200' }}" 
                 class="w-full h-full object-cover opacity-80 group-hover:opacity-100 transition" 
                 alt="Poster">
            
            <div class="absolute top-2 left-2">
                @if($booking->status == 'approved')
                    <span class="bg-green-500 text-white text-xs font-bold px-2 py-1 rounded shadow-lg flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        LUNAS
                    </span>
                @elseif($booking->status == 'pending')
                    <span class="bg-yellow-500 text-white text-xs font-bold px-2 py-1 rounded shadow-lg animate-pulse flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        MENUNGGU
                    </span>
                @else
                    <span class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded shadow-lg">BATAL</span>
                @endif
            </div>
        </div>

        <div class="p-6 flex-1 flex flex-col justify-center border-b md:border-b-0 md:border-r border-slate-700 border-dashed relative">
            
            <div class="mb-2">
                <span class="text-purple-400 text-xs font-bold tracking-wider uppercase bg-purple-900/30 px-2 py-1 rounded">{{ $booking->event->category }}</span>
            </div>
            <h3 class="text-xl md:text-2xl font-bold text-white mb-2 line-clamp-1">{{ $booking->event->name }}</h3>
            
            <div class="flex flex-col gap-2 text-sm text-slate-300 mt-2">
                
                {{-- Tanggal & Jam --}}
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-2 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span>
                        {{ \Carbon\Carbon::parse($booking->event->event_date)->format('d F Y') }} 
                        <span class="mx-1 text-slate-500">•</span> 
                        <span class="text-white font-bold">{{ \Carbon\Carbon::parse($booking->event->event_time)->format('H:i') }} WIB</span>
                    </span>
                </div>

                {{-- Lokasi --}}
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-2 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <span class="line-clamp-1">{{ $booking->event->location }}</span>
                </div>
            </div>
        </div>

        <div class="p-6 md:w-72 flex flex-col justify-center bg-slate-900/50 flex-shrink-0">
            <div class="text-center w-full">
                
                <div class="mb-4 pb-4 border-b border-slate-700 border-dashed">
                    <p class="text-slate-400 text-xs uppercase mb-1">Tiket</p>
                    <p class="text-white font-bold text-lg">
                        {{ $booking->ticket->name }} 
                        <span class="text-xs text-slate-500 font-normal ml-1">x{{ $booking->quantity }}</span>
                    </p>
                </div>
                
                <div class="mb-4">
                    <p class="text-slate-400 text-xs uppercase mb-1">Total Bayar</p>
                    <p class="text-purple-400 font-bold text-2xl">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                </div>

                @if($booking->status == 'approved')
                    
                    {{-- 1. TOMBOL DOWNLOAD (Link ke PDF)
                    <a href="{{ route('booking.download', $booking->id) }}" class="w-full inline-flex items-center justify-center bg-slate-700 hover:bg-slate-600 text-white text-xs font-bold py-3 rounded-lg border border-slate-600 transition shadow-lg">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Download E-Ticket
                    </a> --}}

                @elseif($booking->status == 'pending')
                    
                    {{-- 2. TOMBOL BATAL (Cancel) --}}
                    <div class="text-center">
                        <span class="block bg-yellow-500/10 text-yellow-500 text-xs font-bold py-2 rounded border border-yellow-500/20 mb-2">
                            ⏳ Menunggu Konfirmasi
                        </span>
                        
                        <form action="{{ route('booking.cancel', $booking->id) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?');">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="w-full bg-red-600/10 hover:bg-red-600 text-red-500 hover:text-white text-xs font-bold py-2 rounded border border-red-500/50 transition">
                                ✕ Batalkan Pesanan
                            </button>
                        </form>
                    </div>

                @else
                    
                    {{-- 3. STATUS BATAL --}}
                    <span class="text-red-500 font-bold text-sm bg-red-900/20 px-3 py-1 rounded">Dibatalkan</span>
                
                @endif
            </div>
        </div>

    </div>
    @empty
    <div class="text-center py-20 bg-slate-800 rounded-2xl border border-slate-700 flex flex-col items-center">
        <div class="w-20 h-20 bg-slate-700 rounded-full flex items-center justify-center mb-4 text-4xl">
            🎫
        </div>
        <h3 class="text-xl font-bold text-white mb-2">Belum ada tiket</h3>
        <p class="text-slate-400 mb-6 max-w-sm">Kamu belum memesan tiket konser apapun. Yuk cari event seru di sekitarmu!</p>
        <a href="{{ route('home') }}" class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white px-8 py-3 rounded-full font-bold shadow-lg shadow-purple-500/30 transition transform hover:scale-105">
            Cari Konser Sekarang
        </a>
    </div>
    @endforelse
</div>

@endsection