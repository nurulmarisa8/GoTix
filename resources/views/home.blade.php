@extends('layouts.main')

@section('content')

<section class="relative bg-center bg-no-repeat bg-cover h-[500px] flex items-center justify-center" style="background-image: url('https://images.unsplash.com/photo-1459749411177-0473ef71607b?q=80&w=2070&auto=format&fit=crop');">
    <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/60 to-transparent"></div>
    <div class="relative z-10 text-center max-w-3xl px-4">
        <h1 class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-white md:text-6xl">
            Rasakan Detak <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-600">Musik</span>
        </h1>
        <p class="mb-8 text-lg font-normal text-gray-300 lg:text-xl sm:px-16 lg:px-48">
            Temukan konser, festival, dan gigs terpanas di sekitarmu. Booking tiket sekarang sebelum kehabisan!
        </p>
        
        <form action="{{ route('home') }}" method="GET" class="max-w-md mx-auto">   
            <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
                <input type="search" name="search" class="block w-full p-4 ps-10 text-sm border rounded-full bg-slate-800/80 border-slate-600 placeholder-gray-400 text-white focus:ring-purple-500 focus:border-purple-500 backdrop-blur-sm" placeholder="Cari artis, lokasi, atau genre..." required />
                <button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-full text-sm px-4 py-2">Search</button>
            </div>
        </form>
    </div>
</section>

<section class="max-w-screen-xl mx-auto px-4 py-12">
    <div class="flex justify-between items-end mb-8">
        <h2 class="text-3xl font-bold text-white">🔥 Upcoming Events</h2>
        <a href="#" class="text-purple-400 hover:text-purple-300 text-sm">Lihat Semua &rarr;</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($events as $event)
        <div class="max-w-sm bg-slate-800 border border-slate-700 rounded-2xl shadow-lg overflow-hidden hover:scale-105 transition-transform duration-300 group">
            <div class="relative">
                <img class="w-full h-48 object-cover group-hover:opacity-80 transition" src="{{ $event->image ? asset('storage/' . $event->image) : 'https://placehold.co/600x400/1e293b/FFF?text=No+Image' }}" alt="{{ $event->name }}" />
                
                <span class="absolute top-3 right-3 bg-pink-600 text-white text-xs font-bold px-2 py-1 rounded-md uppercase tracking-wide">
                    {{ $event->category }}
                </span>
            </div>
            
            <div class="p-5">
                <div class="text-purple-400 text-xs font-semibold uppercase tracking-wider mb-2">
                    {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }} • {{ \Carbon\Carbon::parse($event->event_time)->format('H:i') }}
                </div>

                <a href="{{ route('event.detail', $event->id) }}">
                    <h5 class="mb-2 text-xl font-bold tracking-tight text-white group-hover:text-purple-400 transition">{{ $event->name }}</h5>
                </a>
                
                <p class="mb-4 font-normal text-gray-400 text-sm line-clamp-2">
                    {{ Str::limit($event->description, 100) }}
                </p>
                
                <div class="flex items-center justify-between mt-4 border-t border-slate-700 pt-4">
                    <div class="flex items-center text-gray-400 text-sm">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        {{ $event->location }}
                    </div>
                    <a href="{{ route('event.detail', $event->id) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-slate-700 rounded-lg hover:bg-slate-600 focus:ring-4 focus:outline-none focus:ring-slate-800">
                        Detail
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-3 text-center py-12">
            <p class="text-gray-500 text-xl">Belum ada konser yang tersedia saat ini.</p>
        </div>
        @endforelse
    </div>
</section>

@endsection