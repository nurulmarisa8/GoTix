@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Welcome, {{ auth()->user()->name }}!</h1>
    <p class="text-gray-600 mt-2">Here's what's happening with your account</p>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h6 class="text-gray-500 text-sm font-medium uppercase tracking-wide mb-2">Total Bookings</h6>
        <p class="text-2xl font-bold text-indigo-600">{{ auth()->user()->bookings()->count() }}</p>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h6 class="text-gray-500 text-sm font-medium uppercase tracking-wide mb-2">Favorite Events</h6>
        <p class="text-2xl font-bold text-indigo-600">{{ auth()->user()->favorites()->count() }}</p>
    </div>

    @if(auth()->user()->role === 'organizer')
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h6 class="text-gray-500 text-sm font-medium uppercase tracking-wide mb-2">My Events</h6>
        <p class="text-2xl font-bold text-indigo-600">{{ auth()->user()->events()->count() }}</p>
    </div>
    @endif
</div>

<div class="grid grid-cols-1 gap-8">
    <!-- Recent Bookings and Favorite Events for mobile -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Recent Bookings -->
        <div class="lg:col-span-2 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-xl font-semibold text-gray-900 mb-4">Recent Bookings</h3>
            @forelse(auth()->user()->bookings()->latest()->take(5)->get() as $booking)
            <div class="border-b border-gray-200 py-4 last:border-0 last:pb-0">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                    <div class="flex-1">
                        <h4 class="font-medium text-gray-900">{{ $booking->ticket->event->name }}</h4>
                        <p class="text-sm text-gray-600">{{ $booking->ticket->ticket_name }} • Qty: {{ $booking->quantity }}</p>
                    </div>
                    <div class="flex flex-col sm:text-right gap-2">
                        <p class="font-medium text-gray-900">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                              {{ $booking->status === 'approved' ? 'bg-green-100 text-green-800' : ($booking->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                        <a href="{{ route('booking.show', $booking) }}"
                           class="inline-flex items-center justify-center sm:ml-auto mt-2 sm:mt-0 px-3 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <p class="text-gray-500 text-center py-4">No bookings yet</p>
            @endforelse
        </div>

        <!-- Favorite Events -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-xl font-semibold text-gray-900 mb-4">Favorite Events</h3>
            @forelse(auth()->user()->favorites()->take(5)->get() as $event)
            <a href="{{ route('events.show', $event) }}"
               class="block p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition mb-3 last:mb-0">
                <h4 class="font-medium text-gray-900">{{ $event->name }}</h4>
                <p class="text-sm text-gray-600 mt-1">{{ $event->event_date->format('d M Y') }}</p>
            </a>
            @empty
            <p class="text-gray-500 text-center py-4">No favorite events yet</p>
            @endforelse
        </div>
    </div>
</div>
@endsection