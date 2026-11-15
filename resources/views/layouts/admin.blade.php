<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Portal') | SocietySetu</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col">
    <!-- Admin Top Navbar -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-30 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2">
                    <span class="w-9 h-9 rounded-lg bg-teal-600 flex items-center justify-center text-white font-bold text-lg shadow-sm">
                        SS
                    </span>
                    <span class="font-bold text-xl tracking-tight text-slate-900">
                        Society<span class="text-teal-600">Setu</span>
                        <span class="ml-1 text-xs font-semibold px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 border border-slate-200">Admin</span>
                    </span>
                </a>
            </div>

            <nav class="hidden md:flex items-center space-x-1">
                <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-teal-50 text-teal-700 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                    Dashboard
                </a>
                <a href="{{ route('admin.societies.index') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin.societies.*') ? 'bg-teal-50 text-teal-700 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                    Societies
                </a>
                <a href="{{ route('admin.monitoring') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin.monitoring') ? 'bg-teal-50 text-teal-700 font-semibold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                    Global Monitoring
                </a>
            </nav>

            <div class="flex items-center space-x-4">
                <div class="hidden sm:flex flex-col text-right">
                    <span class="text-sm font-semibold text-slate-900">{{ Auth::user()->name }}</span>
                    <span class="text-xs text-slate-500">Super Administrator</span>
                </div>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="px-3 py-1.5 text-xs font-semibold rounded-md border border-slate-200 text-slate-700 hover:bg-slate-100 transition">
                        Sign Out
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Toast / Alerts -->
        @if(session('success'))
            <div class="mb-6 rounded-lg bg-emerald-50 border border-emerald-200 p-4 text-emerald-800 flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 rounded-lg bg-red-50 border border-red-200 p-4 text-red-800 flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5 text-red-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    <span class="text-sm font-medium">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="bg-white border-t border-slate-200 py-6 text-center text-xs text-slate-500">
        &copy; {{ date('Y') }} SocietySetu Multi-Tenant Platform &bull; Built with Laravel & NativePHP
    </footer>
</body>
</html>
