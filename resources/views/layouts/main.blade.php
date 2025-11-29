<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GoTix - Music Event Ticketing</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-slate-900 text-white antialiased selection:bg-pink-500 selection:text-white">

    <nav class="fixed w-full z-50 top-0 start-0 border-b border-white/10 bg-slate-900/80 backdrop-blur-md">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="{{ route('home') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
                <span class="self-center text-2xl font-bold whitespace-nowrap text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-600">
                    GoTix 🎵
                </span>
            </a>
            
            <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse gap-4">
                @auth
                    <div class="flex items-center gap-4">
                        <span class="text-sm text-slate-300 hidden md:block">Hi, {{ Auth::user()->name }}</span>
                        
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="text-white bg-purple-700 hover:bg-purple-800 px-4 py-2 rounded-lg text-sm">Dashboard</a>
                        @elseif(Auth::user()->role === 'organizer')
                             <a href="{{ route('organizer.dashboard') }}" class="text-white bg-purple-700 hover:bg-purple-800 px-4 py-2 rounded-lg text-sm">Dashboard</a>
                        @else
                            <a href="{{ route('booking.history') }}" class="text-sm text-purple-400 hover:text-purple-300">Tiket Saya</a>
                        @endif

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-sm text-slate-400 hover:text-white border border-slate-600 hover:bg-slate-800 px-3 py-2 rounded-lg transition">Logout</button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-white bg-gradient-to-r from-purple-600 to-pink-600 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center transition-all">
                        Login / Register
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="mt-20 min-h-screen">
        @yield('content')
    </div>

    <footer class="bg-slate-950 rounded-lg shadow m-4 mt-10">
        <div class="w-full max-w-screen-xl mx-auto p-4 md:py-8">
            <span class="block text-sm text-gray-500 sm:text-center">© 2025 <a href="#" class="hover:underline">GoTix™</a>. All Rights Reserved.</span>
        </div>
    </footer>

</body>
</html>