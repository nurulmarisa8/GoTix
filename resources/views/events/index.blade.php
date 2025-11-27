@extends('layouts.app')
@section('title', 'Events')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Events</h1>
                <p class="text-gray-600 mt-2">Discover amazing events happening around you</p>
            </div>
            <div class="text-sm text-gray-500">{{ number_format($events->total()) }} events</div>
        </div>
    </div>

    <div class="mb-6 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <form action="{{ route('events.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-3 items-center">
            <div class="md:col-span-7">
                <label for="search" class="sr-only">Search events</label>
                <div class="relative">
                    <input id="search" name="search" type="text"
                           class="w-full pl-11 pr-4 py-3 border border-gray-200 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                           placeholder="Search events by name, description or location" value="{{ request('search') }}">
                    <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="md:col-span-3">
                <label for="sort" class="sr-only">Sort</label>
                <select id="sort" name="sort" onchange="this.form.submit()"
                        class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Sort by</option>
                    <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Newest</option>
                    <option value="popular" {{ request('sort') === 'popular' ? 'selected' : '' }}>Popular</option>
                </select>
            </div>

            <div class="md:col-span-2 flex gap-2">
                <button type="submit"
                        class="w-full px-4 py-3 text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Search
                </button>
                <a href="{{ route('events.index') }}" class="w-full inline-flex items-center justify-center px-4 py-3 text-sm rounded-lg border border-gray-200 text-gray-600 hover:bg-gray-50">Reset</a>
            </div>
        </form>
    </div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    @forelse($events as $event)
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow duration-200 relative flex flex-col">
        @if($event->image_url)
            <img src="{{ asset('storage/' . $event->image_url) }}"
                 class="w-full h-48 object-cover"
                 alt="{{ $event->name }}">
        @else
            <div class="w-full h-48 bg-gray-100 flex items-center justify-center text-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V7M8 7V5a4 4 0 118 0v2" />
                </svg>
            </div>
        @endif
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $event->name }}</h3>
            <p class="text-gray-600 text-sm mb-4">{{ Str::limit($event->description, 100) }}</p>
            <div class="space-y-1 mb-4 text-sm text-gray-600">
                <div class="flex items-center text-sm text-gray-600">
                    <span class="mr-2">📍</span>
                    <span>{{ $event->location }}</span>
                </div>
                <div class="flex items-center text-sm text-gray-600">
                    <span class="mr-2">📅</span>
                    <span>{{ $event->event_date->format('d M Y H:i') }}</span>
                </div>
            </div>
            <div class="mt-auto flex gap-3">
                <a href="{{ route('events.show', $event) }}"
                   class="flex-1 inline-flex items-center justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">View Details</a>
                @if(isset($event->tickets) && $event->tickets->count() > 0)
                    <a href="{{ route('events.show', $event) }}#tickets" class="inline-flex items-center justify-center py-2 px-3 border border-gray-200 rounded-md text-sm text-gray-700 bg-white hover:bg-gray-50">Buy</a>
                @endif
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-full">
        @include('components.empty-state')
    </div>
    @endforelse
</div>

<div class="flex justify-center">
    {{ $events->links() }}
</div>
@endsection