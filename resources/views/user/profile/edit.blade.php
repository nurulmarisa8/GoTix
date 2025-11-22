<x-user-layout>
    @section('header-title', 'Edit Profile')

    <div class="dashboard-card">
        <div class="dashboard-card__header">
            <h3 class="dashboard-card__title">Edit Profile</h3>
        </div>
        
        <div class="dashboard-card__content">
            <form action="{{ route('user.profile.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- First Name -->
                    <div>
                        <label for="first_name" class="form-label">First Name *</label>
                        <input type="text" name="first_name" id="first_name" class="form-input" placeholder="Enter first name" value="{{ old('first_name', auth()->user()->first_name ?? '') }}" required>
                        @error('first_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Last Name -->
                    <div>
                        <label for="last_name" class="form-label">Last Name *</label>
                        <input type="text" name="last_name" id="last_name" class="form-input" placeholder="Enter last name" value="{{ old('last_name', auth()->user()->last_name ?? '') }}" required>
                        @error('last_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="md:col-span-2">
                        <label for="email" class="form-label">Email Address *</label>
                        <input type="email" name="email" id="email" class="form-input" placeholder="Enter email address" value="{{ old('email', auth()->user()->email ?? '') }}" required>
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone Number -->
                    <div>
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="tel" name="phone" id="phone" class="form-input" placeholder="Enter phone number" value="{{ old('phone', auth()->user()->phone ?? '') }}">
                        @error('phone')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date of Birth -->
                    <div>
                        <label for="date_of_birth" class="form-label">Date of Birth</label>
                        <input type="date" name="date_of_birth" id="date_of_birth" class="form-input" value="{{ old('date_of_birth', auth()->user()->date_of_birth ?? '') }}">
                        @error('date_of_birth')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div class="md:col-span-2">
                        <label for="address" class="form-label">Address</label>
                        <textarea name="address" id="address" rows="3" class="form-textarea" placeholder="Enter your address">{{ old('address', auth()->user()->address ?? '') }}</textarea>
                        @error('address')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-8 flex justify-end space-x-3">
                    <a href="{{ route('user.dashboard') }}" class="btn-outline">Cancel</a>
                    <button type="submit" class="btn-primary">Update Profile</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Change Password Section -->
    <div class="dashboard-card mt-8">
        <div class="dashboard-card__header">
            <h3 class="dashboard-card__title">Change Password</h3>
        </div>
        
        <div class="dashboard-card__content">
            <form action="{{ route('user.profile.change-password') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="current_password" class="form-label">Current Password *</label>
                        <input type="password" name="current_password" id="current_password" class="form-input" placeholder="Enter current password" required>
                        @error('current_password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="new_password" class="form-label">New Password *</label>
                        <input type="password" name="new_password" id="new_password" class="form-input" placeholder="Enter new password" required>
                        @error('new_password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="new_password_confirmation" class="form-label">Confirm New Password *</label>
                        <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-input" placeholder="Confirm new password" required>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit" class="btn-primary">Change Password</button>
                </div>
            </form>
        </div>
    </div>
</x-user-layout>