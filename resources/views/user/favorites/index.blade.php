<x-user-layout>
    @section('header-title', 'Favorite Events')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="text-center mb-12">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">My Favorite Events</h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">Your saved events that you don't want to miss.</p>
        </div>

        <!-- Favorite Events Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @for ($i = 0; $i < 6; $i++)
                <div class="event-card">
                    <div class="event-card__image-container">
                        <img src="https://via.placeholder.com/400x200" alt="Event" class="event-card__image">
                        <button class="event-card__favorite-btn">
                            <svg class="w-6 h-6 text-red-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="event-card__content">
                        <h3 class="event-card__title">Musik Jawa Heritage Festival {{ $i+1 }}</h3>
                        <div class="event-card__date flex items-center mb-2">
                            <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Nov {{ 20 + $i }}, 2025 19:00
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
                            <a href="{{ route('events.show', $i+1) }}" class="btn-primary text-sm py-2 px-4">View Details</a>
                        </div>
                    </div>
                </div>
            @endfor
        </div>

        @if (0) {{-- If no favorites exist --}}
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No favorite events</h3>
            <p class="mt-1 text-sm text-gray-500">You haven't saved any events to your favorites yet.</p>
            <div class="mt-6">
                <a href="{{ route('events.index') }}" class="btn-primary">
                    Browse Events
                </a>
            </div>
        </div>
        @endif
    </div>
</x-user-layout>