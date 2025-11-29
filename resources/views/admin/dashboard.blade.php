@extends('layouts.dashboard')

@section('content')

<div class="mb-8 flex justify-between items-center">
    <div>
        <h2 class="text-3xl font-bold text-white">Dashboard Admin</h2>
        <p class="text-slate-400">Pusat kontrol sistem GoTix.</p>
    </div>
    <div class="text-right">
        <span class="bg-purple-900 text-purple-300 text-xs font-medium px-2.5 py-0.5 rounded border border-purple-400">
            {{ \Carbon\Carbon::now()->format('d F Y') }}
        </span>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-slate-800 p-6 rounded-2xl border border-slate-700 shadow-lg relative overflow-hidden">
        <div class="absolute right-0 top-0 p-4 opacity-10">
            <svg class="w-24 h-24 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path></svg>
        </div>
        <h3 class="text-slate-400 text-sm font-medium uppercase tracking-wider">Total Pengguna</h3>
        <p class="text-4xl font-bold text-white mt-2">{{ $totalUsers }}</p>
    </div>

    <div class="bg-slate-800 p-6 rounded-2xl border border-slate-700 shadow-lg relative overflow-hidden">
        <div class="absolute right-0 top-0 p-4 opacity-10">
            <svg class="w-24 h-24 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 3a1 1 0 00-1.447-.894L8.763 6H5a3 3 0 000 6h.28l1.771 5.316A1 1 0 008 18h1a1 1 0 001-1v-4.382l6.553 3.276A1 1 0 0018 15V3z" clip-rule="evenodd"></path></svg>
        </div>
        <h3 class="text-slate-400 text-sm font-medium uppercase tracking-wider">Total Acara</h3>
        <p class="text-4xl font-bold text-white mt-2">{{ $totalEvents }}</p>
    </div>

    <div class="bg-slate-800 p-6 rounded-2xl border border-slate-700 shadow-lg relative overflow-hidden">
        <div class="absolute right-0 top-0 p-4 opacity-10">
            <svg class="w-24 h-24 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <h3 class="text-slate-400 text-sm font-medium uppercase tracking-wider">Total Pendapatan</h3>
        <p class="text-4xl font-bold text-green-400 mt-2">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    
    <div class="bg-slate-800 rounded-2xl border border-slate-700 overflow-hidden flex flex-col h-full">
        <div class="p-6 border-b border-slate-700 flex justify-between items-center">
            <h3 class="text-xl font-bold text-white flex items-center">
                <span class="bg-yellow-500 w-3 h-3 rounded-full mr-2 animate-pulse"></span>
                Butuh Persetujuan
            </h3>
            <a href="{{ route('admin.users') }}" class="text-sm text-purple-400 hover:text-white">Lihat Semua</a>
        </div>
        
        <div class="p-0 flex-1">
            @if($pendingOrganizers->count() > 0)
                <table class="w-full text-sm text-left text-slate-300">
                    <tbody class="divide-y divide-slate-700">
                        @foreach($pendingOrganizers as $organizer)
                        <tr class="hover:bg-slate-700/50 transition">
                            <td class="px-6 py-4">
                                <p class="text-white font-bold">{{ $organizer->name }}</p>
                                <p class="text-xs text-slate-500">{{ $organizer->email }}</p>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <form action="{{ route('admin.approve', $organizer->id) }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="status" value="approved">
                                    <button class="bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded-lg text-xs font-bold shadow-lg shadow-green-900/20">
                                        ✓ ACC
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="p-8 text-center text-slate-500 flex flex-col items-center justify-center h-full">
                    <svg class="w-12 h-12 mb-3 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <p>Tidak ada organizer pending saat ini.</p>
                </div>
            @endif
        </div>
    </div>

    <div class="bg-slate-800 rounded-2xl border border-slate-700 overflow-hidden flex flex-col h-full">
        <div class="p-6 border-b border-slate-700 flex justify-between items-center">
            <h3 class="text-xl font-bold text-white">Transaksi Terbaru</h3>
            <a href="{{ route('admin.reports') }}" class="text-sm text-purple-400 hover:text-white">Lihat Laporan</a>
        </div>

        <div class="p-0 flex-1">
             @if($recentBookings->count() > 0)
                <table class="w-full text-sm text-left text-slate-300">
                    <tbody class="divide-y divide-slate-700">
                        @foreach($recentBookings as $booking)
                        <tr class="hover:bg-slate-700/50 transition">
                            <td class="px-6 py-4">
                                <p class="text-white font-medium">{{ $booking->user->name }}</p>
                                <p class="text-xs text-purple-400">{{ $booking->event->name }}</p>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <p class="text-white font-bold">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                                <p class="text-xs text-slate-500">{{ $booking->created_at->diffForHumans() }}</p>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="p-8 text-center text-slate-500 flex flex-col items-center justify-center h-full">
                    <p>Belum ada transaksi masuk.</p>
                </div>
            @endif
        </div>
    </div>

</div>

@endsection