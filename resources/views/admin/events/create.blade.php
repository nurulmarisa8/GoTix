<x-admin-layout>
    @section('header-title', 'Create New Event')

    <div class="max-w-3xl mx-auto">
        <div class="dashboard-card">
            <div class="dashboard-card__header">
                <h3 class="dashboard-card__title">Create New Event</h3>
            </div>
            <div class="dashboard-card__content">
                <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-form.input name="name" label="Event Name" required placeholder="Enter event name" />
                        </div>
                        <div>
                            <x-form.input name="location" label="Location" required placeholder="Enter event location" />
                        </div>
                        <div>
                            <x-form.input name="date_time" label="Date & Time" type="datetime-local" required />
                        </div>
                        <div>
                            <x-form.select name="category" label="Category" required :options="[
                                'music' => 'Music',
                                'conference' => 'Conference',
                                'workshop' => 'Workshop',
                                'expo' => 'Expo',
                                'sports' => 'Sports'
                            ]" />
                        </div>
                    </div>
                    
                    <x-form.textarea name="description" label="Description" required placeholder="Enter event description" rows="4" />
                    
                    <div class="mb-4">
                        <label class="form-label">Event Image</label>
                        <div class="flex items-center">
                            <div class="flex-1 mr-4">
                                <input 
                                    type="file" 
                                    name="image" 
                                    class="form-input" 
                                    data-preview="image-preview"
                                >
                                @error('image')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="w-32 h-20 border border-gray-300 rounded-md overflow-hidden">
                                <img id="image-preview" src="https://via.placeholder.com/128x80" alt="Preview" class="w-full h-full object-cover">
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('admin.events.index') }}" class="btn-secondary">Cancel</a>
                        <button type="submit" class="btn-primary" data-loading>Create Event</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>