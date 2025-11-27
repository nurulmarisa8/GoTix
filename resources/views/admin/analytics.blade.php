@extends('layouts.app')
@section('title', 'Analytics Dashboard')

@section('styles')
<style>
    .chart-container {
        position: relative;
        height: 300px;
        margin-top: 20px;
    }
</style>
@endsection

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Analytics Dashboard</h1>
    <p class="text-gray-600">Comprehensive statistics and insights for your platform</p>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h6 class="text-gray-500 text-sm font-medium uppercase tracking-wide mb-2">Total Users</h6>
        <p class="text-3xl font-bold text-indigo-600">{{ $totalUsers }}</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h6 class="text-gray-500 text-sm font-medium uppercase tracking-wide mb-2">Total Events</h6>
        <p class="text-3xl font-bold text-indigo-600">{{ $totalEvents }}</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h6 class="text-gray-500 text-sm font-medium uppercase tracking-wide mb-2">Total Bookings</h6>
        <p class="text-3xl font-bold text-indigo-600">{{ $totalBookings }}</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h6 class="text-gray-500 text-sm font-medium uppercase tracking-wide mb-2">Total Revenue</h6>
        <p class="text-3xl font-bold text-indigo-600">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Revenue by Month Chart -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Revenue by Month</h3>
        <div class="chart-container">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    <!-- User Growth Chart -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">User Growth (Last 30 Days)</h3>
        <div class="chart-container">
            <canvas id="userGrowthChart"></canvas>
        </div>
    </div>

    <!-- Booking Status Distribution -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Booking Status Distribution</h3>
        <div class="chart-container">
            <canvas id="bookingStatusChart"></canvas>
        </div>
    </div>

    <!-- Events by Organizer -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Top Event Organizers</h3>
        <div class="space-y-4">
            @forelse($eventsByOrganizer as $organizer)
            <div class="flex items-center justify-between">
                <span class="text-gray-700">{{ $organizer->name }}</span>
                <span class="font-medium text-gray-900">{{ $organizer->total_events }}</span>
            </div>
            @empty
            <p class="text-gray-500 text-center py-4">No organizers found</p>
            @endforelse
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: [
                @foreach($revenueByMonth as $month)
                    '{{ date("M Y", mktime(0, 0, 0, $month->month, 1, $month->year)) }}',
                @endforeach
            ],
            datasets: [{
                label: 'Revenue (Rp)',
                data: [
                    @foreach($revenueByMonth as $month)
                        {{ $month->total_revenue }},
                    @endforeach
                ],
                backgroundColor: 'rgba(99, 102, 241, 0.2)',
                borderColor: 'rgba(99, 102, 241, 1)',
                borderWidth: 2,
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });

    // User Growth Chart
    const userGrowthCtx = document.getElementById('userGrowthChart').getContext('2d');
    const userGrowthChart = new Chart(userGrowthCtx, {
        type: 'bar',
        data: {
            labels: [
                @foreach($userGrowth as $entry)
                    '{{ \Carbon\Carbon::parse($entry->date)->format("M d") }}',
                @endforeach
            ],
            datasets: [{
                label: 'New Users',
                data: [
                    @foreach($userGrowth as $entry)
                        {{ $entry->total }},
                    @endforeach
                ],
                backgroundColor: 'rgba(16, 185, 129, 0.2)',
                borderColor: 'rgba(16, 185, 129, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Booking Status Chart
    const bookingStatusCtx = document.getElementById('bookingStatusChart').getContext('2d');
    const bookingStatusChart = new Chart(bookingStatusCtx, {
        type: 'doughnut',
        data: {
            labels: [
                @foreach($bookingStatus as $status)
                    '{{ ucfirst($status->status) }}',
                @endforeach
            ],
            datasets: [{
                data: [
                    @foreach($bookingStatus as $status)
                        {{ $status->total }},
                    @endforeach
                ],
                backgroundColor: [
                    'rgba(34, 197, 94, 0.8)',   // approved - green
                    'rgba(239, 68, 68, 0.8)',   // cancelled - red
                    'rgba(245, 158, 11, 0.8)',  // pending - yellow
                ],
                borderColor: [
                    'rgba(34, 197, 94, 1)',
                    'rgba(239, 68, 68, 1)',
                    'rgba(245, 158, 11, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>
@endsection