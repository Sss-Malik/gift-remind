<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - GiftSync</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-stone-50 text-stone-700" x-data="{ sidebarOpen: false }">

<div class="min-h-screen flex flex-col md:flex-row">

    <div class="md:hidden bg-white border-b border-stone-200 p-4 flex justify-between items-center sticky top-0 z-20">
        <div class="flex items-center gap-2 font-bold text-stone-900">
            <div class="w-6 h-6 bg-brand-600 rounded rotate-3"></div>
            <span>Gift<span class="text-brand-600">Sync</span></span>
        </div>
        <button @click="sidebarOpen = !sidebarOpen" class="text-stone-500 hover:text-brand-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
        </button>
    </div>

    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
           class="fixed inset-y-0 left-0 z-30 w-64 bg-white border-r border-stone-200 transform md:translate-x-0 transition-transform duration-200 ease-in-out md:static md:h-screen flex flex-col">

        <div class="h-16 flex items-center px-6 border-b border-stone-100 hidden md:flex">
            <div class="flex items-center gap-2 font-bold text-xl text-stone-900">
                <div class="w-8 h-8 bg-brand-600 rounded-lg shadow-sm rotate-3"></div>
                <span>Gift<span class="text-brand-600">Sync</span></span>
            </div>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">

            @if(Auth::user()->role === 'admin' || Auth::user()->role === 'sub_admin')
                <div class="pt-4 mt-4 border-t border-stone-100">
                    <p class="px-4 text-xs font-bold text-stone-400 uppercase mb-2">Administration</p>

                    <a href="{{ route('admin.dashboard') }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-stone-900 text-white shadow-md' : 'text-stone-600 hover:bg-stone-50 hover:text-stone-900' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        Admin Overview
                    </a>

                    <a href="{{ route('admin.payments') }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ request()->routeIs('admin.payments') ? 'bg-stone-900 text-white shadow-md' : 'text-stone-600 hover:bg-stone-50 hover:text-stone-900' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Approvals
                        @php
                            $pendingCount = \App\Models\Payment::where('status', 'pending')->count();
                        @endphp
                        @if($pendingCount > 0)
                            <span class="ml-auto bg-red-500 text-white text-[10px] px-2 py-0.5 rounded-full">{{ $pendingCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route('admin.gifts.index') }}"
                       class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ request()->routeIs('admin.gifts.*') ? 'bg-stone-900 text-white shadow-md' : 'text-stone-600 hover:bg-stone-50 hover:text-stone-900' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        Manage Gifts
                    </a>
                </div>

            @else
                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ request()->routeIs('dashboard') ? 'bg-brand-50 text-brand-700 font-semibold' : 'text-stone-600 hover:bg-stone-50 hover:text-stone-900' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Dashboard
                </a>

                <a href="{{ route('gifts.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ request()->routeIs('gifts.index') ? 'bg-brand-50 text-brand-700 font-semibold' : 'text-stone-600 hover:bg-stone-50 hover:text-stone-900' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    Gift Catalogue
                </a>

                <a href="{{ route('events.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ request()->routeIs('events.*') ? 'bg-brand-50 text-brand-700 font-semibold' : 'text-stone-600 hover:bg-stone-50 hover:text-stone-900' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    My Events
                </a>

                <a href="{{ route('payments.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ request()->routeIs('payments.*') ? 'bg-brand-50 text-brand-700 font-semibold' : 'text-stone-600 hover:bg-stone-50 hover:text-stone-900' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                    Payments
                </a>
            @endif

        </nav>

        <div class="border-t border-stone-100 p-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-brand-100 flex items-center justify-center text-brand-700 font-bold">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-stone-900 truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-stone-500 truncate">{{ Auth::user()->email }}</p>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-stone-400 hover:text-red-600 transition" title="Logout">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black/20 z-20 md:hidden backdrop-blur-sm"></div>

    <main class="flex-1 flex flex-col min-w-0 overflow-hidden">
        <header class="bg-white/80 backdrop-blur-md border-b border-stone-200 h-16 hidden md:flex items-center justify-between px-8 sticky top-0 z-10">
            <h2 class="font-semibold text-xl text-stone-800">
                {{ $header ?? 'Dashboard' }}
            </h2>

            <div class="flex items-center gap-4">
                <button class="bg-stone-100 p-2 rounded-full text-stone-500 hover:text-brand-600 hover:bg-brand-50 transition">
                    <span class="sr-only">Notifications</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                </button>
                <a href="#" class="bg-brand-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-brand-700 transition shadow-sm">
                    + New Event
                </a>
            </div>
        </header>

        <div class="flex-1 overflow-auto p-4 md:p-8">
            {{ $slot }}
        </div>
    </main>
</div>
</body>
</html>
