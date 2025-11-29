@extends('layouts.dashboard')

@section('content')
<div class="max-w-xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Tambah Tiket (Admin Mode)</h2>
        {{-- Tombol Batal kembali ke Edit Event Admin --}}
        <a href="{{ route('admin.events.edit', $event->id) }}" class="text-slate-400 hover:text-white">Batal</a>
    </div>

    <div class="bg-slate-800 p-6 rounded-xl border border-slate-700">
        <p class="text-sm text-slate-400 mb-4">Event: <span class="text-purple-400 font-bold">{{ $event->name }}</span></p>

        {{-- PERHATIKAN: Route ini harus 'admin.events.tickets.store' --}}
        <form action="{{ route('admin.events.tickets.store', $event->id) }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="block mb-2 text-sm font-medium text-slate-300">Nama Tiket</label>
                <input type="text" name="name" class="bg-slate-900 border border-slate-600 text-white text-sm rounded-lg block w-full p-2.5" placeholder="Contoh: VIP / Presale" required>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block mb-2 text-sm font-medium text-slate-300">Harga (Rp)</label>
                    <input type="number" name="price" class="bg-slate-900 border border-slate-600 text-white text-sm rounded-lg block w-full p-2.5" placeholder="0" required>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-slate-300">Kuota</label>
                    <input type="number" name="quota" class="bg-slate-900 border border-slate-600 text-white text-sm rounded-lg block w-full p-2.5" placeholder="100" required>
                </div>
            </div>

            <div class="mb-6">
                <label class="block mb-2 text-sm font-medium text-slate-300">Deskripsi (Opsional)</label>
                <input type="text" name="description" class="bg-slate-900 border border-slate-600 text-white text-sm rounded-lg block w-full p-2.5">
            </div>

            <button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5">
                Simpan Tiket (Admin)
            </button>
        </form>
    </div>
</div>
@endsection