<x-organizer-layout>
    @section('header-title', 'Manage Booking Status')

    <div class="dashboard-card">
        <div class="dashboard-card__header">
            <h3 class="dashboard-card__title">Manage Booking Status</h3>
        </div>
        
        <div class="dashboard-card__content">
            <!-- Booking Details -->
            <div class="bg-gray-50 rounded-lg p-6 mb-6">
                <h4 class="text-lg font-medium text-gray-900 mb-4">Booking Details</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-600">Booking ID</p>
                        <p class="text-sm font-medium">#B000001</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Booking Date</p>
                        <p class="text-sm font-medium">Nov 18, 2025</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Event</p>
                        <p class="text-sm font-medium">Musik Jawa Heritage Festival 1</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Event Date</p>
                        <p class="text-sm font-medium">Nov 25, 2025</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Customer</p>
                        <p class="text-sm font-medium">User 1</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Email</p>
                        <p class="text-sm font-medium">user1@example.com</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Ticket Type</p>
                        <p class="text-sm font-medium">VIP</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Quantity</p>
                        <p class="text-sm font-medium">2</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-sm text-gray-600">Total Amount</p>
                        <p class="text-sm font-medium">Rp 600.000</p>
                    </div>
                </div>
            </div>

            <!-- Current Status and Update Form -->
            <div class="bg-white rounded-lg border p-6">
                <h4 class="text-lg font-medium text-gray-900 mb-4">Update Booking Status</h4>
                
                <form action="{{ route('organizer.bookings.update-status', $booking->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-6">
                        <label class="form-label">Current Status</label>
                        <div class="flex items-center">
                            <span class="px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">Pending</span>
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <label for="status" class="form-label">New Status *</label>
                        <select name="status" id="status" class="form-select" required>
                            <option value="">Select Status</option>
                            <option value="approved">Approve Booking</option>
                            <option value="rejected">Reject Booking</option>
                            <option value="cancelled">Cancel Booking</option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-6">
                        <label for="notes" class="form-label">Notes (Optional)</label>
                        <textarea name="notes" id="notes" rows="3" class="form-textarea" placeholder="Add any notes about this status update"></textarea>
                    </div>
                    
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('organizer.bookings.index') }}" class="btn-outline">Cancel</a>
                        <button type="submit" class="btn-primary">Update Status</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-organizer-layout>