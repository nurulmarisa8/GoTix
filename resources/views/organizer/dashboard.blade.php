@extends('layouts.dashboard')

@section('content')

<div class="mb-8 flex justify-between items-center">
    <div>
        <h2 class="text-3xl font-bold text-white">Dashboard Organizer</h2>
        <p class="text-slate-400">Monitor performa penjualan & konfirmasi pesanan tiket.</p>
    </div>
    <div class="text-right">
        <a href="{{ route('organizer.events.create') }}" class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white px-5 py-2.5 rounded-lg font-bold shadow-lg shadow-purple-500/30 transition transform hover:scale-105">
            + Buat Konser Baru
        </a>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    
    <div class="bg-slate-800 p-6 rounded-2xl border border-slate-700 shadow-lg relative overflow-hidden">
        <div class="absolute right-0 top-0 p-4 opacity-10">
            <svg class="w-20 h-20 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
        </div>
        <h3 class="text-slate-400 text-sm font-medium uppercase tracking-wider">Event Aktif</h3>
        <p class="text-3xl font-bold text-white mt-2">{{ $myEvents }}</p>
    </div>

    <div class="bg-slate-800 p-6 rounded-2xl border border-slate-700 shadow-lg relative overflow-hidden">
        <div class="absolute right-0 top-0 p-4 opacity-10">
            <svg class="w-20 h-20 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
        </div>
        <h3 class="text-slate-400 text-sm font-medium uppercase tracking-wider">Tiket Terjual</h3>
        <p class="text-3xl font-bold text-white mt-2">{{ $ticketsSold }}</p>
    </div>

    <div class="bg-slate-800 p-6 rounded-2xl border border-slate-700 shadow-lg relative overflow-hidden">
        <div class="absolute right-0 top-0 p-4 opacity-10">
            <svg class="w-20 h-20 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <h3 class="text-slate-400 text-sm font-medium uppercase tracking-wider">Total Pendapatan</h3>
        <p class="text-3xl font-bold text-green-400 mt-2">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
    </div>
</div>

<div class="bg-slate-800 rounded-xl border border-slate-700 overflow-hidden">
    <div class="p-6 border-b border-slate-700 flex justify-between items-center">
        <h3 class="text-xl font-bold text-white">Transaksi Tiket Terbaru</h3>
        <a href="{{ route('organizer.events.index') }}" class="text-sm text-purple-400 hover:text-white transition">Lihat Semua Event &rarr;</a>
    </div>

    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left text-slate-300">
            <thead class="text-xs text-slate-400 uppercase bg-slate-700/50">
                <tr>
                    <th class="px-6 py-3">Pembeli</th>
                    <th class="px-6 py-3">Event</th>
                    <th class="px-6 py-3">Tiket</th>
                    <th class="px-6 py-3">Total</th>
                    <th class="px-6 py-3 text-right">Status / Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentBookings as $booking)
                <tr class="border-b border-slate-700 hover:bg-slate-700/50 transition">
                    <td class="px-6 py-4 font-medium text-white">
                        {{ $booking->user->name }}
                        <span class="block text-xs text-slate-500">{{ $booking->user->email }}</span>
                    </td>
                    <td class="px-6 py-4">{{ $booking->event->name }}</td>
                    <td class="px-6 py-4">
                        <span class="bg-purple-900 text-purple-300 text-xs font-bold px-2 py-1 rounded">
                            {{ $booking->ticket->name }}
                        </span>
                        <span class="text-xs ml-1">x{{ $booking->quantity }}</span>
                    </td>
                    <td class="px-6 py-4 text-white font-bold">
                        Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                    </td>
                    
                    {{-- KOLOM STATUS & AKSI --}}
                    <td class="px-6 py-4 text-right">
                        @if($booking->status == 'pending')
                            <div class="flex items-center justify-end gap-2">
                                <span class="text-yellow-500 text-xs font-bold mr-2 animate-pulse">Menunggu</span>
                                <form action="{{ route('organizer.bookings.approve', $booking->id) }}" method="POST">
                                    @csrf
                                    <button class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-xs font-bold shadow-lg shadow-green-500/30 transition transform hover:scale-105">
                                        ✓ Terima
                                    </button>
                                </form>
                            </div>
                        @else
                            <span class="text-green-400 text-xs font-bold border border-green-500/30 px-2 py-1 rounded bg-green-500/10">
                                Lunas / Approved
                            </span>
                        @endif
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-slate-500">
                        Belum ada transaksi tiket.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection