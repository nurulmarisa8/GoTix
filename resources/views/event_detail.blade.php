@extends('layouts.main')

@section('content')

<div class="w-full h-64 bg-slate-800 overflow-hidden relative">
    <img src="{{ $event->image ? asset('storage/' . $event->image) : 'https://placehold.co/1200x400/1e293b/FFF?text=Event' }}" class="w-full h-full object-cover opacity-50 blur-sm absolute">
    <div class="absolute inset-0 bg-gradient-to-t from-slate-900 to-transparent"></div>
</div>

<div class="max-w-screen-xl mx-auto px-4 -mt-32 relative z-10">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-1">
            <div class="bg-slate-800 rounded-2xl p-2 shadow-2xl border border-slate-700">
                <img class="w-full rounded-xl" src="{{ $event->image ? asset('storage/' . $event->image) : 'https://placehold.co/600x800/1e293b/FFF?text=Poster' }}" alt="{{ $event->name }}">
            </div>
            
            <div class="mt-6 bg-slate-800 rounded-2xl p-6 border border-slate-700">
                <h3 class="text-lg font-bold text-white mb-4">Detail Lokasi</h3>
                
                <div class="flex items-start text-slate-300 mb-4">
                    <svg class="w-5 h-5 mr-3 text-purple-500 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <span class="leading-relaxed">{{ $event->location }}</span>
                </div>

                <div class="flex items-start text-slate-300">
                    <svg class="w-5 h-5 mr-3 text-purple-500 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <div class="flex flex-col">
                        <span class="font-bold text-white">
                            {{ \Carbon\Carbon::parse($event->event_date)->format('l, d F Y') }}
                        </span>
                        <span class="text-sm text-purple-400 mt-1">
                            Pukul {{ \Carbon\Carbon::parse($event->event_time)->format('H:i') }} WIB
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-6">
            <div>
                <span class="bg-pink-600 text-white text-xs font-bold px-3 py-1 rounded-full uppercase mb-2 inline-block">{{ $event->category }}</span>
                <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-4 leading-tight">{{ $event->name }}</h1>
                <div class="prose prose-invert max-w-none text-slate-300">
                    <p>{{ $event->description }}</p>
                </div>
            </div>

            <div class="bg-slate-800 rounded-2xl p-6 border border-slate-700">
                <h3 class="text-2xl font-bold text-white mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                    Pilih Tiket
                </h3>

                <div class="space-y-4">
                    @foreach($event->tickets as $ticket)
                    <div class="flex flex-col md:flex-row justify-between items-center bg-slate-900/50 p-4 rounded-xl border border-slate-700 hover:border-purple-500 transition-colors">
                        
                        <div class="mb-4 md:mb-0 w-full md:w-auto">
                            <h4 class="text-lg font-bold text-white">{{ $ticket->name }}</h4>
                            <p class="text-sm text-slate-400 max-w-xs">{{ $ticket->description }}</p>
                            <span class="text-xs text-slate-500 mt-1 block">
                                Sisa Kuota: <span class="text-white font-bold">{{ $ticket->quota }}</span>
                            </span>
                        </div>
                        
                        <div class="flex items-center gap-4 w-full md:w-auto justify-between md:justify-end">
                            <div class="text-right mr-2">
                                <span class="block text-xl font-bold text-purple-400 whitespace-nowrap">
                                    Rp {{ number_format($ticket->price, 0, ',', '.') }}
                                </span>
                            </div>

                            {{-- CEK ROLE USER --}}
                            @if($ticket->quota > 0)
                                @auth
                                    @if(Auth::user()->role === 'user')
                                        {{-- 1. USER BIASA: Form Beli --}}
                                        <form action="{{ route('booking.store') }}" method="POST" class="flex items-center gap-2">
                                            @csrf
                                            <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                                            <input type="number" name="quantity" value="1" min="1" max="5" class="w-16 bg-slate-800 border border-slate-600 text-white text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block p-2.5 text-center" required>
                                            <button type="submit" class="text-white bg-gradient-to-r from-purple-600 to-pink-600 hover:bg-gradient-to-l font-bold rounded-lg text-sm px-5 py-2.5 text-center shadow-lg shadow-purple-500/30 hover:scale-105 transition">
                                                Beli
                                            </button>
                                        </form>
                                    @else
                                        {{-- 2. ADMIN/ORGANIZER: Tombol Mati --}}
                                        <button disabled class="text-slate-500 bg-slate-800 border border-slate-600 font-medium rounded-lg text-xs px-4 py-2 cursor-not-allowed opacity-75 whitespace-nowrap">
                                            Mode {{ ucfirst(Auth::user()->role) }}
                                        </button>
                                    @endif
                                @else
                                    {{-- 3. GUEST: Tombol Login --}}
                                    <a href="{{ route('login') }}" class="text-white bg-slate-700 hover:bg-slate-600 font-medium rounded-lg text-sm px-5 py-2.5 transition whitespace-nowrap">
                                        Login Beli
                                    </a>
                                @endauth
                            @else
                                {{-- 4. SOLD OUT --}}
                                <button disabled class="text-white bg-gray-600 cursor-not-allowed font-medium rounded-lg text-sm px-5 py-2.5 whitespace-nowrap">
                                    Sold Out
                                </button>
                            @endif

                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        
    </div>
</div>

@endsection