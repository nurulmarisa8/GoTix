@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Edit Profile</h1>

    <form action="{{ route('profile.update') }}" method="POST" class="bg-white shadow-md rounded-lg p-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-gray-700 text-sm font-medium mb-2" for="name">
                    Name
                </label>
                <input class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                       id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required>
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-medium mb-2" for="email">
                    Email
                </label>
                <input class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                       id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required>
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-medium mb-2" for="password">
                New Password (optional)
            </label>
            <input class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                   id="password" name="password" type="password" placeholder="Leave blank to keep current password">
            @error('password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-medium mb-2" for="password_confirmation">
                Confirm New Password
            </label>
            <input class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                   id="password_confirmation" name="password_confirmation" type="password" placeholder="Confirm your new password">
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <button class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-6 rounded-md transition duration-300"
                    type="submit">
                Update Profile
            </button>
            <a class="w-full sm:w-auto text-center sm:text-left inline-block font-medium text-indigo-600 hover:text-indigo-800 py-2 px-4"
               href="{{ route('profile.show') }}">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection