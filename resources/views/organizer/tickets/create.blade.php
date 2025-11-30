@extends('layouts.dashboard')

@section('content')
<div class="max-w-6xl mx-auto">
    
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-white">Kelola Tiket</h2>
            {{-- Gunakan $event->name, bukan $ticket->name --}}
            <p class="text-slate-400 text-sm">Event: <span class="text-purple-400 font-bold">{{ $event->name }}</span></p>
        </div>
        <a href="{{ route('organizer.events.edit', $event->id) }}" class="text-slate-400 hover:text-white bg-slate-800 px-4 py-2 rounded-lg text-sm border border-slate-700">
            &larr; Selesai & Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <div>
            <div class="bg-slate-800 p-6 rounded-xl border border-slate-700 sticky top-4 shadow-lg">
                <h3 class="text-lg font-bold text-white mb-4 border-b border-slate-700 pb-2 flex items-center">
                    <span class="bg-purple-600 w-2 h-6 mr-2 rounded-full"></span>
                    Tambah Tiket Baru
                </h3>
                
                <form action="{{ route('organizer.events.tickets.store', $event->id) }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium text-slate-300">Nama Tiket</label>
                        <input type="text" name="name" class="bg-slate-900 border border-slate-600 text-white text-sm rounded-lg block w-full p-2.5 focus:ring-purple-500 focus:border-purple-500" placeholder="Contoh: Presale 2" required>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-slate-300">Harga (Rp)</label>
                            <input type="number" name="price" class="bg-slate-900 border border-slate-600 text-white text-sm rounded-lg block w-full p-2.5 focus:ring-purple-500 focus:border-purple-500" placeholder="0" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-slate-300">Kuota</label>
                            <input type="number" name="quota" class="bg-slate-900 border border-slate-600 text-white text-sm rounded-lg block w-full p-2.5 focus:ring-purple-500 focus:border-purple-500" placeholder="100" required>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block mb-2 text-sm font-medium text-slate-300">Deskripsi (Opsional)</label>
                        <input type="text" name="description" class="bg-slate-900 border border-slate-600 text-white text-sm rounded-lg block w-full p-2.5 focus:ring-purple-500 focus:border-purple-500" placeholder="Contoh: Termasuk Merchandise">
                    </div>

                    <button type="submit" class="w-full text-white bg-gradient-to-r from-purple-600 to-pink-600 hover:bg-gradient-to-l font-medium rounded-lg text-sm px-5 py-2.5 text-center shadow-lg shadow-purple-500/30">
                        + Simpan Tiket
                    </button>
                </form>
            </div>
        </div>

        <div>
            <h3 class="text-lg font-bold text-white mb-4 flex items-center justify-between">
                <span>Tiket Tersedia</span>
                <span class="bg-slate-700 text-slate-300 text-xs px-2 py-1 rounded-full">{{ $event->tickets->count() }}</span>
            </h3>
            
            <div class="space-y-4">
                {{-- Di sini baru boleh pakai $ticket --}}
                @forelse($event->tickets as $ticket)
                <div class="bg-slate-800 p-5 rounded-xl border border-slate-700 hover:border-purple-500 transition group relative shadow-md">
                    
                    <div class="flex justify-between items-start">
                        <div>
                            <h4 class="text-white font-bold text-lg flex items-center gap-2">
                                {{ $ticket->name }}
                                {{-- Label Terbaru --}}
                                @if($loop->first) <span class="text-[10px] bg-green-900 text-green-300 px-1.5 py-0.5 rounded border border-green-700">TERBARU</span> @endif
                            </h4>
                            <p class="text-sm text-slate-400 mb-3">{{ $ticket->description ?? 'Tidak ada deskripsi' }}</p>
                            
                            <div class="flex items-center gap-3 text-sm">
                                <span class="bg-purple-900/50 text-purple-300 px-2 py-1 rounded border border-purple-500/30">
                                    Rp {{ number_format($ticket->price, 0, ',', '.') }}
                                </span>
                                <span class="text-slate-400 border border-slate-600 px-2 py-1 rounded">
                                    Stok: <strong class="text-white">{{ $ticket->quota }}</strong>
                                </span>
                            </div>
                        </div>

                        {{-- Tombol Hapus --}}
                        <form action="{{ route('organizer.tickets.destroy', $ticket->id) }}" method="POST" onsubmit="return confirm('Yakin hapus tiket ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-slate-500 hover:text-red-500 bg-slate-900 hover:bg-red-900/20 p-2 rounded-lg transition" title="Hapus Tiket">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </div>

                    {{-- Tombol Edit Tiket Spesifik --}}
                    <div class="mt-4 pt-3 border-t border-slate-700/50">
                        <a href="{{ route('organizer.tickets.edit', $ticket->id) }}" class="text-xs text-yellow-500 hover:text-yellow-400 flex items-center hover:underline">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            Edit detail tiket ini
                        </a>
                    </div>

                </div>
                @empty
                <div class="text-center py-10 bg-slate-800/50 rounded-xl border border-slate-700 border-dashed">
                    <p class="text-slate-500 mb-2">Belum ada tiket dibuat.</p>
                    <p class="text-xs text-slate-600">Isi formulir di sebelah kiri untuk menambah tiket.</p>
                </div>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection