<x-admin-layout>
    @section('header-title', 'Admin Dashboard')

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-8">
        <x-stats-card 
            title="Total Events" 
            value="42" 
            icon="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
            color="blue"
        />
        <x-stats-card 
            title="Total Users" 
            value="128" 
            icon="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"
            color="purple"
        />
        <x-stats-card 
            title="Total Bookings" 
            value="156" 
            icon="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"
            color="green"
        />
        <x-stats-card 
            title="Revenue" 
            value="Rp 42.5M" 
            icon="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
            color="yellow"
        />
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Recent Events -->
        <div class="lg:col-span-2">
            <div class="dashboard-card">
                <div class="dashboard-card__header">
                    <h3 class="dashboard-card__title">Recent Events</h3>
                    <a href="{{ route('admin.events.index') }}" class="text-blue-600 hover:text-blue-800">View All</a>
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
                                            <a href="{{ route('admin.events.edit', $i+1) }}" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                                            <a href="{{ route('admin.events.show', $i+1) }}" class="text-green-600 hover:text-green-900 mr-3">View</a>
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

        <!-- Recent Users -->
        <div>
            <div class="dashboard-card">
                <div class="dashboard-card__header">
                    <h3 class="dashboard-card__title">Recent Users</h3>
                    <a href="{{ route('admin.users.index') }}" class="text-blue-600 hover:text-blue-800">View All</a>
                </div>
                <div class="dashboard-card__content">
                    @for ($i = 0; $i < 5; $i++)
                        <div class="flex items-center p-3 border-b border-gray-200 last:border-0">
                            <div class="w-10 h-10 bg-gray-200 rounded-full mr-3"></div>
                            <div class="flex-1">
                                <h4 class="text-sm font-medium">User {{ $i+1 }}</h4>
                                <p class="text-xs text-gray-500">user{{ $i+1 }}@example.com</p>
                            </div>
                            <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">User</span>
                        </div>
                    @endfor
                </div>
            </div>

            <!-- Booking Status -->
            <div class="dashboard-card mt-8">
                <div class="dashboard-card__header">
                    <h3 class="dashboard-card__title">Booking Status</h3>
                </div>
                <div class="dashboard-card__content">
                    <div class="flex justify-center">
                        <canvas id="booking-chart" width="200" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>