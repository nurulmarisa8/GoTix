@extends('layouts.dashboard')

@section('content')

<div class="mb-8 flex justify-between items-center">
    <div>
        <h2 class="text-3xl font-bold text-white">Dashboard Organizer</h2>
        <p class="text-slate-400">Monitor performa penjualan & konfirmasi pesanan.</p>
    </div>
    <div class="text-right">
        <a href="{{ route('organizer.events.create') }}" class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white px-5 py-2.5 rounded-lg font-bold shadow-lg shadow-purple-500/30 transition transform hover:scale-105">
            + Buat Konser Baru
        </a>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-slate-800 p-6 rounded-2xl border border-slate-700 shadow-lg">
        <h3 class="text-slate-400 text-sm font-medium uppercase tracking-wider">Event Aktif</h3>
        <p class="text-3xl font-bold text-white mt-2">{{ $myEvents }}</p>
    </div>
    <div class="bg-slate-800 p-6 rounded-2xl border border-slate-700 shadow-lg">
        <h3 class="text-slate-400 text-sm font-medium uppercase tracking-wider">Tiket Terjual</h3>
        <p class="text-3xl font-bold text-white mt-2">{{ $ticketsSold }}</p>
    </div>
    <div class="bg-slate-800 p-6 rounded-2xl border border-slate-700 shadow-lg">
        <h3 class="text-slate-400 text-sm font-medium uppercase tracking-wider">Total Pendapatan</h3>
        <p class="text-3xl font-bold text-green-400 mt-2">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
    </div>
</div>

<div class="bg-slate-800 rounded-xl border border-slate-700 overflow-hidden">
    <div class="p-6 border-b border-slate-700 flex justify-between items-center">
        <h3 class="text-xl font-bold text-white">Transaksi Tiket Terbaru</h3>
        <a href="{{ route('organizer.events.index') }}" class="text-sm text-purple-400 hover:text-white transition">Lihat Semua &rarr;</a>
    </div>

    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left text-slate-300">
            <thead class="text-xs text-slate-400 uppercase bg-slate-700/50">
                <tr>
                    <th class="px-6 py-3">Pembeli</th>
                    <th class="px-6 py-3">Event</th>
                    <th class="px-6 py-3">Tiket</th>
                    <th class="px-6 py-3">Total</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
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
                        <span class="bg-purple-900 text-purple-300 text-xs font-bold px-2 py-1 rounded">{{ $booking->ticket->name }}</span>
                        <span class="text-xs ml-1">x{{ $booking->quantity }}</span>
                    </td>
                    <td class="px-6 py-4 text-white font-bold">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                    
                    <td class="px-6 py-4 text-right">
                        @if($booking->status == 'pending')
                            <div class="flex items-center justify-end gap-2">
                                {{-- Tombol TERIMA --}}
                                <form action="{{ route('organizer.bookings.approve', $booking->id) }}" method="POST">
                                    @csrf
                                    <button class="bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded text-xs font-bold shadow-lg transition" title="Terima">✓</button>
                                </form>
                                {{-- Tombol TOLAK --}}
                                <form action="{{ route('organizer.bookings.reject', $booking->id) }}" method="POST" onsubmit="return confirm('Tolak pesanan?');">
                                    @csrf
                                    <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded text-xs font-bold shadow-lg transition" title="Tolak">✕</button>
                                </form>
                            </div>
                        @elseif($booking->status == 'approved')
                            <span class="text-green-400 text-xs font-bold px-2 py-1 rounded bg-green-500/10">Lunas</span>
                        @else
                            <span class="text-red-400 text-xs font-bold px-2 py-1 rounded bg-red-500/10">Dibatalkan</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-6 py-8 text-center text-slate-500">Belum ada transaksi tiket.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection