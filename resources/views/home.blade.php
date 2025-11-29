@extends('layouts.main')

@section('content')

<section class="relative bg-center bg-no-repeat bg-cover h-[500px] flex items-center justify-center mb-12" style="background-image: url('https://images.unsplash.com/photo-1470225620780-dba8ba36b745?q=80&w=2070&auto=format&fit=crop');">
    <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/80 to-transparent"></div>
    
    <div class="relative z-10 text-center max-w-4xl px-4 w-full">
        <h1 class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-white md:text-6xl">
            Cari <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-600">Konser</span> Impianmu
        </h1>
        <p class="mb-8 text-lg font-normal text-gray-300 lg:text-xl">
            Temukan ribuan event musik seru di GoTix. Pesan tiketmu sekarang!
        </p>
        
        <form action="{{ route('home') }}" method="GET" class="bg-slate-800/80 backdrop-blur-md p-4 rounded-2xl border border-slate-700 shadow-2xl flex flex-col md:flex-row gap-4">
            
            <div class="relative flex-1">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
                <input type="search" name="search" value="{{ request('search') }}" class="block w-full p-4 ps-10 text-sm text-white border border-slate-600 rounded-xl bg-slate-900 focus:ring-purple-500 focus:border-purple-500 placeholder-gray-400" placeholder="Cari artis, band, atau lokasi..." />
            </div>

            <div class="w-full md:w-48">
                <select name="category" class="bg-slate-900 border border-slate-600 text-white text-sm rounded-xl focus:ring-purple-500 focus:border-purple-500 block w-full p-4">
                    <option value="All">Semua Genre</option>
                    <option value="Pop" {{ request('category') == 'Pop' ? 'selected' : '' }}>Pop</option>
                    <option value="Rock" {{ request('category') == 'Rock' ? 'selected' : '' }}>Rock</option>
                    <option value="Jazz" {{ request('category') == 'Jazz' ? 'selected' : '' }}>Jazz</option>
                    <option value="EDM" {{ request('category') == 'EDM' ? 'selected' : '' }}>EDM</option>
                    <option value="Indie" {{ request('category') == 'Indie' ? 'selected' : '' }}>Indie</option>
                </select>
            </div>

            <button type="submit" class="text-white bg-gradient-to-r from-purple-600 to-pink-600 hover:bg-gradient-to-l focus:ring-4 focus:outline-none focus:ring-purple-800 font-bold rounded-xl text-sm px-8 py-4">
                Cari
            </button>
        </form>
    </div>
</section>

<section class="max-w-screen-xl mx-auto px-4 pb-20">
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-2xl font-bold text-white flex items-center">
            🔥 Event Terbaru 
            @if(request('search') || (request('category') && request('category') !== 'All'))
                <span class="ml-2 text-sm font-normal text-slate-400">
                    (Hasil pencarian: "{{ request('search') ?? request('category') }}")
                </span>
            @endif
        </h2>
        
        @if(request('search') || request('category'))
            <a href="{{ route('home') }}" class="text-sm text-red-400 hover:text-red-300">Reset Filter ✕</a>
        @endif
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($events as $event)
        <div class="bg-slate-800 rounded-2xl overflow-hidden border border-slate-700 shadow-lg hover:scale-105 transition-transform duration-300 group">
            <div class="relative h-48 overflow-hidden">
                <img class="w-full h-full object-cover group-hover:opacity-80 transition" src="{{ $event->image ? asset('storage/' . $event->image) : 'https://placehold.co/600x400/1e293b/FFF?text=No+Image' }}" alt="{{ $event->name }}">
                <span class="absolute top-3 right-3 bg-purple-600/90 backdrop-blur text-white text-xs font-bold px-2 py-1 rounded-md uppercase">
                    {{ $event->category }}
                </span>
            </div>
            
            <div class="p-5">
                <div class="text-purple-400 text-xs font-bold uppercase mb-2 flex items-center">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}
                </div>

                <a href="{{ route('event.detail', $event->id) }}">
                    <h5 class="mb-2 text-xl font-bold tracking-tight text-white group-hover:text-purple-400 transition truncate">{{ $event->name }}</h5>
                </a>
                
                <div class="flex items-center text-slate-400 text-sm mb-4">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <span class="truncate">{{ $event->location }}</span>
                </div>
                
                <a href="{{ route('event.detail', $event->id) }}" class="inline-flex justify-center items-center w-full px-3 py-2 text-sm font-medium text-center text-white bg-slate-700 rounded-lg hover:bg-slate-600 transition">
                    Lihat Detail
                </a>
            </div>
        </div>
        @empty
        <div class="col-span-1 md:col-span-3 text-center py-16">
            <div class="text-6xl mb-4">🔍</div>
            <h3 class="text-xl font-bold text-white">Event tidak ditemukan</h3>
            <p class="text-slate-400">Coba cari dengan kata kunci lain atau ubah filter kategori.</p>
            <a href="{{ route('home') }}" class="text-purple-400 hover:underline mt-2 inline-block">Lihat Semua Event</a>
        </div>
        @endforelse
    </div>
</section>

@endsection