<x-admin-layout>
    @section('header-title', 'Manage Events')

    <!-- Notification Container -->
    <div class="notification-container"></div>

    <div class="mb-6">
        <a href="{{ route('admin.events.create') }}" class="btn-primary">
            <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Create New Event
        </a>
    </div>

    <!-- Search and Filter Controls -->
    <div class="filter-controls mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="filter-controls__group">
                <label class="filter-controls__label">Search Events</label>
                <div class="relative">
                    <input type="text" placeholder="Search by name..." class="filter-controls__select pl-10" id="events-search">
                    <div class="absolute left-3 top-2.5 text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="filter-controls__group">
                <label class="filter-controls__label">Sort By</label>
                <select class="filter-controls__select">
                    <option value="">Default</option>
                    <option value="name">Name</option>
                    <option value="date">Date</option>
                    <option value="organizer">Organizer</option>
                </select>
            </div>
            <div class="filter-controls__group">
                <label class="filter-controls__label">Organizer</label>
                <select class="filter-controls__select">
                    <option value="">All Organizers</option>
                    <option value="1">Organizer 1</option>
                    <option value="2">Organizer 2</option>
                </select>
            </div>
            <div class="filter-controls__group">
                <label class="filter-controls__label">Status</label>
                <select class="filter-controls__select">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Events Table -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200" data-sortable id="events-table">
            <thead class="bg-gray-50">
                <tr>
                    <th data-sort class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th data-sort class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event Name</th>
                    <th data-sort class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Organizer</th>
                    <th data-sort class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tickets Sold</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @for ($i = 0; $i < 10; $i++)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $i+1 }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">Musik Jawa Heritage Festival {{ $i+1 }}</div>
                            <div class="text-sm text-gray-500">Jakarta Convention Center</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Organizer {{ $i+1 }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Nov {{ 20 + $i }}, 2025</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div class="flex items-center">
                                <span class="mr-2">{{ rand(50, 200) }}</span>
                                <div class="w-16 bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ rand(20, 90) }}%"></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('admin.events.edit', $i+1) }}" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                            <a href="{{ route('admin.events.show', $i+1) }}" class="text-green-600 hover:text-green-900 mr-3">View</a>
                            <a href="#" class="text-red-600 hover:text-red-900" onclick="confirmDelete({{ $i+1 }})">Delete</a>
                        </td>
                    </tr>
                @endfor
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6 flex items-center justify-between">
        <div class="text-sm text-gray-700">
            Showing <span class="font-medium">1</span> to <span class="font-medium">10</span> of <span class="font-medium">42</span> results
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
</x-admin-layout>

<script>
function confirmDelete(id) {
    if (confirm('Are you sure you want to delete this event?')) {
        // In a real implementation, you would make an AJAX request to delete the event
        window.showNotification('Event deleted successfully', 'success');
    }
}
</script>