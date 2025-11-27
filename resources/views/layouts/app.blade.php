<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'E-Ticketing') - E-Ticketing</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @yield('styles')
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    <nav class="bg-indigo-800 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2 font-bold text-xl">
                        <span class="text-2xl">🎫</span>
                        <span>E-Ticketing</span>
                    </a>
                </div>

                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        @auth
                            <a href="{{ route('events.index') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-indigo-700 transition">Events</a>
                            <a href="{{ route('bookings.history') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-indigo-700 transition">My Bookings</a>
                            @if(auth()->user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-indigo-700 transition">Admin</a>
                                <a href="{{ route('admin.analytics') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-indigo-700 transition">Analytics</a>
                            @elseif(auth()->user()->role === 'organizer')
                                <a href="{{ route('organizer.events.index') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-indigo-700 transition">My Events</a>
                            @endif
                            <!-- User dropdown -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" @click.away="open = false" class="flex items-center text-sm rounded-full focus:outline-none">
                                    <span class="mr-2">{{ auth()->user()->name }}</span>
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                                <div x-show="open" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50" style="display: none;">
                                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dashboard</a>
                                    <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                                    <form action="{{ route('logout') }}" method="POST" class="block">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-indigo-700 transition">Login</a>
                            <a href="{{ route('register') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-indigo-700 transition bg-indigo-700 hover:bg-indigo-600">Register</a>
                        @endauth
                    </div>
                </div>

                <!-- Mobile menu button -->
                <div class="-mr-2 flex md:hidden">
                    <button id="mobile-menu-button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-indigo-700 focus:outline-none">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path id="menu-open-icon" class="block" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path id="menu-close-icon" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                @auth
                    <a href="{{ route('events.index') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-indigo-700">Events</a>
                    <a href="{{ route('bookings.history') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-indigo-700">My Bookings</a>
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-indigo-700">Admin</a>
                        <a href="{{ route('admin.analytics') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-indigo-700">Analytics</a>
                    @elseif(auth()->user()->role === 'organizer')
                        <a href="{{ route('organizer.events.index') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-indigo-700">My Events</a>
                    @endif
                    <!-- Mobile user dropdown -->
                    <button id="mobile-user-dropdown-btn" class="block w-full text-left px-3 py-2 rounded-md text-base font-medium hover:bg-indigo-700">
                        {{ auth()->user()->name }} ▾
                    </button>
                    <div id="mobile-user-dropdown" class="hidden ml-4 space-y-1">
                        <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-base font-medium hover:bg-indigo-700">Dashboard</a>
                        <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-base font-medium hover:bg-indigo-700">Profile</a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full text-left block px-4 py-2 text-base font-medium hover:bg-indigo-700">Logout</button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-indigo-700">Login</a>
                    <a href="{{ route('register') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-indigo-700 bg-indigo-700 hover:bg-indigo-600">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="flex-grow py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($errors->any())
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    <strong class="font-bold">Error!</strong>
                    <ul class="mt-2 list-disc pl-5 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <footer class="bg-gray-800 text-white py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <p>&copy; {{ date('Y') }} E-Ticketing. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Get all mobile menu toggle buttons
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        const menuOpenIcon = document.getElementById('menu-open-icon');
        const menuCloseIcon = document.getElementById('menu-close-icon');

        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
            menuOpenIcon.classList.toggle('hidden');
            menuOpenIcon.classList.toggle('block');
            menuCloseIcon.classList.toggle('hidden');
            menuCloseIcon.classList.toggle('block');
        });

        // Handle mobile user dropdown
        const mobileUserDropdownBtn = document.getElementById('mobile-user-dropdown-btn');
        const mobileUserDropdown = document.getElementById('mobile-user-dropdown');

        if (mobileUserDropdownBtn && mobileUserDropdown) {
            mobileUserDropdownBtn.addEventListener('click', (e) => {
                e.preventDefault();
                mobileUserDropdown.classList.toggle('hidden');
            });
        }

        // Close mobile menu when clicking outside
        document.addEventListener('click', (event) => {
            if (!mobileMenuButton.contains(event.target) && !mobileMenu.contains(event.target)) {
                mobileMenu.classList.add('hidden');
                menuOpenIcon.classList.remove('hidden');
                menuOpenIcon.classList.add('block');
                menuCloseIcon.classList.add('hidden');
                menuCloseIcon.classList.remove('block');
            }
        });
    </script>

    @yield('scripts')
</body>
</html>