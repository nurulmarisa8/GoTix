@extends('layouts.dashboard')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Edit Event (Admin Mode)</h2>
        <a href="{{ route('admin.events.index') }}" class="text-slate-400 hover:text-white">Batal</a>
    </div>

    {{-- Form mengarah ke update admin --}}
    <form action="{{ route('admin.events.update', $event->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div class="bg-slate-800 p-6 rounded-xl border border-slate-700">
            <h3 class="text-lg font-bold text-white mb-4 border-b border-slate-700 pb-2">Informasi Event</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block mb-2 text-sm font-medium text-slate-300">Nama Acara</label>
                    <input type="text" name="name" value="{{ $event->name }}" class="bg-slate-900 border border-slate-600 text-white text-sm rounded-lg block w-full p-2.5" required>
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-slate-300">Kategori</label>
                    <select name="category" class="bg-slate-900 border border-slate-600 text-white text-sm rounded-lg block w-full p-2.5">
                        <option value="Pop" {{ $event->category == 'Pop' ? 'selected' : '' }}>Pop</option>
                        <option value="Rock" {{ $event->category == 'Rock' ? 'selected' : '' }}>Rock</option>
                        <option value="Jazz" {{ $event->category == 'Jazz' ? 'selected' : '' }}>Jazz</option>
                        <option value="EDM" {{ $event->category == 'EDM' ? 'selected' : '' }}>EDM</option>
                        <option value="Indie" {{ $event->category == 'Indie' ? 'selected' : '' }}>Indie</option>
                    </select>
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-slate-300">Tanggal</label>
                    <input type="date" name="event_date" value="{{ $event->event_date }}" class="bg-slate-900 border border-slate-600 text-white text-sm rounded-lg block w-full p-2.5" required>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-slate-300">Waktu</label>
                    <input type="time" name="event_time" value="{{ \Carbon\Carbon::parse($event->event_time)->format('H:i') }}" class="bg-slate-900 border border-slate-600 text-white text-sm rounded-lg block w-full p-2.5" required>
                </div>

                <div class="md:col-span-2">
                    <label class="block mb-2 text-sm font-medium text-slate-300">Lokasi</label>
                    <input type="text" name="location" value="{{ $event->location }}" class="bg-slate-900 border border-slate-600 text-white text-sm rounded-lg block w-full p-2.5" required>
                </div>

                <div class="md:col-span-2">
                    <label class="block mb-2 text-sm font-medium text-slate-300">Deskripsi</label>
                    <textarea name="description" rows="4" class="bg-slate-900 border border-slate-600 text-white text-sm rounded-lg block w-full p-2.5">{{ $event->description }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block mb-2 text-sm font-medium text-slate-300">Poster Baru (Opsional)</label>
                    <input type="file" name="image" class="block w-full text-sm text-slate-400 border border-slate-600 rounded-lg bg-slate-900">
                </div>
            </div>
        </div>

        <div class="bg-slate-800 p-6 rounded-xl border border-slate-700">
            <h3 class="text-lg font-bold text-white mb-4">Edit Tiket</h3>

            <div class="space-y-4">
                @foreach($event->tickets as $ticket)
                <div class="grid grid-cols-1 md:grid-cols-7 gap-4 p-4 bg-slate-900/50 rounded-lg border border-slate-600/50">
                    <div class="md:col-span-2">
                        <label class="text-xs text-slate-400 mb-1">Nama</label>
                        <input type="text" name="tickets[{{ $ticket->id }}][name]" value="{{ $ticket->name }}" class="bg-slate-800 border border-slate-600 text-white text-sm rounded w-full p-1.5" required>
                    </div>
                    <div class="md:col-span-2">
                        <label class="text-xs text-slate-400 mb-1">Harga</label>
                        <input type="number" name="tickets[{{ $ticket->id }}][price]" value="{{ $ticket->price }}" class="bg-slate-800 border border-slate-600 text-white text-sm rounded w-full p-1.5" required>
                    </div>
                    <div class="md:col-span-1">
                        <label class="text-xs text-slate-400 mb-1">Kuota</label>
                        <input type="number" name="tickets[{{ $ticket->id }}][quota]" value="{{ $ticket->quota }}" class="bg-slate-800 border border-slate-600 text-white text-sm rounded w-full p-1.5" required>
                    </div>
                    <div class="md:col-span-2">
                        <label class="text-xs text-slate-400 mb-1">Deskripsi</label>
                        <input type="text" name="tickets[{{ $ticket->id }}][description]" value="{{ $ticket->description }}" class="bg-slate-800 border border-slate-600 text-white text-sm rounded w-full p-1.5">
                    </div>
                </div>
                @endforeach

                @if($event->tickets->isEmpty())
                    <p class="text-slate-500 text-center text-sm py-4">Belum ada tiket.</p>
                @endif
            </div>
            
            {{-- TOMBOL TAMBAH TIKET SUDAH DIHAPUS DARI SINI AGAR TIDAK ERROR --}}
        </div>

        <button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 font-bold rounded-lg text-sm px-5 py-3 text-center">
            💾 Simpan Perubahan
        </button>
    </form>
</div>
@endsection