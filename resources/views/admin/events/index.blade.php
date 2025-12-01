@extends('layouts.dashboard')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold">Kelola Acara (Events)</h2>
    
    {{-- Tombol Tambah Event Baru --}}
    <a href="{{ route('admin.events.create') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-bold shadow-lg shadow-purple-500/30 transition transform hover:scale-105">
        + Tambah Event
    </a>
</div>

{{-- Tabel List Event --}}
<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left text-slate-300">
        <thead class="text-xs text-slate-400 uppercase bg-slate-800">
            <tr>
                <th class="px-6 py-3">Poster</th>
                <th class="px-6 py-3">Nama Acara & Organizer</th>
                <th class="px-6 py-3">Jadwal</th>
                <th class="px-6 py-3">Lokasi</th>
                <th class="px-6 py-3 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($events as $event)
            <tr class="bg-slate-900 border-b border-slate-700 hover:bg-slate-800 transition">
                <td class="px-6 py-4">
                    <img src="{{ $event->image ? asset('storage/'.$event->image) : 'https://placehold.co/100' }}" class="w-16 h-16 object-cover rounded-lg border border-slate-600" alt="Poster">
                </td>
                
                {{-- KOLOM NAMA ACARA --}}
                <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                        <span class="font-bold text-white text-base">{{ $event->name }}</span>
                        
                        {{-- [BARU] TAG KHUSUS ADMIN --}}
                        @if($event->organizer->role === 'admin')
                            <span class="bg-blue-600 text-white text-[10px] px-2 py-0.5 rounded border border-blue-400 font-bold uppercase tracking-wider shadow-sm">
                                ADMIN
                            </span>
                        @endif
                    </div>

                    <span class="block text-xs text-purple-400 font-normal mt-1 mb-1">{{ $event->category }}</span>
                    
                    {{-- Tampilkan Nama Pembuatnya --}}
                    <span class="text-xs text-slate-500 flex items-center gap-1">
                        Oleh: <span class="{{ $event->organizer->role === 'admin' ? 'text-blue-400 font-bold' : 'text-slate-300' }}">{{ $event->organizer->name }}</span>
                    </span>
                </td>

                <td class="px-6 py-4">
                    {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}<br>
                    <span class="text-xs text-slate-500">{{ \Carbon\Carbon::parse($event->event_time)->format('H:i') }}</span>
                </td>
                <td class="px-6 py-4">{{ $event->location }}</td>
                
                <td class="px-6 py-4 text-center space-y-2">
                    
                    {{-- 1. TOMBOL EDIT (Sekaligus kelola tiket) --}}
                    <a href="{{ route('admin.events.edit', $event->id) }}" class="block w-full bg-yellow-600 hover:bg-yellow-700 text-white px-3 py-1 rounded text-xs transition font-medium">
                        Edit Event & Tiket
                    </a>

                    {{-- 2. TOMBOL HAPUS --}}
                    <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Yakin hapus event ini? Data tiket dan penjualan juga akan terhapus!');">
                        @csrf
                        @method('DELETE')
                        <button class="block w-full bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs transition font-medium">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-8 text-center text-slate-500">
                    Belum ada event yang dibuat. <br>
                    <a href="{{ route('admin.events.create') }}" class="text-purple-400 hover:underline">Buat sekarang yuk!</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection