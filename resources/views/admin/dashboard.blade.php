@extends('layouts.dashboard')

@section('content')

<div class="mb-8 flex justify-between items-center">
    <div>
        <h2 class="text-3xl font-bold text-white">Dashboard Admin</h2>
        <p class="text-slate-400">Pusat kontrol & validasi transaksi.</p>
    </div>
    <div class="text-right">
        <span class="bg-purple-900 text-purple-300 text-xs font-medium px-2.5 py-0.5 rounded border border-purple-400">
            {{ \Carbon\Carbon::now()->format('d F Y') }}
        </span>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-slate-800 p-6 rounded-2xl border border-slate-700 shadow-lg">
        <h3 class="text-slate-400 text-sm font-medium uppercase tracking-wider">Total Pengguna</h3>
        <p class="text-4xl font-bold text-white mt-2">{{ $totalUsers }}</p>
    </div>
    <div class="bg-slate-800 p-6 rounded-2xl border border-slate-700 shadow-lg">
        <h3 class="text-slate-400 text-sm font-medium uppercase tracking-wider">Total Acara</h3>
        <p class="text-4xl font-bold text-white mt-2">{{ $totalEvents }}</p>
    </div>
    <div class="bg-slate-800 p-6 rounded-2xl border border-slate-700 shadow-lg">
        <h3 class="text-slate-400 text-sm font-medium uppercase tracking-wider">Total Pendapatan</h3>
        <p class="text-4xl font-bold text-green-400 mt-2">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
    </div>
</div>

<div class="bg-slate-800 rounded-xl border border-slate-700 overflow-hidden mb-8">
    <div class="p-6 border-b border-slate-700 flex justify-between items-center">
        <h3 class="text-xl font-bold text-white flex items-center gap-2">
            <span class="relative flex h-3 w-3">
              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-yellow-400 opacity-75"></span>
              <span class="relative inline-flex rounded-full h-3 w-3 bg-yellow-500"></span>
            </span>
            Pesanan Masuk (Butuh ACC)
        </h3>
    </div>

    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left text-slate-300">
            <thead class="text-xs text-slate-400 uppercase bg-slate-700/50">
                <tr>
                    <th class="px-6 py-3">Pembeli</th>
                    <th class="px-6 py-3">Event (Organizer)</th>
                    <th class="px-6 py-3">Tiket</th>
                    <th class="px-6 py-3">Total</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($incomingOrders as $booking)
                <tr class="border-b border-slate-700 hover:bg-slate-700/50 transition">
                    <td class="px-6 py-4 font-medium text-white">
                        {{ $booking->user->name }}
                        <span class="block text-xs text-slate-500">{{ $booking->user->email }}</span>
                    </td>
                    <td class="px-6 py-4">
                        {{ $booking->event->name }}
                        <span class="block text-xs text-purple-400">by {{ $booking->event->organizer->name }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="bg-purple-900 text-purple-300 text-xs font-bold px-2 py-1 rounded">
                            {{ $booking->ticket->name }}
                        </span>
                        <span class="text-xs ml-1">x{{ $booking->quantity }}</span>
                    </td>
                    <td class="px-6 py-4 text-white font-bold">
                        Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                    </td>
                    
                    {{-- TOMBOL AKSI ADMIN --}}
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            {{-- Approve --}}
                            <form action="{{ route('admin.bookings.approve', $booking->id) }}" method="POST">
                                @csrf
                                <button class="bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded text-xs font-bold shadow-lg transition transform hover:scale-105" title="Terima">
                                    ✓ Terima
                                </button>
                            </form>

                            {{-- Reject --}}
                            <form action="{{ route('admin.bookings.reject', $booking->id) }}" method="POST" onsubmit="return confirm('Tolak transaksi ini? Kuota akan dikembalikan.');">
                                @csrf
                                <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded text-xs font-bold shadow-lg transition transform hover:scale-105" title="Tolak">
                                    ✕ Tolak
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-slate-500">
                        Tidak ada pesanan pending saat ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection