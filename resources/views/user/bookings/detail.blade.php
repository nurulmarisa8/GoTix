<x-user-layout>
    @section('header-title', 'Booking Details')

    <div class="dashboard-card">
        <div class="dashboard-card__header">
            <h3 class="dashboard-card__title">Booking Details</h3>
        </div>
        
        <div class="dashboard-card__content">
            <!-- Booking Summary -->
            <div class="bg-gray-50 rounded-lg p-6 mb-6">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                    <div>
                        <h4 class="text-xl font-bold text-gray-900">Booking #B000024</h4>
                        <p class="text-gray-600 mt-1">Booked on November 18, 2025</p>
                    </div>
                    <span class="mt-2 md:mt-0 px-3 py-1 rounded-full text-base font-medium 
                        bg-green-100 text-green-800">
                        Approved
                    </span>
                </div>
            </div>

            <!-- Event and Booking Details -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2">
                    <!-- Event Information -->
                    <div class="bg-white border rounded-lg p-6 mb-6">
                        <h4 class="text-lg font-medium text-gray-900 mb-4">Event Information</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600">Event Name</p>
                                <p class="text-sm font-medium">Musik Jawa Heritage Festival</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Date & Time</p>
                                <p class="text-sm font-medium">November 25, 2025 at 19:00</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Location</p>
                                <p class="text-sm font-medium">Jakarta Convention Center</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Category</p>
                                <p class="text-sm font-medium">Music</p>
                            </div>
                        </div>
                    </div>

                    <!-- Booking Information -->
                    <div class="bg-white border rounded-lg p-6 mb-6">
                        <h4 class="text-lg font-medium text-gray-900 mb-4">Booking Information</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600">Ticket Type</p>
                                <p class="text-sm font-medium">VIP</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Quantity</p>
                                <p class="text-sm font-medium">2</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Price per Ticket</p>
                                <p class="text-sm font-medium">Rp 300.000</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Total Amount</p>
                                <p class="text-sm font-medium font-semibold">Rp 600.000</p>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Information -->
                    <div class="bg-white border rounded-lg p-6">
                        <h4 class="text-lg font-medium text-gray-900 mb-4">Payment Information</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600">Payment Method</p>
                                <p class="text-sm font-medium">Credit Card</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Payment Status</p>
                                <p class="text-sm font-medium text-green-600">Paid</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Transaction ID</p>
                                <p class="text-sm font-medium">TXN-789456123</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Payment Date</p>
                                <p class="text-sm font-medium">November 18, 2025</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Digital Ticket -->
                <div>
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-lg p-6 text-white">
                        <div class="text-center mb-4">
                            <h4 class="text-lg font-bold">Digital Ticket</h4>
                            <p class="text-sm opacity-80">Please show this ticket at the entrance</p>
                        </div>
                        
                        <div class="bg-white p-4 rounded-lg mb-4">
                            <div class="text-center">
                                <div class="flex justify-center mb-3">
                                    <svg class="w-16 h-16 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                                    </svg>
                                </div>
                                <h5 class="font-bold text-gray-900">MUSIK JAWA HERITAGE FESTIVAL</h5>
                                <p class="text-xs text-gray-600">Nov 25, 2025 | 19:00</p>
                                <p class="text-sm font-semibold text-gray-900 mt-2">VIP Ticket</p>
                                <p class="text-xs mt-3">#B000024</p>
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <div class="bg-white text-gray-900 inline-block rounded-md p-2">
                                <div class="font-mono text-xs">QR: B000024_USER1_EVENT1</div>
                            </div>
                            <p class="text-xs mt-2">Scan QR for entry</p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-6 space-y-3">
                        <button class="w-full btn-primary py-2.5">
                            <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            Download Ticket
                        </button>
                        <button class="w-full btn-outline py-2.5">
                            <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                            </svg>
                            Share Ticket
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-user-layout>