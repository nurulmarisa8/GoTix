<div class="event-card group bg-white rounded-xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-2xl border border-gray-100 flex flex-col h-full">
    <!-- Image Container -->
    <div class="relative overflow-hidden">
        <img src="{{ $event['image'] ?? $event->image ? asset('storage/' . ($event['image'] ?? $event->image)) : 'https://via.placeholder.com/400x250' }}"
             alt="{{ $event['name'] ?? $event->name }}" class="w-full h-48 object-cover transition-transform duration-500 group-hover:scale-105">

        <!-- Status Badge -->
        @php
            $eventDate = \Carbon\Carbon::parse($event['date_time'] ?? $event->date_time);
            $isPast = $eventDate->isPast();
        @endphp
        <div class="absolute top-3 left-3">
            <span class="px-2 py-1 text-xs font-bold {{ $isPast ? 'bg-red-500 text-white' : 'bg-green-500 text-white' }} rounded-full">
                {{ $isPast ? 'PAST' : 'UPCOMING' }}
            </span>
        </div>

        <!-- Favorite Button -->
        <div class="absolute top-3 right-3">
            <button class="p-2 bg-white/80 backdrop-blur-sm rounded-full hover:bg-white transition-all duration-200 shadow-md">
                <svg class="w-5 h-5 text-gray-700 hover:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
            </button>
        </div>
    </div>

    <!-- Content Container -->
    <div class="p-5 flex-grow flex flex-col">
        <!-- Title and Price -->
        <div class="flex justify-between items-start mb-3">
            <h3 class="text-lg font-bold text-gray-800 group-hover:text-blue-600 transition-colors flex-grow mr-3">{{ $event['name'] ?? $event->name }}</h3>
            <div class="text-right">
                <span class="text-lg font-bold text-indigo-600">Rp {{ number_format($event['tickets']->min('price') ?? $event->tickets->min('price') ?? 0, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Date and Location -->
        <div class="mb-4 space-y-2">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-indigo-500 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <div class="text-sm text-gray-600">
                    {{ \Carbon\Carbon::parse($event['date_time'] ?? $event->date_time)->format('M d, Y H:i') }}
                </div>
            </div>

            <div class="flex items-start">
                <svg class="w-5 h-5 text-indigo-500 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <div class="text-sm text-gray-600 truncate max-w-[200px]">
                    {{ $event['location'] ?? $event->location }}
                </div>
            </div>
        </div>

        <!-- Description -->
        <p class="text-gray-700 text-sm mb-5 flex-grow line-clamp-2">{{ Str::limit($event['description'] ?? $event->description, 100) }}</p>

        <!-- Rating and Button -->
        <div class="mt-auto pt-4 border-t border-gray-100">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <div class="flex">
                        @for ($i = 0; $i < 5; $i++)
                            <svg class="w-4 h-4 {{ $i < 4 ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        @endfor
                    </div>
                    <span class="text-xs text-gray-500 ml-1">(128)</span>
                </div>

                <a href="{{ route('events.show', $event['id'] ?? $event->id) }}" class="inline-block text-center text-sm py-2 px-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-medium rounded-lg transition-all duration-300 transform hover:-translate-y-0.5 shadow-md hover:shadow-lg">
                    View Details
                </a>
            </div>
        </div>
    </div>
</div>