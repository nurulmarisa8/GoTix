@extends('layouts.guest')

@section('content')
    <div class="relative overflow-hidden">
        <!-- Hero Section -->
        <div class="event-detail__hero">
            <div class="event-detail__container">
                <div class="text-center py-16">
                    <h1 class="text-4xl md:text-6xl font-bold text-black mb-6">Find Your Perfect Event</h1>
                    <p class="text-xl text-black mb-8 max-w-2xl mx-auto">Discover and book tickets for the best events happening around you. From concerts to conferences, we've got you covered.</p>
                    <div class="flex flex-col sm:flex-row justify-center gap-4">
                        <a href="{{ route('events.index') }}" class="btn-primary text-lg py-3 px-8">Browse Events</a>
                        <a href="{{ route('register') }}" class="btn-outline text-lg py-3 px-8">Join Now</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search and Filter Section -->
        <div class="-mt-16 z-10 relative">
            <div class="max-w-6xl mx-auto bg-white rounded-xl shadow-lg p-6 mb-12">
                <div class="filter-controls">
                    <div class="filter-controls__search">
                        <label class="filter-controls__label">Search Events</label>
                        <div class="relative">
                            <input type="text" placeholder="Search by name, location, or category..." class="form-input pl-10">
                            <div class="absolute left-3 top-3.5 text-gray-400">
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
        </div>

        <!-- Featured Events Section -->
        <div class="py-12 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Featured Events</h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">Discover the most popular and upcoming events that you won't want to miss.</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @for ($i = 0; $i < 6; $i++)
                        <div class="event-card">
                            <img src="https://via.placeholder.com/400x200" alt="Event" class="event-card__image">
                            <div class="event-card__content">
                                <h3 class="event-card__title">Musik Jawa Heritage Festival</h3>
                                <div class="event-card__date flex items-center mb-2">
                                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    Nov 25, 2025 19:00
                                </div>
                                <div class="event-card__location flex items-center mb-3">
                                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Jakarta Convention Center
                                </div>
                                <p class="event-card__description">Experience the rich cultural heritage of Javanese music with traditional instruments and performances.</p>
                                <div class="event-card__footer">
                                    <span class="event-card__price">From Rp 150.000</span>
                                    <a href="#" class="btn-primary text-sm py-2 px-4">View Details</a>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
                
                <div class="text-center mt-12">
                    <a href="{{ route('events.index') }}" class="btn-outline">View All Events</a>
                </div>
            </div>
        </div>

        <!-- How It Works Section -->
        <div class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">How It Works</h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">Booking your tickets is simple and secure with our platform.</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-2xl font-bold text-blue-600">1</span>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Browse Events</h3>
                        <p class="text-gray-600">Explore our collection of events and find the perfect one for you.</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-2xl font-bold text-blue-600">2</span>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Select Tickets</h3>
                        <p class="text-gray-600">Choose your preferred ticket type and quantity.</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-2xl font-bold text-blue-600">3</span>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Get Tickets</h3>
                        <p class="text-gray-600">Receive your e-ticket instantly via email or in your account.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Testimonials Section -->
        <div class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">What Our Users Say</h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">Hear from our satisfied customers about their experience with GoTix.</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="bg-white p-6 rounded-xl shadow-md">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-gray-200 rounded-full mr-4"></div>
                            <div>
                                <h4 class="font-semibold">Budi Santoso</h4>
                                <div class="flex text-yellow-400">
                                    ★★★★★
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-600">"The booking process was so smooth and the customer service was excellent. Great experience!"</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-md">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-gray-200 rounded-full mr-4"></div>
                            <div>
                                <h4 class="font-semibold">Siti Aminah</h4>
                                <div class="flex text-yellow-400">
                                    ★★★★★
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-600">"Found exactly the event I was looking for. The mobile app made it easy to book from anywhere."</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-md">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-gray-200 rounded-full mr-4"></div>
                            <div>
                                <h4 class="font-semibold">Ahmad Fauzi</h4>
                                <div class="flex text-yellow-400">
                                    ★★★★☆
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-600">"Great platform with lots of options. The e-tickets saved me from long queues at the venue."</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection