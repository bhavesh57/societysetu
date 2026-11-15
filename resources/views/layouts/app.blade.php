<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SocietySetu')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 text-slate-800 antialiased min-h-screen">
    <div class="mobile-shell-container flex flex-col min-h-screen pb-20">
        <!-- Top App Bar -->
        <header class="bg-teal-700 text-white px-4 py-3 sticky top-0 z-40 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center space-x-1.5">
                        <span class="w-6 h-6 rounded bg-teal-500/40 flex items-center justify-center font-black text-xs text-white">SS</span>
                        <h1 class="text-sm font-bold tracking-tight truncate max-w-[200px]">
                            {{ session('current_society_name', 'SocietySetu') }}
                        </h1>
                    </div>
                    <div class="flex items-center space-x-2 mt-0.5 text-[11px] text-teal-100">
                        <span class="px-1.5 py-0.2 rounded bg-teal-800/80 font-mono font-semibold">{{ session('current_society_code') }}</span>
                        <span>&bull;</span>
                        <span class="capitalize">{{ Auth::user()->name }}</span>
                    </div>
                </div>

                <div class="flex items-center space-x-2">
                    <form method="POST" action="{{ route('app.logout') }}" class="inline">
                        @csrf
                        <button type="submit" title="Logout" class="p-1.5 rounded-full hover:bg-teal-600 text-teal-100 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Role Switcher Pill Bar (if multiple roles exist for this member) -->
            @php
                $roles = session('available_roles', []);
                $activeRole = session('active_role', '');
            @endphp
            @if(count($roles) > 1)
                <div class="mt-2.5 pt-2 border-t border-teal-600/60 flex items-center justify-between">
                    <span class="text-[11px] font-medium text-teal-200 uppercase tracking-wider">Switch Role:</span>
                    <div class="inline-flex rounded-lg bg-teal-900/60 p-0.5 text-xs">
                        @foreach($roles as $r)
                            <a href="{{ route('app.switch_role', $r) }}"
                               class="px-2.5 py-1 rounded-md font-medium transition {{ $activeRole === $r ? 'bg-white text-teal-900 shadow-xs' : 'text-teal-200 hover:text-white' }}">
                                @if($r === 'committee_member') Committee
                                @elseif($r === 'house_owner') Owner
                                @elseif($r === 'tenant') Tenant
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="mt-1 flex items-center justify-between text-[11px] text-teal-200">
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-teal-800/90 text-teal-100 capitalize font-medium">
                        Role: {{ str_replace('_', ' ', $activeRole) }}
                    </span>
                </div>
            @endif
        </header>

        <!-- Flash Alert Messages -->
        <div class="px-4 pt-3">
            @if(session('success'))
                <div class="mb-3 rounded-lg bg-emerald-50 border border-emerald-200 p-3 text-emerald-800 text-xs font-medium flex items-center space-x-2 shadow-xs">
                    <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-3 rounded-lg bg-red-50 border border-red-200 p-3 text-red-800 text-xs font-medium flex items-center space-x-2 shadow-xs">
                    <svg class="w-4 h-4 text-red-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif
        </div>

        <!-- Main Body Content -->
        <main class="flex-1 px-4 py-2">
            @yield('content')
        </main>

        <!-- Bottom Touch Navigation Bar (Native Mobile Experience) -->
        <nav class="fixed bottom-0 left-0 right-0 z-40 bg-white border-t border-slate-200 shadow-lg">
            <div class="max-w-[440px] mx-auto flex items-center justify-around h-16">
                @if(session('active_role') === 'committee_member')
                    <a href="{{ route('committee.dashboard') }}" class="flex flex-col items-center justify-center flex-1 py-1 {{ request()->routeIs('committee.dashboard') ? 'text-teal-600 font-semibold' : 'text-slate-500 hover:text-slate-700' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        <span class="text-[10px] mt-1">Home</span>
                    </a>
                    <a href="{{ route('committee.properties.index') }}" class="flex flex-col items-center justify-center flex-1 py-1 {{ request()->routeIs('committee.properties.*') ? 'text-teal-600 font-semibold' : 'text-slate-500 hover:text-slate-700' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        <span class="text-[10px] mt-1">Houses</span>
                    </a>
                    <a href="{{ route('committee.members.directory') }}" class="flex flex-col items-center justify-center flex-1 py-1 {{ request()->routeIs('committee.members.*') ? 'text-teal-600 font-semibold' : 'text-slate-500 hover:text-slate-700' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        <span class="text-[10px] mt-1">Members</span>
                    </a>
                    <a href="{{ route('committee.newsletters.index') }}" class="flex flex-col items-center justify-center flex-1 py-1 {{ request()->routeIs('committee.newsletters.*') ? 'text-teal-600 font-semibold' : 'text-slate-500 hover:text-slate-700' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                        <span class="text-[10px] mt-1">Notices</span>
                    </a>
                    <a href="{{ route('committee.complaints.index') }}" class="flex flex-col items-center justify-center flex-1 py-1 {{ request()->routeIs('committee.complaints.*') ? 'text-teal-600 font-semibold' : 'text-slate-500 hover:text-slate-700' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        <span class="text-[10px] mt-1">Complaints</span>
                    </a>
                @elseif(session('active_role') === 'house_owner')
                    <a href="{{ route('owner.dashboard') }}" class="flex flex-col items-center justify-center flex-1 py-1 {{ request()->routeIs('owner.dashboard') ? 'text-teal-600 font-semibold' : 'text-slate-500 hover:text-slate-700' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        <span class="text-[10px] mt-1">Home</span>
                    </a>
                    <a href="{{ route('owner.tenants.index') }}" class="flex flex-col items-center justify-center flex-1 py-1 {{ request()->routeIs('owner.tenants.*') ? 'text-teal-600 font-semibold' : 'text-slate-500 hover:text-slate-700' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        <span class="text-[10px] mt-1">My Tenants</span>
                    </a>
                    <a href="{{ route('owner.newsletters.index') }}" class="flex flex-col items-center justify-center flex-1 py-1 {{ request()->routeIs('owner.newsletters.*') ? 'text-teal-600 font-semibold' : 'text-slate-500 hover:text-slate-700' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                        <span class="text-[10px] mt-1">Notices</span>
                    </a>
                    <a href="{{ route('owner.complaints.index') }}" class="flex flex-col items-center justify-center flex-1 py-1 {{ request()->routeIs('owner.complaints.*') ? 'text-teal-600 font-semibold' : 'text-slate-500 hover:text-slate-700' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        <span class="text-[10px] mt-1">Complaints</span>
                    </a>
                @elseif(session('active_role') === 'tenant')
                    <a href="{{ route('tenant.dashboard') }}" class="flex flex-col items-center justify-center flex-1 py-1 {{ request()->routeIs('tenant.dashboard') ? 'text-teal-600 font-semibold' : 'text-slate-500 hover:text-slate-700' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        <span class="text-[10px] mt-1">Home</span>
                    </a>
                    <a href="{{ route('tenant.newsletters.index') }}" class="flex flex-col items-center justify-center flex-1 py-1 {{ request()->routeIs('tenant.newsletters.*') ? 'text-teal-600 font-semibold' : 'text-slate-500 hover:text-slate-700' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                        <span class="text-[10px] mt-1">Notices</span>
                    </a>
                    <a href="{{ route('tenant.complaints.index') }}" class="flex flex-col items-center justify-center flex-1 py-1 {{ request()->routeIs('tenant.complaints.*') ? 'text-teal-600 font-semibold' : 'text-slate-500 hover:text-slate-700' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        <span class="text-[10px] mt-1">Complaints</span>
                    </a>
                @endif
            </div>
        </nav>
    </div>
</body>
</html>
