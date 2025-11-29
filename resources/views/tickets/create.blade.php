@extends('layouts.dashboard')

@section('content')
<div class="max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold mb-2">Buat Tiket</h2>
    <p class="text-slate-400 mb-6">Untuk Event: <span class="text-purple-400">{{ $event->name }}</span></p>

    <form action="{{ route('events.tickets.store', $event->id) }}" method="POST" class="bg-slate-800 p-6 rounded-xl border border-slate-700">
        @csrf
        
        <div class="mb-4">
            <label class="block mb-2 text-sm font-medium text-slate-300">Nama Tiket</label>
            <input type="text" name="name" class="bg-slate-900 border border-slate-600 text-white text-sm rounded-lg block w-full p-2.5" placeholder="Contoh: VIP Standing" required>
        </div>

        <div class="mb-4">
            <label class="block mb-2 text-sm font-medium text-slate-300">Deskripsi / Benefit</label>
            <input type="text" name="description" class="bg-slate-900 border border-slate-600 text-white text-sm rounded-lg block w-full p-2.5" placeholder="Contoh: Free Merchandise + Front Row">
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block mb-2 text-sm font-medium text-slate-300">Harga (Rp)</label>
                <input type="number" name="price" class="bg-slate-900 border border-slate-600 text-white text-sm rounded-lg block w-full p-2.5" required>
            </div>
            <div>
                <label class="block mb-2 text-sm font-medium text-slate-300">Kuota Stok</label>
                <input type="number" name="quota" class="bg-slate-900 border border-slate-600 text-white text-sm rounded-lg block w-full p-2.5" required>
            </div>
        </div>

        <button type="submit" class="w-full text-white bg-purple-600 hover:bg-purple-700 font-medium rounded-lg text-sm px-5 py-2.5">
            Tambah Tiket
        </button>
    </form>
</div>
@endsection