<x-user-layout>
    @section('header-title', 'Booking History')

    <div class="dashboard-card">
        <div class="dashboard-card__header">
            <h3 class="dashboard-card__title">My Booking History</h3>
        </div>
        
        <div class="dashboard-card__content">
            <!-- Filter and Search -->
            <div class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div class="w-full md:w-auto">
                    <div class="relative">
                        <input type="text" placeholder="Search bookings..." class="form-input pl-10 w-full md:w-80">
                        <div class="absolute left-3 top-2.5 text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="flex flex-wrap gap-3">
                    <select class="form-select">
                        <option>All Status</option>
                        <option>Approved</option>
                        <option>Pending</option>
                        <option>Rejected</option>
                        <option>Cancelled</option>
                    </select>
                    <select class="form-select">
                        <option>All Events</option>
                        <option>Musik Jawa Heritage Festival</option>
                        <option>Konser Indonesia Raya 2025</option>
                    </select>
                </div>
            </div>

            <!-- Booking History List -->
            <div class="space-y-4">
                @for ($i = 0; $i < 5; $i++)
                    <div class="booking-card border rounded-lg p-4">
                        <div class="flex flex-col md:flex-row md:items-center justify-between">
                            <div class="flex-1">
                                <div class="flex flex-col md:flex-row md:items-center mb-2">
                                    <h4 class="text-lg font-medium text-gray-900">Musik Jawa Heritage Festival {{ $i+1 }}</h4>
                                    <span class="ml-0 md:ml-4 mt-1 md:mt-0 px-2 py-1 rounded-full text-xs font-medium 
                                        bg-{{ $i % 3 == 0 ? 'green' : ($i % 3 == 1 ? 'yellow' : 'red') }}-100 
                                        text-{{ $i % 3 == 0 ? 'green' : ($i % 3 == 1 ? 'yellow' : 'red') }}-800">
                                        {{ $i % 3 == 0 ? 'Approved' : ($i % 3 == 1 ? 'Pending' : 'Rejected') }}
                                    </span>
                                </div>
                                <div class="text-sm text-gray-600">
                                    <p class="mb-1">Event Date: Nov {{ 20 + $i }}, 2025</p>
                                    <p class="mb-1">Booking Date: Nov {{ 15 - $i }}, 2025</p>
                                    <p>Ticket Type: {{ ['Regular', 'VIP', 'VVIP'][$i % 3] }}, Qty: {{ $i+1 }}</p>
                                </div>
                            </div>
                            <div class="mt-4 md:mt-0 text-right md:text-left">
                                <p class="text-lg font-semibold text-gray-900">Rp {{ number_format((($i+1) * 150000), 0, ',', '.') }}</p>
                                <div class="mt-2 flex flex-col md:flex-row md:space-x-2 space-y-2 md:space-y-0">
                                    <a href="{{ route('user.bookings.show', $i+1) }}" class="btn-outline text-sm py-1.5 px-3">View Details</a>
                                    @if($i % 3 == 1) <!-- Only show cancel for pending bookings -->
                                        <a href="{{ route('user.bookings.cancel', $i+1) }}" class="btn-danger text-sm py-1.5 px-3">Cancel Booking</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>

            <!-- Pagination -->
            <div class="mt-6 flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Showing <span class="font-medium">1</span> to <span class="font-medium">5</span> of <span class="font-medium">12</span> results
                </div>
                <nav class="flex items-center space-x-2">
                    <a href="#" class="px-3 py-2 rounded-md bg-blue-600 text-white">1</a>
                    <a href="#" class="px-3 py-2 rounded-md hover:bg-gray-100">2</a>
                    <a href="#" class="px-3 py-2 rounded-md hover:bg-gray-100">3</a>
                    <span class="px-3 py-2">...</span>
                    <a href="#" class="px-3 py-2 rounded-md hover:bg-gray-100">5</a>
                    <a href="#" class="px-3 py-2 rounded-md hover:bg-gray-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </nav>
            </div>
        </div>
    </div>
</x-user-layout>