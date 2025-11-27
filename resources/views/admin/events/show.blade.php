@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Event Details</h1>
        <div>
            <a href="{{ route('admin.events.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                Back to Events
            </a>
            <a href="{{ route('admin.events.edit', $event) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Edit Event
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-2">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex flex-col md:flex-row">
                    <div class="md:w-1/3 mb-4 md:mb-0 md:mr-6">
                        @if($event->image_url)
                            <img src="{{ asset('storage/' . $event->image_url) }}" alt="{{ $event->name }}" class="w-full h-64 object-cover rounded">
                        @else
                            <div class="bg-gray-200 border-2 border-dashed rounded-xl w-full h-64 flex items-center justify-center">
                                No Image
                            </div>
                        @endif
                    </div>
                    <div class="md:w-2/3">
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $event->name }}</h2>
                        <div class="mb-4">
                            <p class="text-gray-600"><strong>Organizer:</strong> {{ $event->organizer->name ?? 'N/A' }}</p>
                            <p class="text-gray-600"><strong>Date:</strong> {{ $event->event_date->format('M d, Y H:i') }}</p>
                            <p class="text-gray-600"><strong>Location:</strong> {{ $event->location }}</p>
                            <p class="text-gray-600"><strong>Status:</strong> 
                                <span class="{{ $event->status === 'active' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ ucfirst($event->status) }}
                                </span>
                            </p>
                        </div>
                        <div class="mb-4">
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">Description</h3>
                            <p class="text-gray-700">{{ $event->description }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="md:col-span-1">
            <!-- Event Stats -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Event Stats</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total Tickets:</span>
                        <span class="font-medium">{{ $event->tickets->count() }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total Bookings:</span>
                        <span class="font-medium">{{ $event->bookings->count() }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Available Quota:</span>
                        <span class="font-medium">{{ $event->tickets->sum('available_quota') }}</span>
                    </div>
                </div>
            </div>

            <!-- Booking Status Distribution -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Booking Status</h3>
                <div class="space-y-3">
                    @forelse($bookingStats as $stat)
                        <div class="flex justify-between">
                            <span class="text-gray-600 capitalize">{{ $stat->status }}:</span>
                            <span class="font-medium">{{ $stat->total }}</span>
                        </div>
                    @empty
                        <p class="text-gray-600">No booking data found.</p>
                    @endforelse
                </div>
            </div>

            <!-- Tickets Section -->
            <div class="bg-white rounded-lg shadow-md p-6 mt-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Tickets</h3>
                @forelse($tickets as $ticket)
                    <div class="border-b border-gray-200 py-3 last:border-0">
                        <p class="font-medium text-gray-800">{{ $ticket->name }}</p>
                        <p class="text-gray-600 text-sm">Rp {{ number_format($ticket->price, 0, ',', '.') }}</p>
                        <p class="text-gray-600 text-sm">Available: {{ $ticket->available_quota }}/{{ $ticket->quota }}</p>
                    </div>
                @empty
                    <p class="text-gray-600">No tickets created for this event.</p>
                @endforelse
                <a href="{{ route('admin.events.tickets.create', $event) }}" class="mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Create Ticket
                </a>
            </div>
        </div>
    </div>
</div>
@endsection