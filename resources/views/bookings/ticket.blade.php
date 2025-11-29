@extends('layouts.main')

@section('content')
<div class="max-w-3xl mx-auto py-16 px-4">
    <div class="bg-slate-900 p-8 rounded-2xl border border-slate-700 shadow-lg">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-white">E-Ticket</h1>
                <p class="text-sm text-slate-400">Tunjukkan ini kepada petugas saat memasuki venue.</p>
            </div>
            <div class="text-right">
                <p class="text-sm text-slate-400">No. Pesanan</p>
                <div class="text-purple-400 font-bold">#{{ $booking->id }}</div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
            <div class="md:col-span-2">
                <h2 class="text-xl font-extrabold text-white mb-1">{{ $booking->event->name }}</h2>
                <div class="text-sm text-slate-400 mb-3">{{ $booking->event->location }}</div>

                <div class="flex items-center gap-4 text-sm text-slate-300">
                    <div>
                        <div class="text-xs text-slate-400">Tanggal</div>
                        <div class="font-bold">{{ \Carbon\Carbon::parse($booking->event->event_date)->format('l, d F Y') }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-slate-400">Jam</div>
                        <div class="font-bold">{{ \Carbon\Carbon::parse($booking->event->event_time)->format('H:i') }} WIB</div>
                    </div>
                    <div>
                        <div class="text-xs text-slate-400">Tiket</div>
                        <div class="font-bold">{{ $booking->ticket->name }} x{{ $booking->quantity }}</div>
                    </div>
                </div>

                <div class="mt-6 border-t border-slate-700 pt-4 flex items-center justify-between">
                    <div>
                        <div class="text-xs text-slate-400">Total Bayar</div>
                        <div class="font-bold text-xl text-purple-400">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</div>
                    </div>

                    <div class="text-right text-sm text-slate-400">
                        <div>Nama: <span class="text-white font-bold">{{ $booking->user->name }}</span></div>
                        <div>Email: <span class="text-white">{{ $booking->user->email }}</span></div>
                    </div>
                </div>
            </div>

            <div class="bg-slate-800 p-4 rounded-xl flex flex-col items-center justify-center">
                {{-- Placeholder QR / Barcode --}}
                <div class="w-40 h-40 bg-white/5 rounded-lg flex items-center justify-center mb-4">
                    <div class="text-xs text-slate-400 text-center p-4">QR CODE<br>({{ $booking->id }})</div>
                </div>
                <div class="text-xs text-slate-400">Tunjukkan QR ini saat masuk</div>
            </div>
        </div>

        <div class="mt-6 flex gap-3 justify-end">
            <a href="#" onclick="window.print(); return false;" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg font-bold text-sm">Print / Save as PDF</a>
            <a href="{{ route('home') }}" class="border border-slate-600 text-slate-300 px-4 py-2 rounded-lg text-sm">Kembali</a>
        </div>
    </div>
</div>
@endsection
