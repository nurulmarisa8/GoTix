@extends('layouts.main')

@section('content')

{{-- CSS: Smooth Scroll --}}
<style>
    html { scroll-behavior: smooth; }
</style>

<section class="relative bg-center bg-no-repeat bg-cover min-h-[85vh] flex flex-col items-center justify-center mb-12" 
    style="background-image: url('https://www.zetizen.com/_next/image?url=https%3A%2F%2Fcdn-zetizen.jawapos.com%2Fnew-zetizen%2Fpublic%2Fmedia%2FCoachella_venue.jpg&w=1200&q=75');">
    
    <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/60 to-black/40"></div>
    
    <div class="relative z-10 text-center max-w-4xl px-4 w-full mt-10">
        <h1 class="mb-4 text-5xl font-extrabold tracking-tight leading-tight text-white md:text-7xl drop-shadow-2xl">
            Rasakan Detak <br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 via-pink-500 to-red-500 animate-pulse">Musik</span> Hidupmu
        </h1>
        <p class="mb-10 text-lg font-light text-gray-200 lg:text-2xl drop-shadow-md">
            Platform tiket konser terbesar & terpercaya.
        </p>
        
        {{-- Saat cari, dia akan scroll ke bawah (#katalog-event) --}}
        <form action="{{ route('home') }}#katalog-event" method="GET" class="bg-slate-900/60 backdrop-blur-md p-2 rounded-full border border-white/20 shadow-2xl flex flex-col md:flex-row gap-2 max-w-3xl mx-auto transition hover:bg-slate-900/80">
            
            <div class="relative flex-1">
                <div class="absolute inset-y-0 start-0 flex items-center ps-4 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
                <input type="search" name="search" value="{{ request('search') }}" class="block w-full p-4 ps-12 text-white bg-transparent border-none focus:ring-0 placeholder-gray-300" placeholder="Cari artis atau konser..." />
            </div>

            <div class="w-full md:w-48 border-l border-gray-600 hidden md:block">
                <select name="category" class="bg-transparent border-none text-white text-sm focus:ring-0 block w-full p-4 cursor-pointer [&>option]:bg-slate-800">
                    <option value="All">Semua Genre</option>
                    <option value="Pop" {{ request('category') == 'Pop' ? 'selected' : '' }}>Pop</option>
                    <option value="Rock" {{ request('category') == 'Rock' ? 'selected' : '' }}>Rock</option>
                    <option value="Jazz" {{ request('category') == 'Jazz' ? 'selected' : '' }}>Jazz</option>
                    <option value="EDM" {{ request('category') == 'EDM' ? 'selected' : '' }}>EDM</option>
                    <option value="Indie" {{ request('category') == 'Indie' ? 'selected' : '' }}>Indie</option>
                </select>
            </div>

            <button type="submit" class="text-white bg-gradient-to-r from-purple-600 to-pink-600 hover:bg-gradient-to-l focus:ring-4 focus:outline-none focus:ring-purple-800 font-bold rounded-full text-sm px-8 py-3 transition transform hover:scale-105 shadow-lg">
                Cari
            </button>
        </form>
    </div>

    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce z-10">
        <a href="#katalog-event" class="text-white/70 hover:text-white transition flex flex-col items-center gap-2 cursor-pointer">
            <span class="text-xs uppercase tracking-widest font-light">Scroll Down</span>
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
        </a>
    </div>
</section>

<section id="katalog-event" class="max-w-screen-xl mx-auto px-4 pb-20 pt-10">
    
    <div class="flex flex-col md:flex-row justify-between items-end mb-10 border-b border-slate-800 pb-4">
        <div>
            <h2 class="text-3xl font-bold text-white flex items-center gap-2">
                🔥 Upcoming Events
            </h2>
            <p class="text-slate-400 mt-2">Daftar konser terbaik minggu ini.</p>
        </div>
        
        @if(request('search') || request('category'))
            <div class="mt-4 md:mt-0 flex items-center gap-2">
                <span class="text-sm text-slate-400">Filter aktif: </span>
                
                {{-- PERBAIKAN: Hapus #katalog-event agar kembali ke atas --}}
                <a href="{{ route('home') }}" class="text-sm text-red-400 hover:text-red-300 border border-red-900/50 bg-red-900/10 px-3 py-1 rounded-lg transition">
                    Reset Filter ✕
                </a>
            </div>
        @endif
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($events as $event)
        <div class="bg-slate-800 rounded-2xl overflow-hidden border border-slate-700 shadow-lg hover:shadow-purple-500/20 hover:-translate-y-2 transition-all duration-300 group flex flex-col h-full">
            
            <div class="relative h-56 overflow-hidden flex-shrink-0">
                <img class="w-full h-full object-cover group-hover:scale-110 transition duration-500" src="{{ $event->image ? asset('storage/' . $event->image) : 'https://placehold.co/600x400/1e293b/FFF?text=No+Image' }}" alt="{{ $event->name }}">
                <span class="absolute top-3 right-3 bg-purple-600/90 backdrop-blur text-white text-xs font-bold px-2 py-1 rounded-md uppercase shadow-lg">
                    {{ $event->category }}
                </span>
            </div>
            
            <div class="p-6 flex flex-col flex-1 relative">
                <a href="{{ route('event.detail', $event->id) }}" class="mb-auto">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-white group-hover:text-purple-400 transition line-clamp-2">
                        {{ $event->name }}
                    </h5>
                </a>
                
                <div class="mt-4 space-y-2">
                    <div class="flex items-center text-slate-400 text-sm">
                        <svg class="w-4 h-4 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>{{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }} • {{ \Carbon\Carbon::parse($event->event_time)->format('H:i') }}</span>
                    </div>
                    <div class="flex items-center text-slate-400 text-sm">
                        <svg class="w-4 h-4 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <span class="truncate">{{ $event->location }}</span>
                    </div>
                </div>
                
                <div class="border-t border-slate-700 my-4"></div>

                <a href="{{ route('event.detail', $event->id) }}" class="flex justify-between items-center w-full px-4 py-3 text-sm font-bold text-center text-white bg-slate-700 rounded-xl hover:bg-gradient-to-r hover:from-purple-600 hover:to-pink-600 transition-all group-hover:shadow-lg">
                    <span>Beli Tiket</span>
                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>
        </div>
        @empty
        <div class="col-span-1 md:col-span-3 text-center py-20 bg-slate-800/50 rounded-3xl border border-slate-700 border-dashed">
            <div class="text-6xl mb-4 grayscale opacity-50">🎸</div>
            <h3 class="text-2xl font-bold text-white mb-2">Belum ada event ditemukan</h3>
            <p class="text-slate-400">Coba cari dengan kata kunci lain atau ubah filter kategori.</p>
            
            {{-- PERBAIKAN: Hapus #katalog-event agar kembali ke atas --}}
            <a href="{{ route('home') }}" class="text-purple-400 hover:text-purple-300 hover:underline mt-4 inline-block font-medium">
                Reset Pencarian
            </a>
        </div>
        @endforelse
    </div>
</section>

@endsection