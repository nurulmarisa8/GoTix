@extends('layouts.app')

@section('title', 'Create Event')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Create New Event</h1>

    <form action="{{ route('organizer.events.store') }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-md rounded-lg p-6">
        @csrf

        <div class="mb-6">
            <label for="name" class="block text-gray-700 text-sm font-medium mb-2">Event Name</label>
            <input type="text" name="name" id="name"
                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('name') border-red-300 @enderror"
                   value="{{ old('name') }}" required>
            @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="description" class="block text-gray-700 text-sm font-medium mb-2">Description</label>
            <textarea name="description" id="description" rows="4"
                      class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('description') border-red-300 @enderror"
                      required>{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="event_date" class="block text-gray-700 text-sm font-medium mb-2">Event Date & Time</label>
                <input type="datetime-local" name="event_date" id="event_date"
                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('event_date') border-red-300 @enderror"
                       value="{{ old('event_date') }}" required>
                @error('event_date')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="location" class="block text-gray-700 text-sm font-medium mb-2">Location</label>
                <input type="text" name="location" id="location"
                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('location') border-red-300 @enderror"
                       value="{{ old('location') }}" required>
                @error('location')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mb-6">
            <label for="image" class="block text-gray-700 text-sm font-medium mb-2">Event Image</label>
            <input type="file" name="image" id="image"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('image') border-red-300 @enderror"
                   accept="image/*" required>
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
                Create Event
            </button>
        </div>
    </form>
</div>
@endsection