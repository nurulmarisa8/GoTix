<x-organizer-layout>
    @section('header-title', 'Organizer Dashboard')

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-8">
        <x-stats-card
            title="My Events"
            value="12"
            icon="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
            color="blue"
        />
        <x-stats-card
            title="Total Bookings"
            value="86"
            icon="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"
            color="purple"
        />
        <x-stats-card
            title="Pending Bookings"
            value="7"
            icon="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
            color="yellow"
        />
        <x-stats-card
            title="Revenue"
            value="Rp 24.8M"
            icon="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
            color="green"
        />
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Recent Events -->
        <div class="lg:col-span-2">
            <div class="dashboard-card">
                <div class="dashboard-card__header">
                    <h3 class="dashboard-card__title">My Events</h3>
                    <a href="{{ route('organizer.events.index') }}" class="text-blue-600 hover:text-blue-800">View All</a>
                </div>
                <div class="dashboard-card__content">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200" data-sortable id="events-table">
                            <thead>
                                <tr>
                                    <th data-sort class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th data-sort class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event Name</th>
                                    <th data-sort class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @for ($i = 0; $i < 5; $i++)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">#{{ $i+1 }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">Musik Jawa Heritage Festival {{ $i+1 }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Nov {{ 20 + $i }}, 2025</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('organizer.events.edit', $i+1) }}" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                                            <a href="{{ route('organizer.events.show', $i+1) }}" class="text-green-600 hover:text-green-900 mr-3">View</a>
                                            <a href="#" class="text-red-600 hover:text-red-900">Delete</a>
                                        </td>
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Bookings -->
        <div>
            <div class="dashboard-card">
                <div class="dashboard-card__header">
                    <h3 class="dashboard-card__title">Recent Bookings</h3>
                    <a href="{{ route('organizer.bookings.index') }}" class="text-blue-600 hover:text-blue-800">View All</a>
                </div>
                <div class="dashboard-card__content">
                    @for ($i = 0; $i < 5; $i++)
                        <div class="booking-card">
                            <div class="flex justify-between items-start mb-3">
                                <h4 class="text-sm font-medium">Musik Jawa Heritage Festival {{ $i+1 }}</h4>
                                <span class="text-xs bg-{{ $i % 3 == 0 ? 'green' : ($i % 3 == 1 ? 'yellow' : 'red') }}-100 text-{{ $i % 3 == 0 ? 'green' : ($i % 3 == 1 ? 'yellow' : 'red') }}-800 px-2 py-1 rounded">
                                    {{ $i % 3 == 0 ? 'Approved' : ($i % 3 == 1 ? 'Pending' : 'Rejected') }}
                                </span>
                            </div>
                            <div class="text-xs text-gray-600 mb-2">
                                <p>User {{ $i+1 }}</p>
                                <p>Qty: {{ $i+1 }} tickets</p>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium">Rp {{ number_format((($i+1) * 150000), 0, ',', '.') }}</span>
                                <a href="{{ route('organizer.bookings.manage-status', $i+1) }}" class="text-blue-600 hover:text-blue-800 text-xs">Manage</a>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="dashboard-card mt-8">
                <div class="dashboard-card__header">
                    <h3 class="dashboard-card__title">Quick Actions</h3>
                </div>
                <div class="dashboard-card__content space-y-3">
                    <a href="{{ route('organizer.events.create') }}" class="block w-full btn-primary py-2 text-center">
                        <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Create New Event
                    </a>
                    <a href="{{ route('organizer.events.create-ticket', ['eventId' => 1]) }}" class="block w-full btn-outline py-2 text-center">
                        <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                        </svg>
                        Add Ticket Type
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-organizer-layout>