@extends('layouts.dashboard')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Edit Event</h2>
        <a href="{{ route('organizer.events.index') }}" class="text-slate-400 hover:text-white">Batal</a>
    </div>

    {{-- PENTING: Action mengarah ke organizer.events.update dengan method PUT --}}
    <form action="{{ route('organizer.events.update', $event->id) }}" method="POST" enctype="multipart/form-data" class="bg-slate-800 p-6 rounded-xl border border-slate-700">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            
            {{-- Nama Event --}}
            <div>
                <label class="block mb-2 text-sm font-medium text-slate-300">Nama Acara</label>
                <input type="text" name="name" value="{{ $event->name }}" class="bg-slate-900 border border-slate-600 text-white text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5" required>
            </div>

            {{-- Kategori --}}
            <div>
                <label class="block mb-2 text-sm font-medium text-slate-300">Kategori Musik</label>
                <select name="category" class="bg-slate-900 border border-slate-600 text-white text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5">
                    <option value="Pop" {{ $event->category == 'Pop' ? 'selected' : '' }}>Pop</option>
                    <option value="Rock" {{ $event->category == 'Rock' ? 'selected' : '' }}>Rock</option>
                    <option value="Jazz" {{ $event->category == 'Jazz' ? 'selected' : '' }}>Jazz</option>
                    <option value="EDM" {{ $event->category == 'EDM' ? 'selected' : '' }}>EDM</option>
                    <option value="Indie" {{ $event->category == 'Indie' ? 'selected' : '' }}>Indie</option>
                </select>
            </div>

            {{-- Tanggal --}}
            <div>
                <label class="block mb-2 text-sm font-medium text-slate-300">Tanggal</label>
                <input type="date" name="event_date" value="{{ $event->event_date }}" class="bg-slate-900 border border-slate-600 text-white text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5" required>
            </div>

            {{-- Waktu --}}
            <div>
                <label class="block mb-2 text-sm font-medium text-slate-300">Waktu Mulai</label>
                <input type="time" name="event_time" value="{{ \Carbon\Carbon::parse($event->event_time)->format('H:i') }}" class="bg-slate-900 border border-slate-600 text-white text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5" required>
            </div>

            {{-- Lokasi --}}
            <div class="md:col-span-2">
                <label class="block mb-2 text-sm font-medium text-slate-300">Lokasi Venue</label>
                <input type="text" name="location" value="{{ $event->location }}" class="bg-slate-900 border border-slate-600 text-white text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5" required>
            </div>

            {{-- Deskripsi --}}
            <div class="md:col-span-2">
                <label class="block mb-2 text-sm font-medium text-slate-300">Deskripsi / Lineup</label>
                <textarea name="description" rows="4" class="bg-slate-900 border border-slate-600 text-white text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5">{{ $event->description }}</textarea>
            </div>

            {{-- Upload Gambar --}}
            <div class="md:col-span-2">
                <label class="block mb-2 text-sm font-medium text-slate-300">Poster Baru (Opsional)</label>
                <input type="file" name="image" class="block w-full text-sm text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-purple-900 file:text-purple-300 hover:file:bg-purple-800 border border-slate-600 rounded-lg cursor-pointer bg-slate-900 focus:outline-none">
                <p class="mt-1 text-xs text-slate-500">Biarkan kosong jika tidak ingin mengganti poster lama.</p>
                
                @if($event->image)
                    <div class="mt-2">
                        <p class="text-xs text-slate-400 mb-1">Poster Saat Ini:</p>
                        <img src="{{ asset('storage/' . $event->image) }}" class="h-20 rounded border border-slate-700">
                    </div>
                @endif
            </div>
        </div>

        <button type="submit" class="text-white bg-gradient-to-r from-yellow-500 to-orange-600 hover:bg-gradient-to-l focus:ring-4 focus:outline-none focus:ring-yellow-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center w-full md:w-auto">
            Update Event
        </button>
    </form>
</div>
@endsection