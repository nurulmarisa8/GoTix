@extends('layouts.guest')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumbs -->
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600">Home</a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-3 h-3 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        <a href="{{ route('events.index') }}" class="text-gray-700 hover:text-blue-600">Events</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-3 h-3 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        <span class="text-gray-500">Event Detail</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Event Hero Image -->
                <div class="mb-8">
                    <img src="https://picsum.photos/800/400?random=1" alt="Event" class="w-full h-80 object-cover rounded-xl">
                </div>

                <!-- Event Details -->
                <div class="bg-white p-6 rounded-xl shadow-md mb-8">
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">Musik Jawa Heritage Festival</h1>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span>Nov 25, 2025 19:00</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span>Jakarta Convention Center</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Doors open at 18:00</span>
                        </div>
                    </div>

                    <div class="prose max-w-none mb-8">
                        <h2 class="text-xl font-semibold mb-4">About the Event</h2>
                        <p class="text-gray-700 mb-4">Experience the rich cultural heritage of Javanese music with traditional instruments and performances. This festival brings together renowned artists and musicians who will showcase the beauty of traditional Javanese music.</p>
                        <p class="text-gray-700">The event features performances by traditional gamelan orchestras, classical Javanese vocalists, and contemporary interpretations of traditional melodies. Attendees will have the opportunity to learn about the history and significance of Javanese music from experts in the field.</p>
                    </div>

                    <div class="flex items-center justify-between mb-8">
                        <div class="flex items-center">
                            <span class="favorite-count mr-4">42 Favorites</span>
                            <button data-favorite-toggle data-event-id="1" class="text-gray-500 hover:text-red-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="flex items-center">
                            <div class="flex text-yellow-400 mr-2">
                                ★★★★☆
                            </div>
                            <span>(4.5/5 - 128 reviews)</span>
                        </div>
                    </div>
                </div>

                <!-- Event Reviews -->
                <div class="bg-white p-6 rounded-xl shadow-md">
                    <h2 class="text-xl font-semibold mb-6">Reviews</h2>
                    <div class="space-y-6">
                        @for ($i = 0; $i < 3; $i++)
                            <div class="border-b border-gray-100 pb-6 last:border-0 last:pb-0">
                                <div class="flex items-center mb-3">
                                    <div class="w-10 h-10 bg-gray-200 rounded-full mr-3"></div>
                                    <div>
                                        <h4 class="font-medium">Reviewer {{ $i+1 }}</h4>
                                        <div class="flex text-yellow-400 text-sm">
                                            ★★★★★
                                        </div>
                                    </div>
                                </div>
                                <p class="text-gray-700">This was an amazing cultural experience. The performances were spectacular and the organization was top-notch. Highly recommended!</p>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white p-6 rounded-xl shadow-md sticky top-8">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-4">Ticket Options</h3>

                        <div class="bg-gray-50 p-4 rounded-lg mb-3">
                            <div class="flex justify-between items-center mb-2">
                                <span class="font-medium">Regular</span>
                                <span class="font-bold text-indigo-600">Rp 150.000</span>
                            </div>
                            <p class="text-sm text-gray-600 mb-2">General admission to the event with standard seating.</p>
                            <div class="text-sm text-gray-500">50 tickets available</div>
                        </div>

                        <div class="bg-gray-100 p-4 rounded-lg mb-3 border border-gray-200">
                            <div class="flex justify-between items-center mb-2">
                                <span class="font-medium">Premium</span>
                                <span class="font-bold text-indigo-600">Rp 300.000</span>
                            </div>
                            <p class="text-sm text-gray-600 mb-2">VIP seating with exclusive access to premium areas.</p>
                            <div class="text-sm text-gray-500">25 tickets available</div>
                        </div>

                        <div class="bg-gradient-to-r from-purple-50 to-indigo-50 p-4 rounded-lg border border-purple-200">
                            <div class="flex justify-between items-center mb-2">
                                <span class="font-medium">VIP</span>
                                <span class="font-bold text-indigo-600">Rp 500.000</span>
                            </div>
                            <p class="text-sm text-gray-600 mb-2">Best seats with meet and greet with artists.</p>
                            <div class="text-sm text-gray-500">10 tickets available</div>
                        </div>
                    </div>

                    <!-- Booking Form -->
                    <div id="event-booking">
                        <h3 class="text-lg font-semibold mb-4">Book Tickets</h3>
                        <form action="#" method="POST">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Regular Tickets</label>
                                    <input type="number" min="0" max="10" class="ticket-quantity w-full px-3 py-2 border border-gray-300 rounded-md" data-price="150000" value="0">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Premium Tickets</label>
                                    <input type="number" min="0" max="5" class="ticket-quantity w-full px-3 py-2 border border-gray-300 rounded-md" data-price="300000" value="0">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">VIP Tickets</label>
                                    <input type="number" min="0" max="2" class="ticket-quantity w-full px-3 py-2 border border-gray-300 rounded-md" data-price="500000" value="0">
                                </div>
                            </div>

                            <div class="mt-6 pt-6 border-t border-gray-200">
                                <div class="flex justify-between items-center mb-4">
                                    <span class="text-gray-700">Total:</span>
                                    <span class="text-xl font-bold total-amount text-indigo-600">Rp 0</span>
                                </div>

                                @auth
                                    <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white py-3 rounded-lg font-medium transition-all duration-300">
                                        Book Now
                                    </button>
                                @else
                                    <a href="{{ route('login') }}" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white py-3 rounded-lg font-medium transition-all duration-300 inline-block text-center">
                                        Login to Book
                                    </a>
                                @endauth
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add JavaScript for ticket calculation -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const ticketInputs = document.querySelectorAll('.ticket-quantity');
                const totalAmount = document.querySelector('.total-amount');

                function calculateTotal() {
                    let total = 0;
                    ticketInputs.forEach(input => {
                        const price = parseInt(input.getAttribute('data-price')) || 0;
                        const quantity = parseInt(input.value) || 0;
                        total += price * quantity;
                    });

                    totalAmount.textContent = 'Rp ' + total.toLocaleString('id-ID');
                }

                ticketInputs.forEach(input => {
                    input.addEventListener('input', calculateTotal);
                    input.addEventListener('change', calculateTotal);
                });

                // Initialize total
                calculateTotal();
            });
        </script>
    </div>
@endsection