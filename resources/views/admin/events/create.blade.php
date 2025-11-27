@extends('layouts.app')

@section('title', 'Create Event')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Create Event</h1>
    
    <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">Organizer</label>
                <select name="user_id" id="user_id" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                    <option value="">Select Organizer</option>
                    @foreach($organizers as $organizer)
                        <option value="{{ $organizer->id }}">{{ $organizer->name }} ({{ $organizer->email }})</option>
                    @endforeach
                </select>
                @error('user_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Event Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="md:col-span-2">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" id="description" rows="5" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="event_date" class="block text-sm font-medium text-gray-700 mb-1">Event Date</label>
                <input type="datetime-local" name="event_date" id="event_date" value="{{ old('event_date') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                @error('event_date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                <input type="text" name="location" id="location" value="{{ old('location') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                @error('location')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Event Image</label>
                <input type="file" name="image" id="image" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                @error('image')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <div class="mt-6">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Create Event
            </button>
            <a href="{{ route('admin.events.index') }}" class="ml-2 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection