@extends('layouts.dashboard')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Buat Event Baru</h2>
        <a href="{{ route('organizer.events.index') }}" class="text-slate-400 hover:text-white">Batal</a>
    </div>

    <form action="{{ route('organizer.events.store') }}" method="POST" enctype="multipart/form-data" class="bg-slate-800 p-6 rounded-xl border border-slate-700">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block mb-2 text-sm font-medium text-slate-300">Nama Acara</label>
                <input type="text" name="name" class="bg-slate-900 border border-slate-600 text-white text-sm rounded-lg block w-full p-2.5" required>
            </div>
            <div>
                <label class="block mb-2 text-sm font-medium text-slate-300">Kategori</label>
                <select name="category" class="bg-slate-900 border border-slate-600 text-white text-sm rounded-lg block w-full p-2.5">
                    <option value="Pop">Pop</option>
                    <option value="Rock">Rock</option>
                    <option value="Jazz">Jazz</option>
                    <option value="EDM">EDM</option>
                    <option value="Indie">Indie</option>
                </select>
            </div>
            <div>
                <label class="block mb-2 text-sm font-medium text-slate-300">Tanggal</label>
                <input type="date" name="event_date" class="bg-slate-900 border border-slate-600 text-white text-sm rounded-lg block w-full p-2.5" required>
            </div>
            <div>
                <label class="block mb-2 text-sm font-medium text-slate-300">Waktu</label>
                <input type="time" name="event_time" class="bg-slate-900 border border-slate-600 text-white text-sm rounded-lg block w-full p-2.5" required>
            </div>
            <div class="md:col-span-2">
                <label class="block mb-2 text-sm font-medium text-slate-300">Lokasi</label>
                <input type="text" name="location" class="bg-slate-900 border border-slate-600 text-white text-sm rounded-lg block w-full p-2.5" required>
            </div>
            <div class="md:col-span-2">
                <label class="block mb-2 text-sm font-medium text-slate-300">Deskripsi</label>
                <textarea name="description" rows="3" class="bg-slate-900 border border-slate-600 text-white text-sm rounded-lg block w-full p-2.5"></textarea>
            </div>
            <div class="md:col-span-2">
                <label class="block mb-2 text-sm font-medium text-slate-300">Poster</label>
                <input type="file" name="image" class="block w-full text-sm text-slate-400 border border-slate-600 rounded-lg bg-slate-900">
            </div>
        </div>
        <button type="submit" class="text-white bg-purple-600 hover:bg-purple-700 font-medium rounded-lg text-sm px-5 py-2.5">Simpan Event</button>
    </form>
</div>
@endsection