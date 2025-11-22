@extends('layouts.guest')

@section('content')
    <div class="max-w-md mx-auto bg-white p-8 rounded-xl shadow-md">
        <div class="text-center">
            <div class="mx-auto w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mb-6">
                <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Account Pending Review</h1>
            <p class="text-gray-600 mb-6">Your request to become an Event Organizer is currently under review by our administrators. Please wait for approval.</p>
            
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <p class="text-blue-800 text-sm">We will notify you via email once your account status changes.</p>
            </div>

            @if(session('status') === 'rejected')
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                    <p class="text-red-800 text-sm">Your organizer application has been rejected. You may delete your account if you wish.</p>
                </div>
                
                <form method="POST" action="{{ route('organizer.delete-account') }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-md transition duration-300">
                        Delete Account
                    </button>
                </form>
            @endif
        </div>
    </div>
@endsection