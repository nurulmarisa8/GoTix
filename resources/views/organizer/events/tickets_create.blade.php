<x-organizer-layout>
    @section('header-title', 'Create Ticket for Event')

    <div class="dashboard-card">
        <div class="dashboard-card__header">
            <h3 class="dashboard-card__title">Create Ticket for Event: {{ $event->name ?? 'Event Name' }}</h3>
        </div>
        
        <div class="dashboard-card__content">
            <form action="{{ route('organizer.events.store-ticket', $event->id) }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Ticket Name -->
                    <div>
                        <label for="ticket_name" class="form-label">Ticket Name *</label>
                        <input type="text" name="ticket_name" id="ticket_name" class="form-input" placeholder="Enter ticket name (e.g., Regular, VIP, etc.)" required>
                        @error('ticket_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Ticket Type -->
                    <div>
                        <label for="ticket_type" class="form-label">Ticket Type</label>
                        <select name="ticket_type" id="ticket_type" class="form-select">
                            <option value="regular">Regular</option>
                            <option value="vip">VIP</option>
                            <option value="vvip">VVIP</option>
                            <option value="early_bird">Early Bird</option>
                            <option value="student">Student</option>
                        </select>
                        @error('ticket_type')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" rows="3" class="form-textarea" placeholder="Enter ticket description (optional)"></textarea>
                        @error('description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Price -->
                    <div>
                        <label for="price" class="form-label">Price (Rp) *</label>
                        <input type="number" name="price" id="price" class="form-input" placeholder="Enter ticket price" min="0" required>
                        @error('price')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Quota -->
                    <div>
                        <label for="quota" class="form-label">Quota *</label>
                        <input type="number" name="quota" id="quota" class="form-input" placeholder="Enter ticket quota" min="1" required>
                        @error('quota')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Sale Dates -->
                    <div>
                        <label for="sale_start_date" class="form-label">Sale Start Date *</label>
                        <input type="datetime-local" name="sale_start_date" id="sale_start_date" class="form-input" required>
                        @error('sale_start_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="sale_end_date" class="form-label">Sale End Date *</label>
                        <input type="datetime-local" name="sale_end_date" id="sale_end_date" class="form-input" required>
                        @error('sale_end_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-8 flex justify-end space-x-3">
                    <a href="{{ route('organizer.events.index') }}" class="btn-outline">Cancel</a>
                    <button type="submit" class="btn-primary">Create Ticket</button>
                </div>
            </form>
        </div>
    </div>
</x-organizer-layout>