@extends('layouts.app')
@section('title', $event->name)

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
    <div>
        <img src="{{ asset('storage/' . $event->image_url) }}" class="w-full h-96 object-cover rounded-xl" alt="{{ $event->name }}">
    </div>
    <div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $event->name }}</h1>
        <p class="text-gray-600 mb-4">Rating: ⭐ {{ number_format($event->getAverageRating(), 1) }}/5
            ({{ $event->reviews->count() }} reviews)</p>
        <p class="text-gray-700 mb-6">{{ $event->description }}</p>

        <div class="mb-6 space-y-2">
            <p><span class="font-semibold text-gray-700">📍 Location:</span> {{ $event->location }}</p>
            <p><span class="font-semibold text-gray-700">📅 Date & Time:</span> {{ $event->event_date->format('d M Y H:i') }}</p>
        </div>

        @auth
            <button
                class="mb-6 px-4 py-2 rounded-lg font-medium {{ $isFavorite ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800' }}"
                onclick="toggleFavorite({{ $event->id }})">
                {{ $isFavorite ? '❤️ Saved' : '🤍 Save Event' }}
            </button>
        @endauth

        <h2 class="text-2xl font-bold text-gray-900 mb-4">Available Tickets</h2>
        @forelse($tickets as $ticket)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5 mb-4">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $ticket->ticket_name }}</h3>
                <p class="text-gray-600 mb-3">{{ $ticket->ticket_description }}</p>
                <div class="flex items-center justify-between mb-4">
                    <p class="text-lg font-semibold text-indigo-600">Rp {{ number_format($ticket->price, 0, ',', '.') }}</p>
                    <p class="text-sm text-gray-600"><span class="font-semibold">Available:</span> {{ $ticket->available_quota }} / {{ $ticket->quota }}</p>
                </div>

                @auth
                    <form action="{{ route('bookings.store', $ticket) }}" method="POST" class="flex items-center gap-3">
                        @csrf
                        <div class="flex items-center">
                            <span class="mr-2 text-gray-700">Qty:</span>
                            <input type="number" name="quantity"
                                   class="w-16 px-3 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500"
                                   min="1" max="{{ $ticket->available_quota }}" value="1" required>
                        </div>
                        <button type="submit"
                                class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Book Now
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                       class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Login to Book
                    </a>
                @endauth
            </div>
        @empty
            <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 px-4 py-3 rounded-lg">
                <p>No tickets available</p>
            </div>
        @endforelse
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mt-8">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold text-gray-900">Reviews</h2>
        @auth
            <a href="{{ route('reviews.create', $event) }}"
               class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Write a Review
            </a>
        @endauth
    </div>

    @forelse($event->reviews as $review)
        <div class="border-b border-gray-200 py-4 last:border-0">
            <div class="flex items-center justify-between mb-2">
                <h3 class="font-medium text-gray-900">{{ $review->user->name }}</h3>
                <div class="flex items-center">
                    <span class="text-yellow-500 mr-1">⭐</span>
                    <span class="font-medium">{{ $review->rating }}/5</span>
                </div>
            </div>
            <p class="text-gray-600">{{ $review->review_text }}</p>
        </div>
    @empty
        <p class="text-gray-500">No reviews yet</p>
    @endforelse
</div>

@endsection

@section('scripts')
<script>
function toggleFavorite(eventId) {
    fetch('{{ route("favorites.toggle", ":id") }}'.replace(':id', eventId), {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
    }).then(() => location.reload());
}
</script>
@endsection