@extends('layouts.dashboard')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Buat Event & Tiket</h2>
        <a href="{{ route('organizer.events.index') }}" class="text-slate-400 hover:text-white">Batal</a>
    </div>

    {{-- Tambahkan id="eventForm" --}}
    <form id="eventForm" action="{{ route('organizer.events.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        
        <div class="bg-slate-800 p-6 rounded-xl border border-slate-700">
            <h3 class="text-lg font-bold text-white mb-4 flex items-center">
                <span class="bg-purple-600 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs mr-2">1</span>
                Informasi Acara
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block mb-2 text-sm font-medium text-slate-300">Nama Acara</label>
                    <input type="text" name="name" class="bg-slate-900 border border-slate-600 text-white text-sm rounded-lg block w-full p-2.5" placeholder="Contoh: Jazz Night" required>
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
                    <label class="block mb-2 text-sm font-medium text-slate-300">Waktu Mulai</label>
                    <input type="time" name="event_time" class="bg-slate-900 border border-slate-600 text-white text-sm rounded-lg block w-full p-2.5" required>
                </div>
                <div class="md:col-span-2">
                    <label class="block mb-2 text-sm font-medium text-slate-300">Lokasi Venue</label>
                    <input type="text" name="location" class="bg-slate-900 border border-slate-600 text-white text-sm rounded-lg block w-full p-2.5" placeholder="Nama Gedung / Stadium" required>
                </div>
                <div class="md:col-span-2">
                    <label class="block mb-2 text-sm font-medium text-slate-300">Deskripsi / Lineup</label>
                    <textarea name="description" rows="3" class="bg-slate-900 border border-slate-600 text-white text-sm rounded-lg block w-full p-2.5" placeholder="Tulis deskripsi acara..."></textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="block mb-2 text-sm font-medium text-slate-300">Poster Acara</label>
                    <input type="file" name="image" class="block w-full text-sm text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-purple-900 file:text-purple-300 border border-slate-600 rounded-lg cursor-pointer bg-slate-900">
                </div>
            </div>
        </div>

        <div class="bg-slate-800 p-6 rounded-xl border border-slate-700">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-white flex items-center">
                    <span class="bg-pink-600 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs mr-2">2</span>
                    Kategori Tiket
                </h3>
                
                {{-- PERBAIKAN: Pastikan ada type="button" --}}
                <button type="button" onclick="addTicketRow()" class="text-xs bg-slate-700 hover:bg-slate-600 text-white px-3 py-1.5 rounded-lg border border-slate-600 transition">
                    + Tambah Varian Tiket
                </button>
            </div>

            <div id="tickets-container" class="space-y-4">
                <div class="ticket-row grid grid-cols-1 md:grid-cols-7 gap-4 p-4 bg-slate-900/50 rounded-lg border border-slate-600/50">
                    <div class="md:col-span-2">
                        <label class="text-xs text-slate-400 mb-1 block">Nama Tiket</label>
                        <input type="text" name="tickets[0][name]" class="bg-slate-800 border border-slate-600 text-white text-sm rounded px-2 py-1.5 w-full" placeholder="VIP / Reguler" required>
                    </div>
                    <div class="md:col-span-2">
                        <label class="text-xs text-slate-400 mb-1 block">Harga (Rp)</label>
                        <input type="number" name="tickets[0][price]" class="bg-slate-800 border border-slate-600 text-white text-sm rounded px-2 py-1.5 w-full" placeholder="100000" required>
                    </div>
                    <div class="md:col-span-1">
                        <label class="text-xs text-slate-400 mb-1 block">Kuota</label>
                        <input type="number" name="tickets[0][quota]" class="bg-slate-800 border border-slate-600 text-white text-sm rounded px-2 py-1.5 w-full" placeholder="50" required>
                    </div>
                    <div class="md:col-span-2">
                        <label class="text-xs text-slate-400 mb-1 block">Deskripsi (Opsional)</label>
                        <input type="text" name="tickets[0][description]" class="bg-slate-800 border border-slate-600 text-white text-sm rounded px-2 py-1.5 w-full" placeholder="Benefit...">
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="w-full text-white bg-gradient-to-r from-purple-600 to-pink-600 hover:bg-gradient-to-l focus:ring-4 focus:outline-none focus:ring-purple-800 font-bold rounded-lg text-sm px-5 py-3 text-center">
            🚀 Simpan Event & Semua Tiket
        </button>
    </form>
</div>

<script>
    let ticketIndex = 1;

    // Fungsi Tambah Tiket
    function addTicketRow() {
        const container = document.getElementById('tickets-container');
        
        const newRow = `
        <div class="ticket-row grid grid-cols-1 md:grid-cols-7 gap-4 p-4 bg-slate-900/50 rounded-lg border border-slate-600/50 mt-4 relative group animate-fade-in">
            <button type="button" onclick="this.parentElement.remove()" class="absolute -top-2 -right-2 bg-red-600 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs hover:bg-red-700 shadow-lg" title="Hapus Baris">×</button>
            
            <div class="md:col-span-2">
                <input type="text" name="tickets[${ticketIndex}][name]" class="bg-slate-800 border border-slate-600 text-white text-sm rounded px-2 py-1.5 w-full" placeholder="Nama Tiket" required>
            </div>
            <div class="md:col-span-2">
                <input type="number" name="tickets[${ticketIndex}][price]" class="bg-slate-800 border border-slate-600 text-white text-sm rounded px-2 py-1.5 w-full" placeholder="Harga" required>
            </div>
            <div class="md:col-span-1">
                <input type="number" name="tickets[${ticketIndex}][quota]" class="bg-slate-800 border border-slate-600 text-white text-sm rounded px-2 py-1.5 w-full" placeholder="Qty" required>
            </div>
            <div class="md:col-span-2">
                <input type="text" name="tickets[${ticketIndex}][description]" class="bg-slate-800 border border-slate-600 text-white text-sm rounded px-2 py-1.5 w-full" placeholder="Deskripsi">
            </div>
        </div>
        `;

        container.insertAdjacentHTML('beforeend', newRow);
        ticketIndex++;
    }

    // PERBAIKAN: Mencegah Tombol ENTER mensubmit form secara tidak sengaja
    document.addEventListener("DOMContentLoaded", function() {
        window.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && e.target.nodeName === 'INPUT') {
                e.preventDefault();
                return false;
            }
        }, true);
    });
</script>
@endsection