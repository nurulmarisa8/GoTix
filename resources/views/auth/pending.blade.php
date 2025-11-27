@extends('layouts.app')
@section('title', 'Account Pending')

@section('content')
<div class="flex items-center justify-center min-h-96 py-12">
    <div class="w-full max-w-md bg-white rounded-xl shadow-md border border-gray-200 p-8">
        <div class="text-center">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-yellow-100">
                <span class="text-3xl">⏳</span>
            </div>
            <h2 class="mt-4 text-2xl font-bold text-gray-900">Account Under Review</h2>
            <p class="mt-2 text-gray-600">
                Your organizer account is currently pending admin approval.
                You will be notified once your account has been reviewed.
            </p>

            <div class="mt-6 bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-lg">
                <strong class="font-semibold">What's next?</strong><br>
                An admin will review your request and approve or reject it.
                This usually takes 24-48 hours.
            </div>

            @if(auth()->user()->organizer_status === 'rejected')
                <div class="mt-4 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
                    Your organizer application has been rejected.
                </div>
                <form action="{{ route('logout') }}" method="POST" class="mt-6">
                    @csrf
                    <button type="submit" class="w-full px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Delete Account & Logout
                    </button>
                </form>
            @else
                <form action="{{ route('logout') }}" method="POST" class="mt-6">
                    @csrf
                    <button type="submit" class="w-full px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Logout
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection