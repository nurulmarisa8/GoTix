<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'GoTix') }} - Organizer</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS (via CDN for development) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Scripts -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3B82F6',
                        secondary: '#1D4ED8',
                    }
                }
            }
        }
    </script>
</head>
<body class="font-sans antialiased">
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="p-6">
                <h1 class="text-xl font-bold text-purple-600">GoTix Organizer</h1>
            </div>
            <nav class="sidebar-nav">
                <a href="{{ route('organizer.dashboard') }}" class="sidebar-nav__item {{ request()->routeIs('organizer.dashboard') ? 'active' : '' }}">
                    <svg class="sidebar-nav__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Dashboard
                </a>
                <a href="{{ route('organizer.events.index') }}" class="sidebar-nav__item {{ request()->routeIs('organizer.events.*') ? 'active' : '' }}">
                    <svg class="sidebar-nav__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    My Events
                </a>
                <a href="{{ route('organizer.bookings.index') }}" class="sidebar-nav__item {{ request()->routeIs('organizer.bookings.*') ? 'active' : '' }}">
                    <svg class="sidebar-nav__icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    Bookings
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <header class="header">
                <h2 class="text-xl font-semibold text-gray-800">
                    @yield('header-title', 'Organizer Dashboard')
                </h2>
                <div class="flex items-center">
                    <span class="mr-4 text-gray-600">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-500 hover:text-gray-700">Logout</button>
                    </form>
                </div>
            </header>

            <div class="py-6">
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>