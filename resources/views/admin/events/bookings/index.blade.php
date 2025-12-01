@extends('layouts.dashboard')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-white">Kelola Transaksi (Semua Event)</h2>
</div>

<div class="relative overflow-x-auto shadow-md sm:rounded-lg border border-slate-700">
    <table class="w-full text-sm text-left text-slate-300">
        <thead class="text-xs text-slate-400 uppercase bg-slate-800">
            <tr>
                <th class="px-6 py-3">ID & Tanggal</th>
                <th class="px-6 py-3">Pembeli</th>
                <th class="px-6 py-3">Event / Tiket</th>
                <th class="px-6 py-3">Total</th>
                <th class="px-6 py-3 text-center">Status</th>
                <th class="px-6 py-3 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bookings as $booking)
            <tr class="bg-slate-900 border-b border-slate-700 hover:bg-slate-800 transition">
                
                {{-- ID & Tanggal --}}
                <td class="px-6 py-4">
                    <span class="font-mono text-purple-400">#{{ $booking->id }}</span><br>
                    <span class="text-xs text-slate-500">{{ $booking->created_at->format('d M Y H:i') }}</span>
                </td>

                {{-- Pembeli --}}
                <td class="px-6 py-4">
                    <div class="font-bold text-white">{{ $booking->user->name }}</div>
                    <div class="text-xs text-slate-500">{{ $booking->user->email }}</div>
                </td>

                {{-- Event & Tiket --}}
                <td class="px-6 py-4">
                    <div class="text-white">{{ $booking->event->name }}</div>
                    <span class="bg-slate-700 text-slate-300 text-xs px-2 py-0.5 rounded">
                        {{ $booking->ticket->name }} (x{{ $booking->quantity }})
                    </span>
                </td>

                {{-- Total --}}
                <td class="px-6 py-4 font-bold text-white">
                    Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                </td>

                {{-- Status --}}
                <td class="px-6 py-4 text-center">
                    @if($booking->status == 'approved')
                        <span class="bg-green-500/20 text-green-400 text-xs font-bold px-2 py-1 rounded border border-green-500/50">LUNAS</span>
                    @elseif($booking->status == 'pending')
                        <span class="bg-yellow-500/20 text-yellow-400 text-xs font-bold px-2 py-1 rounded border border-yellow-500/50 animate-pulse">MENUNGGU</span>
                    @else
                        <span class="bg-red-500/20 text-red-400 text-xs font-bold px-2 py-1 rounded border border-red-500/50">BATAL</span>
                    @endif
                </td>

                {{-- Aksi (Tombol ACC Admin) --}}
                <td class="px-6 py-4 text-center">
                    @if($booking->status == 'pending')
                        <div class="flex items-center justify-center gap-2">
                            {{-- Approve --}}
                            <form action="{{ route('admin.bookings.approve', $booking->id) }}" method="POST">
                                @csrf
                                <button class="bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded text-xs font-bold shadow-lg transition" title="ACC">
                                    ✓ Terima
                                </button>
                            </form>

                            {{-- Reject --}}
                            <form action="{{ route('admin.bookings.reject', $booking->id) }}" method="POST" onsubmit="return confirm('Tolak transaksi ini? Kuota akan dikembalikan.');">
                                @csrf
                                <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded text-xs font-bold shadow-lg transition" title="Tolak">
                                    ✕ Tolak
                                </button>
                            </form>
                        </div>
                    @else
                        <span class="text-slate-600 text-xs">-</span>
                    @endif
                </td>

            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-8 text-center text-slate-500">
                    Belum ada transaksi masuk.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection