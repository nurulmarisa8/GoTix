<x-admin-layout>
    @section('header-title', 'Sales Reports')

    <!-- Report Filters -->
    <div class="dashboard-card mb-6">
        <div class="dashboard-card__content p-6">
            <form method="GET" action="{{ route('admin.reports.sales') }}">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" name="start_date" id="start_date" class="form-input" value="{{ request('start_date', today()->subDays(30)->format('Y-m-d')) }}">
                    </div>
                    <div>
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" name="end_date" id="end_date" class="form-input" value="{{ request('end_date', today()->format('Y-m-d')) }}">
                    </div>
                    <div>
                        <label for="event_id" class="form-label">Event</label>
                        <select name="event_id" id="event_id" class="form-select">
                            <option value="">All Events</option>
                            <option value="1">Musik Jawa Heritage Festival</option>
                            <option value="2">Konser Indonesia Raya 2025</option>
                        </select>
                    </div>
                    <div>
                        <label for="ticket_type" class="form-label">Ticket Type</label>
                        <select name="ticket_type" id="ticket_type" class="form-select">
                            <option value="">All Types</option>
                            <option value="regular">Regular</option>
                            <option value="vip">VIP</option>
                            <option value="vvip">VVIP</option>
                        </select>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn-primary">Generate Report</button>
                    <button type="button" class="btn-outline ml-2">Export to PDF</button>
                    <button type="button" class="btn-outline ml-2">Export to Excel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-blue-100 text-blue-600 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Total Revenue</p>
                    <p class="text-2xl font-bold">Rp 42.5M</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-green-100 text-green-600 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Total Bookings</p>
                    <p class="text-2xl font-bold">1,248</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-yellow-100 text-yellow-600 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Total Attendees</p>
                    <p class="text-2xl font-bold">2,496</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-purple-100 text-purple-600 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Avg. Ticket Price</p>
                    <p class="text-2xl font-bold">Rp 340.500</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Revenue Chart -->
        <div class="dashboard-card">
            <div class="dashboard-card__header">
                <h3 class="dashboard-card__title">Revenue Trend</h3>
            </div>
            <div class="dashboard-card__content">
                <div class="h-80 flex items-center justify-center">
                    <canvas id="revenue-chart"></canvas>
                </div>
            </div>
        </div>

        <!-- Bookings Chart -->
        <div class="dashboard-card">
            <div class="dashboard-card__header">
                <h3 class="dashboard-card__title">Bookings Overview</h3>
            </div>
            <div class="dashboard-card__content">
                <div class="h-80 flex items-center justify-center">
                    <canvas id="bookings-chart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Selling Events -->
    <div class="dashboard-card">
        <div class="dashboard-card__header">
            <h3 class="dashboard-card__title">Top Selling Events</h3>
        </div>
        <div class="dashboard-card__content overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event</th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Tickets</th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Revenue</th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sold %</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @for ($i = 0; $i < 5; $i++)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">Musik Jawa Heritage Festival {{ $i+1 }}</div>
                                <div class="text-sm text-gray-500">Nov {{ 20 + $i }}, 2025</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ rand(500, 1200) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">Rp {{ number_format(rand(150000000, 300000000), 0, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="mr-2">{{ rand(65, 95) }}%</span>
                                    <div class="w-24 bg-gray-200 rounded-full h-2">
                                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ rand(65, 95) }}%"></div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>

    <!-- Scripts for charts -->
    <script>
        // Simple chart scripts - in a real application, you would use Chart.js or similar
        document.addEventListener('DOMContentLoaded', function() {
            // These are placeholder implementations
            console.log('Revenue and bookings chart would be implemented here with Chart.js');
        });
    </script>
</x-admin-layout>