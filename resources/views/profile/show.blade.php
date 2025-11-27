@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">My Profile</h1>

    <div class="bg-white shadow-md rounded-lg p-6">
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-medium mb-2" for="name">
                Name
            </label>
            <p class="text-gray-900">{{ $user->name }}</p>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-medium mb-2" for="email">
                Email
            </label>
            <p class="text-gray-900">{{ $user->email }}</p>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-medium mb-2" for="role">
                Role
            </label>
            <p class="text-gray-900 capitalize">{{ $user->role }}</p>
        </div>

        <div class="flex">
            <a href="{{ route('profile.edit') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-6 rounded-md transition duration-300">
                Edit Profile
            </a>
        </div>
    </div>
</div>
@endsection