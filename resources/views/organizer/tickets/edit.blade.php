@extends('layouts.dashboard')

@section('content')
<div class="max-w-xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Edit Detail Tiket</h2>
        {{-- Tombol Batal kembali ke halaman Kelola Tiket --}}
        <a href="{{ route('organizer.events.tickets.create', $ticket->event_id) }}" class="text-slate-400 hover:text-white">Batal</a>
    </div>

    <div class="bg-slate-800 p-6 rounded-xl border border-slate-700">
        <p class="text-sm text-slate-400 mb-4">Mengedit tiket: <span class="text-purple-400 font-bold">{{ $ticket->name }}</span></p>

        <form action="{{ route('organizer.tickets.update', $ticket->id) }}" method="POST">
            @csrf
            @method('PUT') <div class="mb-4">
                <label class="block mb-2 text-sm font-medium text-slate-300">Nama Tiket</label>
                <input type="text" name="name" value="{{ $ticket->name }}" class="bg-slate-900 border border-slate-600 text-white text-sm rounded-lg block w-full p-2.5" required>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block mb-2 text-sm font-medium text-slate-300">Harga (Rp)</label>
                    <input type="number" name="price" value="{{ $ticket->price }}" class="bg-slate-900 border border-slate-600 text-white text-sm rounded-lg block w-full p-2.5" required>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-slate-300">Kuota</label>
                    <input type="number" name="quota" value="{{ $ticket->quota }}" class="bg-slate-900 border border-slate-600 text-white text-sm rounded-lg block w-full p-2.5" required>
                </div>
            </div>

            <div class="mb-6">
                <label class="block mb-2 text-sm font-medium text-slate-300">Deskripsi (Opsional)</label>
                <input type="text" name="description" value="{{ $ticket->description }}" class="bg-slate-900 border border-slate-600 text-white text-sm rounded-lg block w-full p-2.5">
            </div>

            <button type="submit" class="w-full text-white bg-yellow-600 hover:bg-yellow-700 font-medium rounded-lg text-sm px-5 py-2.5">
                Simpan Perubahan
            </button>
        </form>
    </div>
</div>
@endsection