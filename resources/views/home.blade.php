@extends('layouts.main')

@section('content')

{{-- CSS: Smooth Scroll --}}
<style>
    html { scroll-behavior: smooth; }
</style>

<section class="relative bg-center bg-no-repeat bg-cover min-h-screen flex flex-col items-center justify-center" 
    style="background-image: url('https://www.zetizen.com/_next/image?url=https%3A%2F%2Fcdn-zetizen.jawapos.com%2Fnew-zetizen%2Fpublic%2Fmedia%2FCoachella_venue.jpg&w=1200&q=75');">
    
    <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/60 to-black/40"></div>
    
    <div class="relative z-10 text-center max-w-5xl px-6 w-full pt-10">
        <h1 class="mb-6 text-4xl font-extrabold tracking-tight leading-tight text-white md:text-7xl drop-shadow-2xl">
            Rasakan Detak <br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 via-pink-500 to-red-500 animate-pulse">Musik</span> Hidupmu
        </h1>
        
        <p class="mb-10 text-base font-light text-gray-200 md:text-2xl drop-shadow-md px-4">
            Platform tiket konser terbesar & terpercaya.
        </p>
        
        {{-- Mobile: Rounded kotak (2xl), Padding besar (p-4), Stack vertikal (flex-col) --}}
        {{-- Desktop: Rounded lonjong (full), Padding kecil (p-2), Baris horizontal (md:flex-row) --}}
        <form action="{{ route('home') }}#katalog-event" method="GET" class="bg-slate-900/80 backdrop-blur-md border border-white/20 shadow-2xl flex flex-col md:flex-row gap-4 max-w-4xl mx-auto transition hover:bg-slate-900/90 rounded-3xl p-6 md:rounded-full md:p-2">
            
            <div class="relative flex-1 w-full">
                <div class="absolute inset-y-0 start-0 flex items-center ps-4 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
                <input type="search" name="search" value="{{ request('search') }}" class="block w-full p-4 ps-12 text-white bg-slate-800/50 md:bg-transparent border border-slate-600 md:border-none rounded-xl md:rounded-none focus:ring-purple-500 focus:border-purple-500 placeholder-gray-400" placeholder="Cari artis..." />
            </div>

            <div class="hidden md:block w-[1px] bg-gray-600 my-2"></div>

            <div class="w-full md:w-48">
                <select name="category" class="w-full p-4 text-sm text-white bg-slate-800/50 md:bg-transparent border border-slate-600 md:border-none rounded-xl md:rounded-none focus:ring-purple-500 cursor-pointer [&>option]:bg-slate-900">
                    <option value="All">Semua Genre</option>
                    <option value="Pop" {{ request('category') == 'Pop' ? 'selected' : '' }}>Pop</option>
                    <option value="Rock" {{ request('category') == 'Rock' ? 'selected' : '' }}>Rock</option>
                    <option value="Jazz" {{ request('category') == 'Jazz' ? 'selected' : '' }}>Jazz</option>
                    <option value="EDM" {{ request('category') == 'EDM' ? 'selected' : '' }}>EDM</option>
                    <option value="Indie" {{ request('category') == 'Indie' ? 'selected' : '' }}>Indie</option>
                </select>
            </div>

            <button type="submit" class="w-full md:w-auto text-white bg-gradient-to-r from-purple-600 to-pink-600 hover:bg-gradient-to-l focus:ring-4 focus:outline-none focus:ring-purple-800 font-bold rounded-xl md:rounded-full text-base px-8 py-3 md:py-3 transition transform hover:scale-105 shadow-lg">
                Cari
            </button>
        </form>
    </div>

    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce z-10 hidden md:block">
        <a href="#katalog-event" class="text-white/70 hover:text-white transition flex flex-col items-center gap-2 cursor-pointer">
            <span class="text-xs uppercase tracking-widest font-light">Scroll Down</span>
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
        </a>
    </div>
</section>

@if(Auth::check() && $favorites->count() > 0)
<section id="section-favorit" class="max-w-screen-xl mx-auto px-4 pt-10 pb-10">
    <div class="mb-8 border-b border-pink-900/50 pb-4">
        <h2 class="text-2xl md:text-3xl font-bold text-white flex items-center gap-2">
            ❤️ Favorit Saya
        </h2>
        <p class="text-slate-400 mt-2 text-sm md:text-base">Event yang sudah kamu tandai.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
        @foreach($favorites as $event)
            <div class="bg-slate-900 rounded-2xl overflow-hidden border-2 border-pink-600 shadow-[0_0_20px_rgba(219,39,119,0.3)] hover:-translate-y-2 transition-all duration-300 group flex flex-col h-full relative">
                <div class="relative h-48 md:h-56 overflow-hidden flex-shrink-0">
                    <img class="w-full h-full object-cover group-hover:scale-110 transition duration-500" src="{{ $event->image ? asset('storage/' . $event->image) : 'https://placehold.co/600x400/1e293b/FFF?text=No+Image' }}" alt="{{ $event->name }}">
                    <span class="absolute top-3 left-3 bg-pink-600 text-white text-[10px] font-bold px-2 py-1 rounded-full uppercase shadow-lg flex items-center gap-1">
                        <svg class="w-3 h-3 fill-current" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg> Tersimpan
                    </span>
                    <div class="absolute top-3 right-3 z-10">
                        <form action="{{ route('event.favorite', $event->id) }}#section-favorit" method="POST">
                            @csrf
                            <button type="submit" class="p-2 rounded-full bg-pink-600 text-white shadow-lg hover:bg-red-600 transition">
                                <svg class="w-5 h-5 fill-current" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="p-5 flex flex-col flex-1 relative bg-gradient-to-b from-slate-900 to-slate-800">
                    <a href="{{ route('event.detail', $event->id) }}" class="mb-auto">
                        <h5 class="mb-2 text-xl font-bold text-white group-hover:text-pink-400 transition line-clamp-2">{{ $event->name }}</h5>
                    </a>
                    <div class="mt-4 space-y-2 text-sm text-slate-400">
                        <div class="flex items-center"><svg class="w-4 h-4 mr-2 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}</div>
                    </div>
                    <div class="border-t border-slate-700 my-4"></div>
                    <a href="{{ route('event.detail', $event->id) }}" class="w-full block py-2 text-center text-sm font-bold text-white bg-slate-700 rounded-lg hover:bg-pink-600 transition">Beli Tiket</a>
                </div>
            </div>
        @endforeach
    </div>
</section>
@endif

<section id="katalog-event" class="max-w-screen-xl mx-auto px-4 pb-20 pt-10">
    <div class="flex flex-col md:flex-row justify-between items-end mb-10 border-b border-slate-800 pb-4">
        <div>
            <h2 class="text-2xl md:text-3xl font-bold text-white flex items-center gap-2">🔥 Upcoming Events</h2>
            <p class="text-slate-400 mt-2 text-sm md:text-base">Daftar konser terbaik minggu ini.</p>
        </div>
        @if(request('search') || request('category'))
            <div class="mt-4 md:mt-0">
                <span class="text-sm text-slate-400 mr-2">Filter aktif:</span>
                <a href="{{ route('home') }}" class="text-sm text-red-400 hover:text-red-300 border border-red-900/50 bg-red-900/10 px-3 py-1 rounded-lg transition">Reset Filter ✕</a>
            </div>
        @endif
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
        @forelse($events as $event)
        <div class="bg-slate-800 rounded-2xl overflow-hidden border border-slate-700 shadow-lg hover:shadow-purple-500/20 hover:-translate-y-2 transition-all duration-300 group flex flex-col h-full">
            <div class="relative h-48 md:h-56 overflow-hidden flex-shrink-0">
                <img class="w-full h-full object-cover group-hover:scale-110 transition duration-500" src="{{ $event->image ? asset('storage/' . $event->image) : 'https://placehold.co/600x400/1e293b/FFF?text=No+Image' }}" alt="{{ $event->name }}">
                <span class="absolute top-3 left-3 bg-slate-900/80 backdrop-blur text-white text-xs font-bold px-2 py-1 rounded-md uppercase shadow-lg border border-white/10">{{ $event->category }}</span>
                <div class="absolute top-3 right-3 z-10">
                    @auth
                        <form action="{{ route('event.favorite', $event->id) }}#section-favorit" method="POST">
                            @csrf
                            <button type="submit" class="p-2 rounded-full bg-white/20 backdrop-blur text-white hover:bg-pink-600 shadow-lg transition transform hover:scale-110">
                                <svg class="w-5 h-5 fill-none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="block p-2 rounded-full bg-white/20 backdrop-blur text-white hover:bg-pink-600 shadow-lg transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        </a>
                    @endauth
                </div>
            </div>
            <div class="p-5 flex flex-col flex-1 relative">
                <a href="{{ route('event.detail', $event->id) }}" class="mb-auto">
                    <h5 class="mb-2 text-xl font-bold tracking-tight text-white group-hover:text-purple-400 transition line-clamp-2">{{ $event->name }}</h5>
                </a>
                <div class="mt-4 space-y-2 text-sm text-slate-400">
                    <div class="flex items-center"><svg class="w-4 h-4 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }} • {{ \Carbon\Carbon::parse($event->event_time)->format('H:i') }}</div>
                    <div class="flex items-center"><svg class="w-4 h-4 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg> <span class="truncate">{{ $event->location }}</span></div>
                </div>
                <div class="border-t border-slate-700 my-4"></div>
                <a href="{{ route('event.detail', $event->id) }}" class="w-full block py-2 text-center text-sm font-bold text-white bg-slate-700 rounded-lg hover:bg-purple-600 transition">Beli Tiket</a>
            </div>
        </div>
        @empty
        <div class="col-span-1 md:col-span-3 text-center py-20 bg-slate-800/50 rounded-3xl border border-slate-700 border-dashed">
            <div class="text-6xl mb-4 grayscale opacity-50">🎸</div>
            <h3 class="text-2xl font-bold text-white mb-2">Belum ada event</h3>
            <p class="text-slate-400">Coba cari dengan kata kunci lain.</p>
            <a href="{{ route('home') }}" class="text-purple-400 hover:underline mt-4 inline-block font-medium">Reset Pencarian</a>
        </div>
        @endforelse
    </div>
</section>

@endsection