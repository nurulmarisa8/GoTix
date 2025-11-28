@extends('layouts.app')

@section('title', 'Booking Details')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Booking Details</h1>
            <span class="px-3 py-1 rounded-full text-sm font-medium
                {{ $booking->status === 'approved' ? 'bg-green-100 text-green-800' : 
                   ($booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                   ($booking->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')) }}">
                {{ ucfirst($booking->status) }}
            </span>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Booking Information</h2>
                <div class="space-y-2">
                    <p><span class="font-medium text-gray-700">Booking ID:</span> {{ $booking->id }}</p>
                    <p><span class="font-medium text-gray-700">Event:</span> {{ $booking->ticket->event->name }}</p>
                    <p><span class="font-medium text-gray-700">Ticket Type:</span> {{ $booking->ticket->ticket_name }}</p>
                    <p><span class="font-medium text-gray-700">Quantity:</span> {{ $booking->quantity }}</p>
                    <p><span class="font-medium text-gray-700">Total Price:</span> Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                    <p><span class="font-medium text-gray-700">Booking Date:</span> {{ $booking->created_at->format('d M Y H:i') }}</p>
                    @if($booking->cancel_deadline)
                        <p><span class="font-medium text-gray-700">Cancel Deadline:</span> {{ $booking->cancel_deadline->format('d M Y H:i') }}</p>
                    @endif
                </div>
            </div>

            <div>
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Event Details</h2>
                <div class="space-y-2">
                    <p><span class="font-medium text-gray-700">Name:</span> {{ $booking->ticket->event->name }}</p>
                    <p><span class="font-medium text-gray-700">Date:</span> {{ $booking->ticket->event->event_date->format('d M Y H:i') }}</p>
                    <p><span class="font-medium text-gray-700">Location:</span> {{ $booking->ticket->event->location }}</p>
                    <p><span class="font-medium text-gray-700">Description:</span> {{ Str::limit($booking->ticket->event->description, 100) }}</p>
                </div>
            </div>
        </div>

        @if($booking->status === 'pending' && $booking->user_id === auth()->id())
            <div class="mt-6">
                <form action="{{ route('bookings.cancel', $booking) }}" method="POST" class="inline">
                    @csrf
                    @method('POST')
                    <button type="submit" 
                            class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded mr-2"
                            onclick="return confirm('Are you sure you want to cancel this booking?')">
                        Cancel Booking
                    </button>
                </form>
            </div>
        @endif

        @if($booking->status === 'approved')
            <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                <h3 class="font-medium text-blue-800 mb-2">Booking Approved</h3>
                <p class="text-blue-700">Your booking has been approved. Please arrive at the event on time.</p>
            </div>
        @elseif($booking->status === 'pending')
            <div class="mt-6 p-4 bg-yellow-50 rounded-lg">
                <h3 class="font-medium text-yellow-800 mb-2">Booking Pending</h3>
                <p class="text-yellow-700">Your booking is under review by the event organizer. Please wait for approval.</p>
            </div>
        @elseif($booking->status === 'rejected')
            <div class="mt-6 p-4 bg-red-50 rounded-lg">
                <h3 class="font-medium text-red-800 mb-2">Booking Rejected</h3>
                <p class="text-red-700">Your booking has been rejected by the event organizer.</p>
            </div>
        @endif
    </div>
</div>
@endsection