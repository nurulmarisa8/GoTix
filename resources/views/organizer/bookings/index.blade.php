<x-organizer-layout>
    @section('header-title', 'Manage Event Bookings')

    <div class="dashboard-card">
        <div class="dashboard-card__header">
            <h3 class="dashboard-card__title">Event Bookings</h3>
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
                        <option>All Events</option>
                        <option>Musik Jawa Heritage Festival 1</option>
                        <option>Konser Indonesia Raya 2025</option>
                    </select>
                    <select class="form-select">
                        <option>All Status</option>
                        <option>Approved</option>
                        <option>Pending</option>
                        <option>Rejected</option>
                        <option>Cancelled</option>
                    </select>
                </div>
            </div>

            <!-- Bookings Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200" data-sortable id="bookings-table">
                    <thead>
                        <tr>
                            <th data-sort class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Booking ID</th>
                            <th data-sort class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event</th>
                            <th data-sort class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                            <th data-sort class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ticket Type</th>
                            <th data-sort class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                            <th data-sort class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            <th data-sort class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @for ($i = 0; $i < 10; $i++)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#B{{ str_pad($i+1, 6, '0', STR_PAD_LEFT) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">Musik Jawa Heritage Festival {{ $i+1 }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">User {{ $i+1 }}</div>
                                    <div class="text-sm text-gray-500">user{{ $i+1 }}@example.com</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ ['Regular', 'VIP', 'VVIP'][$i % 3] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $i % 5 + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp {{ number_format((($i+1) * 150000), 0, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        bg-{{ $i % 3 == 0 ? 'green' : ($i % 3 == 1 ? 'yellow' : 'red') }}-100 
                                        text-{{ $i % 3 == 0 ? 'green' : ($i % 3 == 1 ? 'yellow' : 'red') }}-800">
                                        {{ $i % 3 == 0 ? 'Approved' : ($i % 3 == 1 ? 'Pending' : 'Rejected') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('organizer.bookings.manage-status', $i+1) }}" class="text-blue-600 hover:text-blue-900 mr-3">Manage</a>
                                    <a href="{{ route('organizer.bookings.show', $i+1) }}" class="text-green-600 hover:text-green-900">View</a>
                                </td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6 flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Showing <span class="font-medium">1</span> to <span class="font-medium">10</span> of <span class="font-medium">24</span> results
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
</x-organizer-layout>