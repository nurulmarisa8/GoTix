@extends('layouts.guest')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="text-center mb-12">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">All Events</h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">Discover and book tickets for all the amazing events happening near you.</p>
        </div>

        <!-- Filter Controls -->
        <div class="filter-controls mb-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="filter-controls__group">
                    <label class="filter-controls__label">Search</label>
                    <div class="relative">
                        <input type="text" placeholder="Search events..." class="filter-controls__select pl-10">
                        <div class="absolute left-3 top-2.5 text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="filter-controls__group">
                    <label class="filter-controls__label">Location</label>
                    <select class="filter-controls__select">
                        <option value="">All Locations</option>
                        <option value="jakarta">Jakarta</option>
                        <option value="bandung">Bandung</option>
                        <option value="surabaya">Surabaya</option>
                        <option value="yogyakarta">Yogyakarta</option>
                    </select>
                </div>
                <div class="filter-controls__group">
                    <label class="filter-controls__label">Date</label>
                    <select class="filter-controls__select">
                        <option value="">All Dates</option>
                        <option value="today">Today</option>
                        <option value="this-week">This Week</option>
                        <option value="this-month">This Month</option>
                    </select>
                </div>
                <div class="filter-controls__group">
                    <label class="filter-controls__label">Category</label>
                    <select class="filter-controls__select">
                        <option value="">All Categories</option>
                        <option value="music">Music</option>
                        <option value="conference">Conference</option>
                        <option value="workshop">Workshop</option>
                        <option value="expo">Expo</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Events Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @for ($i = 0; $i < 9; $i++)
                <x-event-card :event="[
                    'id' => $i+1,
                    'name' => 'Concert Musik Indonesia Raya ' . ($i+1),
                    'date_time' => now()->addDays($i+5),
                    'location' => 'Jakarta Convention Center',
                    'description' => 'Experience the vibrant culture of Indonesia with this amazing music concert featuring top artists.',
                    'tickets' => collect([[ 'name' => 'Regular', 'price' => 150000 + ($i * 50000) ]]),
                    'image' => null
                ]" />
            @endfor
        </div>

        <!-- Pagination -->
        <div class="mt-12 flex justify-center">
            <nav class="flex items-center space-x-2">
                <a href="#" class="px-3 py-2 rounded-md bg-blue-600 text-white">1</a>
                <a href="#" class="px-3 py-2 rounded-md hover:bg-gray-100">2</a>
                <a href="#" class="px-3 py-2 rounded-md hover:bg-gray-100">3</a>
                <span class="px-3 py-2">...</span>
                <a href="#" class="px-3 py-2 rounded-md hover:bg-gray-100">10</a>
                <a href="#" class="px-3 py-2 rounded-md hover:bg-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </nav>
        </div>
    </div>
@endsection