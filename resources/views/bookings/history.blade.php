@extends('layouts.dashboard')

@section('content')

<div class="mb-6 flex justify-between items-end">
    <div>
        <h2 class="text-2xl font-bold text-white">Tiket Saya</h2>
        <p class="text-slate-400">Daftar konser yang akan kamu datangi.</p>
    </div>
    <a href="{{ route('home') }}" class="text-sm text-purple-400 hover:text-purple-300">
        + Cari Event Lain
    </a>
</div>

<div class="grid grid-cols-1 gap-6">
    @forelse($bookings as $booking)
    <div class="bg-slate-800 rounded-2xl overflow-hidden border border-slate-700 flex flex-col md:flex-row hover:border-purple-500 transition group shadow-lg">
        
        <div class="md:w-48 h-48 md:h-auto relative flex-shrink-0">
            <img src="{{ $booking->event->image ? asset('storage/'.$booking->event->image) : 'https://placehold.co/200' }}" class="w-full h-full object-cover opacity-80 group-hover:opacity-100 transition">
            
            <div class="absolute top-2 left-2">
                @if($booking->status == 'approved')
                    <span class="bg-green-500 text-white text-xs font-bold px-2 py-1 rounded shadow-lg">LUNAS</span>
                @elseif($booking->status == 'pending')
                    <span class="bg-yellow-500 text-white text-xs font-bold px-2 py-1 rounded shadow-lg animate-pulse">MENUNGGU</span>
                @else
                    <span class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded shadow-lg">BATAL</span>
                @endif
            </div>
        </div>

        <div class="p-6 flex-1 flex flex-col justify-center border-b md:border-b-0 md:border-r border-slate-700 border-dashed">
            <div class="mb-2">
                <span class="text-purple-400 text-xs font-bold uppercase bg-purple-900/30 px-2 py-1 rounded">{{ $booking->event->category }}</span>
            </div>
            <h3 class="text-xl font-bold text-white mb-2">{{ $booking->event->name }}</h3>
            
            <div class="flex flex-col gap-1 text-sm text-slate-300">
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    {{ \Carbon\Carbon::parse($booking->event->event_date)->format('d F Y') }}
                </div>
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    {{ $booking->event->location }}
                </div>
            </div>
        </div>

        <div class="p-6 md:w-72 flex flex-col justify-center bg-slate-900/50 flex-shrink-0">
            <div class="text-center w-full">
                <p class="text-slate-400 text-xs uppercase mb-1">Tiket: {{ $booking->ticket->name }} (x{{ $booking->quantity }})</p>
                <p class="text-purple-400 font-bold text-xl mb-4">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>

                @if($booking->status == 'approved')
                    <button class="w-full bg-slate-700 hover:bg-slate-600 text-white text-xs font-bold py-3 rounded-lg border border-slate-600 flex items-center justify-center gap-2">
                        🖨️ Download Tiket
                    </button>
                @elseif($booking->status == 'pending')
                    <div class="text-center">
                        <span class="block bg-yellow-500/10 text-yellow-500 text-xs font-bold py-2 rounded border border-yellow-500/20 mb-2">
                            ⏳ Menunggu Konfirmasi
                        </span>
                        
                        <form action="{{ route('booking.cancel', $booking->id) }}" method="POST" onsubmit="return confirm('Yakin batalkan pesanan?');">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="w-full bg-red-600/10 hover:bg-red-600 text-red-500 hover:text-white text-xs font-bold py-2 rounded border border-red-500/50 transition">
                                ✕ Batalkan Pesanan
                            </button>
                        </form>
                    </div>
                @else
                    <span class="text-red-500 font-bold text-sm bg-red-900/20 px-3 py-1 rounded">Dibatalkan</span>
                @endif
            </div>
        </div>

    </div>
    @empty
    <div class="text-center py-20 bg-slate-800 rounded-2xl border border-slate-700">
        <div class="text-6xl mb-4">🎫</div>
        <h3 class="text-xl font-bold text-white">Belum ada tiket</h3>
        <p class="text-slate-400 mb-6">Kamu belum memesan tiket apapun.</p>
        <a href="{{ route('home') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-full font-bold">Cari Konser</a>
    </div>
    @endforelse
</div>
@endsection