@extends('layouts.app')

@section('title', 'Edit Ticket - ' . $ticket->event->name)

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Edit Ticket: {{ $ticket->ticket_name }}</h1>

    <form action="{{ route('organizer.tickets.update', $ticket) }}" method="POST" class="bg-white shadow-md rounded-lg p-6">
        @csrf
        @method('PUT')

        <div class="mb-6">
            <label for="ticket_name" class="block text-gray-700 text-sm font-medium mb-2">Ticket Name</label>
            <input type="text" name="ticket_name" id="ticket_name"
                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('ticket_name') border-red-300 @enderror"
                   value="{{ old('ticket_name', $ticket->ticket_name) }}" required>
            @error('ticket_name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="ticket_description" class="block text-gray-700 text-sm font-medium mb-2">Ticket Description</label>
            <textarea name="ticket_description" id="ticket_description" rows="3"
                      class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('ticket_description') border-red-300 @enderror">{{ old('ticket_description', $ticket->ticket_description) }}</textarea>
            @error('ticket_description')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="price" class="block text-gray-700 text-sm font-medium mb-2">Price (Rp)</label>
                <input type="number" name="price" id="price"
                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('price') border-red-300 @enderror"
                       value="{{ old('price', $ticket->price) }}" min="0" required>
                @error('price')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="quota" class="block text-gray-700 text-sm font-medium mb-2">Quota</label>
                <input type="number" name="quota" id="quota"
                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('quota') border-red-300 @enderror"
                       value="{{ old('quota', $ticket->quota) }}" min="1" required>
                @error('quota')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex items-center justify-between">
            <a href="{{ route('organizer.events.edit', $ticket->event) }}"
               class="inline-block align-baseline font-medium text-sm text-indigo-600 hover:text-indigo-800">
                Cancel
            </a>
            <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-6 rounded-md transition duration-300">
                Update Ticket
            </button>
        </div>
    </form>
</div>
@endsection