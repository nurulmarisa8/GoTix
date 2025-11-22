@extends('layouts.guest')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-purple-50 to-blue-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div class="auth-form">
                <div class="text-center">
                    <div class="mx-auto h-12 w-12 bg-purple-600 rounded-full flex items-center justify-center">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                    </div>
                    <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                        Create a new account
                    </h2>
                    <p class="mt-2 text-sm text-gray-600">
                        Or
                        <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500">
                            sign in to your existing account
                        </a>
                    </p>
                </div>

                <form class="mt-8 space-y-6" action="{{ route('register') }}" method="POST">
                    @csrf

                    <!-- Name -->
                    <div class="auth-form__input-group">
                        <label for="name" class="form-label">Name</label>
                        <input 
                            id="name" 
                            name="name" 
                            type="text" 
                            required 
                            class="form-input" 
                            placeholder="John Doe"
                            value="{{ old('name') }}"
                        >
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="auth-form__input-group">
                        <label for="email" class="form-label">Email Address</label>
                        <input 
                            id="email" 
                            name="email" 
                            type="email" 
                            autocomplete="email" 
                            required 
                            class="form-input" 
                            placeholder="you@example.com"
                            value="{{ old('email') }}"
                        >
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="auth-form__input-group">
                        <label for="password" class="form-label">Password</label>
                        <input 
                            id="password" 
                            name="password" 
                            type="password" 
                            autocomplete="new-password" 
                            required 
                            class="form-input" 
                            placeholder="••••••••"
                        >
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Confirmation -->
                    <div class="auth-form__input-group">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            type="password" 
                            autocomplete="new-password" 
                            required 
                            class="form-input" 
                            placeholder="••••••••"
                        >
                    </div>

                    <!-- User Type -->
                    <div class="auth-form__input-group">
                        <label for="user_type" class="form-label">Register as</label>
                        <select 
                            id="user_type" 
                            name="user_type" 
                            required 
                            class="form-input"
                        >
                            <option value="">Select User Type</option>
                            <option value="user" {{ old('user_type') == 'user' ? 'selected' : '' }}>User (Attendee)</option>
                            <option value="organizer" {{ old('user_type') == 'organizer' ? 'selected' : '' }}>Event Organizer</option>
                        </select>
                        @error('user_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center">
                        <input 
                            id="terms" 
                            name="terms" 
                            type="checkbox" 
                            required 
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded mr-2"
                        >
                        <label for="terms" class="text-sm text-gray-700">
                            I agree to the <a href="#" class="text-blue-600 hover:text-blue-500">Terms of Service</a> and <a href="#" class="text-blue-600 hover:text-blue-500">Privacy Policy</a>
                        </label>
                    </div>

                    @error('terms')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <div>
                        <button type="submit" class="auth-form__button">
                            Register
                        </button>
                    </div>
                </form>

                <div class="auth-form__footer">
                    <p class="text-sm text-gray-600">
                        Already have an account?
                        <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500">
                            Sign in
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection