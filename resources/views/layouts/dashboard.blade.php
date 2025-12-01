<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - GoTix</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-slate-900 text-white antialiased">

    <div class="flex h-screen overflow-hidden">
        
        <aside class="w-64 bg-slate-950 border-r border-slate-800 hidden md:flex flex-col flex-shrink-0">
            <div class="p-6 text-center border-b border-slate-800">
                <a href="{{ route('home') }}">
                    <h1 class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-600 hover:opacity-80 transition">
                        GoTix Admin
                    </h1>
                </a>
            </div>
            
            <nav class="flex-1 p-4 space-y-2 overflow-y-auto custom-scrollbar">
                
                {{-- MENU ADMIN --}}
                @if(Auth::user()->role === 'admin')
                    <p class="text-xs text-slate-500 uppercase font-bold px-4 mt-4 mb-2 tracking-wider">Administrator</p>
                    
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2.5 rounded-lg hover:bg-slate-800 text-slate-300 hover:text-white transition group {{ request()->routeIs('admin.dashboard') ? 'bg-slate-800 text-white' : '' }}">
                        <span class="mr-3">📊</span> Dashboard
                    </a>
                    
                    <a href="{{ route('admin.users') }}" class="flex items-center px-4 py-2.5 rounded-lg hover:bg-slate-800 text-slate-300 hover:text-white transition group {{ request()->routeIs('admin.users*') ? 'bg-slate-800 text-white' : '' }}">
                        <span class="mr-3">👥</span> Manage Users
                    </a>

                    <a href="{{ route('admin.events.index') }}" class="flex items-center px-4 py-2.5 rounded-lg hover:bg-slate-800 text-slate-300 hover:text-white transition group {{ request()->routeIs('admin.events*') ? 'bg-slate-800 text-white' : '' }}">
                        <span class="mr-3">🎉</span> Manage Events
                    </a>

                    <a href="{{ route('admin.reports') }}" class="flex items-center px-4 py-2.5 rounded-lg hover:bg-slate-800 text-slate-300 hover:text-white transition group {{ request()->routeIs('admin.reports') ? 'bg-slate-800 text-white' : '' }}">
                        <span class="mr-3">📈</span> Laporan Penjualan
                    </a>
                @endif

                {{-- MENU ORGANIZER --}}
                @if(Auth::user()->role === 'organizer' && Auth::user()->organizer_status === 'approved')
                    <p class="text-xs text-slate-500 uppercase font-bold px-4 mt-4 mb-2 tracking-wider">Event Organizer</p>
                    
                    <a href="{{ route('organizer.dashboard') }}" class="flex items-center px-4 py-2.5 rounded-lg hover:bg-slate-800 text-slate-300 hover:text-white transition group {{ request()->routeIs('organizer.dashboard') ? 'bg-slate-800 text-white' : '' }}">
                        <span class="mr-3">⚡</span> Dashboard
                    </a>
                    
                    <a href="{{ route('organizer.events.index') }}" class="flex items-center px-4 py-2.5 rounded-lg hover:bg-slate-800 text-slate-300 hover:text-white transition group {{ request()->routeIs('organizer.events*') ? 'bg-slate-800 text-white' : '' }}">
                        <span class="mr-3">🎤</span> My Events
                    </a>
                @endif

                {{-- MENU USER --}}
                @if(Auth::user()->role === 'user')
                    <p class="text-xs text-slate-500 uppercase font-bold px-4 mt-4 mb-2 tracking-wider">Pengunjung</p>
                    <a href="{{ route('booking.history') }}" class="flex items-center px-4 py-2.5 rounded-lg hover:bg-slate-800 text-slate-300 hover:text-white transition group {{ request()->routeIs('booking.history') ? 'bg-slate-800 text-white' : '' }}">
                        <span class="mr-3">🎟️</span> Riwayat Tiket
                    </a>
                @endif
                
                {{-- MENU UMUM (LOGOUT & HOME) --}}
                <div class="mt-8 border-t border-slate-800 pt-4">
                    <a href="{{ route('home') }}" class="flex items-center px-4 py-2.5 text-sm text-slate-400 hover:text-white transition hover:bg-slate-800 rounded-lg">
                        <span class="mr-3">🏠</span> Kembali ke Home
                    </a>
                    
                    <form method="POST" action="{{ route('logout') }}" class="mt-2">
                        @csrf
                        <button class="w-full flex items-center px-4 py-2.5 text-red-400 hover:bg-red-900/20 hover:text-red-300 rounded-lg transition text-sm font-bold">
                            <span class="mr-3">🚪</span> Logout
                        </button>
                    </form>
                </div>
            </nav>
        </aside>

        <div class="flex-1 flex flex-col overflow-y-auto bg-slate-900 scroll-smooth">
            
            <header class="bg-slate-950 border-b border-slate-800 p-4 flex justify-between items-center md:hidden sticky top-0 z-20 shadow-md">
                <a href="{{ route('home') }}">
                    <span class="font-bold text-xl text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-600">GoTix</span>
                </a>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-xs text-red-400 border border-red-900 px-3 py-1 rounded hover:bg-red-900/20">Logout</button>
                </form>
            </header>
            
            <main class="p-6 md:p-8 min-h-screen">
                
                @if(session('success'))
                    <div class="bg-green-500/10 border border-green-500/50 text-green-400 px-4 py-3 rounded-xl mb-6 flex items-center shadow-lg shadow-green-900/10 animate-fade-in-down">
                        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-500/10 border border-red-500/50 text-red-400 px-4 py-3 rounded-xl mb-6 flex items-center shadow-lg shadow-red-900/10 animate-fade-in-down">
                        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        <span class="font-medium">{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

</body>
</html>