@extends('layouts.app')
@section('title', 'Admin Dashboard')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Admin Dashboard</h1>
    <p class="text-gray-600">Welcome back! Here's an overview of your platform</p>
</div>

<!-- Quick Navigation -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
    <a href="{{ route('admin.analytics') }}"
       class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 text-center hover:shadow-md transition">
        <h3 class="text-lg font-semibold text-gray-900">Analytics</h3>
        <p class="text-gray-600 mt-1">View detailed reports and charts</p>
    </a>
    <a href="{{ route('admin.users.index') }}"
       class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 text-center hover:shadow-md transition">
        <h3 class="text-lg font-semibold text-gray-900">Users</h3>
        <p class="text-gray-600 mt-1">Manage all users</p>
    </a>
    <a href="{{ route('admin.events.index') }}"
       class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 text-center hover:shadow-md transition">
        <h3 class="text-lg font-semibold text-gray-900">Events</h3>
        <p class="text-gray-600 mt-1">Manage all events</p>
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-indigo-600 text-white rounded-xl shadow-sm p-6">
        <h6 class="text-indigo-200 text-sm font-medium uppercase tracking-wide mb-2">Total Users</h6>
        <p class="text-3xl font-bold">{{ $totalUsers }}</p>
    </div>

    <div class="bg-green-600 text-white rounded-xl shadow-sm p-6">
        <h6 class="text-green-200 text-sm font-medium uppercase tracking-wide mb-2">Total Events</h6>
        <p class="text-3xl font-bold">{{ $totalEvents }}</p>
    </div>

    <div class="bg-blue-600 text-white rounded-xl shadow-sm p-6">
        <h6 class="text-blue-200 text-sm font-medium uppercase tracking-wide mb-2">Total Bookings</h6>
        <p class="text-3xl font-bold">{{ $totalBookings }}</p>
    </div>

    <div class="bg-yellow-600 text-white rounded-xl shadow-sm p-6">
        <h6 class="text-yellow-200 text-sm font-medium uppercase tracking-wide mb-2">Total Revenue</h6>
        <p class="text-3xl font-bold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Pending Organizers</h3>
        <p class="text-gray-600 mb-4">{{ $pendingOrganizers }} organizer(s) awaiting approval</p>
        <a href="{{ route('admin.users.index') }}"
           class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Review Organizers
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Booking Status Distribution</h3>
        <div class="space-y-2">
            @foreach($bookingsByStatus as $stat)
            <div class="flex justify-between items-center">
                <span class="text-gray-700 capitalize">{{ $stat->status }}</span>
                <span class="font-medium text-gray-900">{{ $stat->total }}</span>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900">Recent Bookings</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($recentBookings as $booking)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $booking->user->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $booking->ticket->event->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $booking->quantity }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                            {{ $booking->status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $booking->created_at->diffForHumans() }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                        No bookings yet
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection