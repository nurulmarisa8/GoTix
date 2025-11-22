<x-user-layout>
    @section('header-title', 'User Dashboard')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Stats Cards -->
        <div class="lg:col-span-3 grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <x-stats-card 
                title="Total Bookings" 
                value="24" 
                icon="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"
                color="blue"
            />
            <x-stats-card 
                title="Pending Bookings" 
                value="3" 
                icon="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                color="yellow"
            />
            <x-stats-card 
                title="Completed Events" 
                value="21" 
                icon="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                color="green"
            />
        </div>

        <!-- Recent Bookings -->
        <div class="lg:col-span-2">
            <div class="dashboard-card">
                <div class="dashboard-card__header">
                    <h3 class="dashboard-card__title">Recent Bookings</h3>
                    <a href="{{ route('user.bookings.index') }}" class="text-blue-600 hover:text-blue-800">View All</a>
                </div>
                <div class="dashboard-card__content">
                    @for ($i = 0; $i < 3; $i++)
                        <div class="booking-card">
                            <div class="booking-card__header">
                                <h4 class="booking-card__event">Musik Jawa Heritage Festival {{ $i+1 }}</h4>
                                <span class="booking-card__status badge-{{ $i % 3 == 0 ? 'approved' : ($i % 3 == 1 ? 'pending' : 'rejected') }}">
                                    {{ $i % 3 == 0 ? 'Approved' : ($i % 3 == 1 ? 'Pending' : 'Rejected') }}
                                </span>
                            </div>
                            <div class="booking-card__details">
                                <div>
                                    <span class="booking-card__detail-label">Event Date</span>
                                    <span class="booking-card__detail-value">Nov 25, 2025</span>
                                </div>
                                <div>
                                    <span class="booking-card__detail-label">Ticket Type</span>
                                    <span class="booking-card__detail-value">VIP</span>
                                </div>
                                <div>
                                    <span class="booking-card__detail-label">Quantity</span>
                                    <span class="booking-card__detail-value">2</span>
                                </div>
                                <div>
                                    <span class="booking-card__detail-label">Total</span>
                                    <span class="booking-card__detail-value">Rp 1.000.000</span>
                                </div>
                            </div>
                            <div class="flex justify-end space-x-2">
                                <a href="#" class="text-blue-600 hover:text-blue-800 text-sm">View Details</a>
                                @if($i % 3 == 1) <!-- Only show cancel for pending bookings -->
                                    <a href="#" class="text-red-600 hover:text-red-800 text-sm">Cancel</a>
                                @endif
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div>
            <div class="dashboard-card">
                <div class="dashboard-card__header">
                    <h3 class="dashboard-card__title">Quick Actions</h3>
                </div>
                <div class="dashboard-card__content space-y-4">
                    <a href="{{ route('events.index') }}" class="block w-full btn-primary py-3 text-center">
                        <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Book New Ticket
                    </a>
                    <a href="{{ route('user.favorites.index') }}" class="block w-full btn-outline py-3 text-center">
                        <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                        My Favorites
                    </a>
                    <a href="{{ route('user.profile.edit') }}" class="block w-full btn-outline py-3 text-center">
                        <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Edit Profile
                    </a>
                </div>
            </div>

            <!-- Favorite Events -->
            <div class="dashboard-card mt-8">
                <div class="dashboard-card__header">
                    <h3 class="dashboard-card__title">Favorite Events</h3>
                    <a href="{{ route('user.favorites.index') }}" class="text-blue-600 hover:text-blue-800">View All</a>
                </div>
                <div class="dashboard-card__content">
                    @for ($i = 0; $i < 2; $i++)
                        <div class="flex items-center p-3 border border-gray-200 rounded-lg mb-3">
                            <img src="https://via.placeholder.com/60x40" alt="Event" class="w-12 h-8 object-cover rounded mr-3">
                            <div class="flex-1">
                                <h4 class="text-sm font-medium">Concert Musik Indonesia Raya {{ $i+1 }}</h4>
                                <p class="text-xs text-gray-500">Nov 25, 2025</p>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
</x-user-layout>