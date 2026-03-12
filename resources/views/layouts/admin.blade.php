<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — Fast Express Shipping</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full flex flex-col" x-data="{ sidebarOpen: false }">

    <!-- Top Bar -->
    <header class="bg-fes-navy shadow-md z-30 fixed top-0 inset-x-0 h-16 flex items-center px-4 sm:px-6 gap-4">
        <button @click="sidebarOpen = !sidebarOpen" class="text-gray-300 hover:text-white sm:hidden">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 mr-4">
            <span class="text-white font-bold text-base">Fast<span class="text-fes-orange">Express</span> <span class="text-gray-400 font-normal text-sm">Admin</span></span>
        </a>
        <div class="flex-1"></div>
        <span class="text-gray-400 text-sm hidden sm:block">{{ auth()->user()->name }}</span>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-gray-300 hover:text-white text-sm transition">Logout</button>
        </form>
    </header>

    <div class="flex flex-1 pt-16">
        <!-- Sidebar -->
        <aside class="fixed sm:sticky top-16 h-[calc(100vh-4rem)] w-64 bg-fes-navy-dark flex flex-col z-20 transition-transform duration-200 sm:translate-x-0"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full sm:translate-x-0'">
            <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
                @php
                    $navItems = [
                        ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                        ['route' => 'admin.shipments.index', 'label' => 'Shipments', 'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'],
                    ];
                @endphp
                @foreach($navItems as $item)
                <a href="{{ route($item['route']) }}"
                   class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition
                       {{ request()->routeIs($item['route'] . '*') ? 'bg-fes-orange text-white' : 'text-gray-300 hover:bg-fes-navy hover:text-white' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"/>
                    </svg>
                    {{ $item['label'] }}
                </a>
                @endforeach
            </nav>
            <div class="p-4 border-t border-gray-700">
                <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-2 text-gray-400 hover:text-white text-sm transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    View Public Site
                </a>
            </div>
        </aside>

        <!-- Sidebar Overlay -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black/50 z-10 sm:hidden"></div>

        <!-- Page Content -->
        <main class="flex-1 overflow-auto p-6">
            @if(session('success'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm flex items-center gap-2">
                    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    {{ session('success') }}
                </div>
            @endif
            @yield('content')
        </main>
    </div>

</body>
</html>
