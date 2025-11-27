@extends('layouts.app')

@section('title', 'Edit Ticket')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Edit Ticket</h1>
    
    <div class="mb-4">
        <a href="{{ route('admin.events.show', $ticket->event) }}" class="text-blue-500 hover:text-blue-700">
            &larr; Back to Event
        </a>
    </div>
    
    <form action="{{ route('tickets.update', $ticket) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="ticket_name" class="block text-sm font-medium text-gray-700 mb-1">Ticket Name</label>
                <input type="text" name="ticket_name" id="ticket_name" value="{{ old('ticket_name', $ticket->ticket_name) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                @error('ticket_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price</label>
                <input type="number" name="price" id="price" value="{{ old('price', $ticket->price) }}" step="0.01" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                @error('price')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="quota" class="block text-sm font-medium text-gray-700 mb-1">Quota</label>
                <input type="number" name="quota" id="quota" value="{{ old('quota', $ticket->quota) }}" min="1" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                @error('quota')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="md:col-span-2">
                <label for="ticket_description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="ticket_description" id="ticket_description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md">{{ old('ticket_description', $ticket->ticket_description) }}</textarea>
                @error('ticket_description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <div class="mt-6">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Update Ticket
            </button>
            <a href="{{ route('admin.events.show', $ticket->event) }}" class="ml-2 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection