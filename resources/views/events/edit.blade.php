@extends('layouts.app')

@section('title', 'Edit Event')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Edit Event</h1>

    <form action="{{ route('organizer.events.update', $event) }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-md rounded-lg p-6">
        @csrf
        @method('PUT')

        <div class="mb-6">
            <label for="name" class="block text-gray-700 text-sm font-medium mb-2">Event Name</label>
            <input type="text" name="name" id="name"
                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('name') border-red-300 @enderror"
                   value="{{ old('name', $event->name) }}" required>
            @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="description" class="block text-gray-700 text-sm font-medium mb-2">Description</label>
            <textarea name="description" id="description" rows="4"
                      class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('description') border-red-300 @enderror"
                      required>{{ old('description', $event->description) }}</textarea>
            @error('description')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="event_date" class="block text-gray-700 text-sm font-medium mb-2">Event Date & Time</label>
                <input type="datetime-local" name="event_date" id="event_date"
                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('event_date') border-red-300 @enderror"
                       value="{{ old('event_date', $event->event_date->format('Y-m-d\\TH:i')) }}" required>
                @error('event_date')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="location" class="block text-gray-700 text-sm font-medium mb-2">Location</label>
                <input type="text" name="location" id="location"
                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('location') border-red-300 @enderror"
                       value="{{ old('location', $event->location) }}" required>
                @error('location')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mb-6">
            <label for="image" class="block text-gray-700 text-sm font-medium mb-2">Event Image</label>
            @if($event->image_url)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $event->image_url) }}" alt="Current image" class="h-32 w-32 object-cover rounded">
                </div>
            @endif
            <input type="file" name="image" id="image"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('image') border-red-300 @enderror"
                   accept="image/*">
            <p class="text-gray-500 text-xs mt-1">Leave empty to keep current image</p>
            @error('image')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between">
            <a href="{{ route('organizer.events.index') }}"
               class="inline-block align-baseline font-medium text-sm text-indigo-600 hover:text-indigo-800">
                Cancel
            </a>
            <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-6 rounded-md transition duration-300">
                Update Event
            </button>
        </div>
    </form>

    <!-- Ticket Management Section -->
    <div class="mt-8 bg-white shadow-md rounded-lg p-6">
        <h2 class="text-xl font-bold mb-4">Manage Tickets</h2>
        
        <div class="mb-6">
            <a href="{{ route('organizer.events.tickets.create', $event) }}"
               class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700">
                + Add Ticket Type
            </a>
        </div>

        @if($event->tickets->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ticket Name</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quota</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Available</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($event->tickets as $ticket)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $ticket->ticket_name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ Str::limit($ticket->ticket_description, 50) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp {{ number_format($ticket->price, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $ticket->quota }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $ticket->available_quota }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('organizer.tickets.edit', $ticket) }}"
                                       class="text-blue-600 hover:text-blue-900">Edit</a>
                                    <form action="{{ route('organizer.tickets.destroy', $ticket) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Are you sure you want to delete this ticket?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500">No ticket types created yet.</p>
        @endif
    </div>
</div>
@endsection