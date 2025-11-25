@extends('layouts.guest')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Hero Section -->
        <div class="text-center mb-16">
            <h1 class="text-4xl font-bold text-gray-900 mb-6">About GoTix</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Your trusted platform for discovering and booking tickets to amazing events. 
                We connect event organizers with passionate audiences, creating unforgettable experiences.
            </p>
        </div>

        <!-- Mission Section -->
        <div class="bg-white rounded-xl shadow-md p-8 mb-16">
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/2 mb-8 md:mb-0 md:pr-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Our Mission</h2>
                    <p class="text-gray-600 mb-4">
                        At GoTix, we believe that life's most memorable moments happen at events that bring people together. 
                        Our mission is to simplify the process of discovering, booking, and attending events, 
                        while supporting event organizers with powerful tools and services.
                    </p>
                    <p class="text-gray-600">
                        We're committed to providing a seamless and secure ticketing experience for both event attendees and organizers.
                    </p>
                </div>
                <div class="md:w-1/2">
                    <img src="https://via.placeholder.com/600x400" alt="Our Mission" class="w-full h-auto rounded-lg shadow-lg">
                </div>
            </div>
        </div>

        <!-- Values Section -->
        <div class="mb-16">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Our Core Values</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-xl shadow-md text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Trust & Security</h3>
                    <p class="text-gray-600">We prioritize the security and privacy of our users, providing trusted and secure transactions for every booking.</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-md text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Customer Focus</h3>
                    <p class="text-gray-600">We put our customers at the center of everything we do, constantly improving our platform to enhance user experience.</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-md text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Innovation</h3>
                    <p class="text-gray-600">We continuously innovate to provide cutting-edge solutions for event management and ticketing.</p>
                </div>
            </div>
        </div>

        <!-- Team Section -->
        <div class="bg-white rounded-xl shadow-md p-8 mb-16">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Meet Our Team</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @for ($i = 0; $i < 4; $i++)
                    <div class="text-center">
                        <div class="w-32 h-32 bg-gray-200 rounded-full mx-auto mb-4 overflow-hidden">
                            <img src="https://via.placeholder.com/300x300" alt="Team Member" class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-xl font-semibold">Team Member {{$i+1}}</h3>
                        <p class="text-gray-600">Position {{$i+1}}</p>
                    </div>
                @endfor
            </div>
        </div>

        <!-- Contact Section -->
        <div class="bg-blue-50 rounded-xl p-8 text-center">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Get In Touch</h2>
            <p class="text-gray-600 mb-6 max-w-2xl mx-auto">
                Have questions about our platform or want to learn more about our services? 
                We're here to help and ready to answer all your queries.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="mailto:info@gotix.com" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-md text-base font-medium">
                    Email Us
                </a>
                <a href="tel:+621234567890" class="inline-block bg-white hover:bg-gray-100 text-blue-600 border border-blue-600 px-6 py-3 rounded-md text-base font-medium">
                    Call Us
                </a>
            </div>
        </div>
    </div>
@endsection