@extends('layouts.dashboard')

@section('content')
<h2 class="text-2xl font-bold mb-6">Laporan Penjualan</h2>

<div class="bg-slate-800 p-6 rounded-xl border border-slate-700 mb-6 flex justify-between items-center">
    <div>
        <h3 class="text-slate-400 text-sm uppercase">Total Pendapatan</h3>
        <p class="text-3xl font-bold text-green-400">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
    </div>
    <button onclick="window.print()" class="bg-slate-700 hover:bg-slate-600 text-white px-4 py-2 rounded text-sm">
        🖨️ Cetak Laporan
    </button>
</div>

<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left text-slate-300">
        <thead class="text-xs text-slate-400 uppercase bg-slate-800">
            <tr>
                <th class="px-6 py-3">ID Booking</th>
                <th class="px-6 py-3">Pembeli</th>
                <th class="px-6 py-3">Acara</th>
                <th class="px-6 py-3">Tiket & Qty</th>
                <th class="px-6 py-3">Total</th>
                <th class="px-6 py-3">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reports as $rpt)
            <tr class="bg-slate-900 border-b border-slate-700">
                <td class="px-6 py-4 font-mono text-purple-400">#{{ $rpt->id }}</td>
                <td class="px-6 py-4">
                    {{ $rpt->user->name }}<br>
                    <span class="text-xs text-slate-500">{{ $rpt->user->email }}</span>
                </td>
                <td class="px-6 py-4">{{ $rpt->event->name }}</td>
                <td class="px-6 py-4">
                    {{ $rpt->quantity }}x Tiket
                </td>
                <td class="px-6 py-4 font-bold text-white">
                    Rp {{ number_format($rpt->total_price, 0, ',', '.') }}
                </td>
                <td class="px-6 py-4 text-xs">
                    {{ $rpt->created_at->format('d/m/Y H:i') }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection