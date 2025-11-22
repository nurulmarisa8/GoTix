<x-organizer-layout>
    @section('header-title', 'Create New Event')

    <div class="dashboard-card">
        <div class="dashboard-card__header">
            <h3 class="dashboard-card__title">Create New Event</h3>
        </div>
        
        <div class="dashboard-card__content">
            <form action="{{ route('organizer.events.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Event Name -->
                    <div class="md:col-span-2">
                        <label for="name" class="form-label">Event Name *</label>
                        <input type="text" name="name" id="name" class="form-input" placeholder="Enter event name" required>
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label for="description" class="form-label">Description *</label>
                        <textarea name="description" id="description" rows="4" class="form-textarea" placeholder="Enter event description" required></textarea>
                        @error('description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date and Time -->
                    <div>
                        <label for="date_time" class="form-label">Date and Time *</label>
                        <input type="datetime-local" name="date_time" id="date_time" class="form-input" required>
                        @error('date_time')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Location -->
                    <div>
                        <label for="location" class="form-label">Location *</label>
                        <input type="text" name="location" id="location" class="form-input" placeholder="Enter event location" required>
                        @error('location')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div>
                        <label for="category" class="form-label">Category *</label>
                        <select name="category" id="category" class="form-select" required>
                            <option value="">Select Category</option>
                            <option value="music">Music</option>
                            <option value="conference">Conference</option>
                            <option value="workshop">Workshop</option>
                            <option value="expo">Expo</option>
                            <option value="sports">Sports</option>
                            <option value="arts">Arts & Culture</option>
                        </select>
                        @error('category')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Image -->
                    <div>
                        <label for="image" class="form-label">Event Image</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                        <span>Upload a file</span>
                                        <input id="image" name="image" type="file" class="sr-only">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                            </div>
                        </div>
                        @error('image')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-8 flex justify-end space-x-3">
                    <a href="{{ route('organizer.events.index') }}" class="btn-outline">Cancel</a>
                    <button type="submit" class="btn-primary">Create Event</button>
                </div>
            </form>
        </div>
    </div>
</x-organizer-layout>