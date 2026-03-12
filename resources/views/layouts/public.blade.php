<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Fast Express Shipping')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full bg-gray-50 flex flex-col">

    <!-- Navigation -->
    <header class="bg-fes-navy shadow-md">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <div class="w-9 h-9 bg-fes-orange rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zm7 0a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM.75 2h1.63l.64 3H17l1.25 6.5H3.73L2.75 2H.75a.75.75 0 010-1.5h2.5a.75.75 0 01.73.58l.15.92z"/>
                    </svg>
                </div>
                <span class="text-white font-bold text-lg tracking-tight">Fast<span class="text-fes-orange">Express</span> Shipping</span>
            </a>
            <div class="flex items-center gap-6 text-sm">
                <a href="{{ route('home') }}" class="text-gray-300 hover:text-white transition">Track Shipment</a>
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-300 hover:text-white transition">Admin</a>
                @else
                    <a href="{{ route('login') }}" class="text-gray-300 hover:text-white transition">Admin Login</a>
                @endauth
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-fes-navy text-gray-400 py-8 mt-12">
        <div class="max-w-7xl mx-auto px-4 text-center text-sm">
            <p class="text-white font-semibold mb-1">Fast Express Shipping</p>
            <p>&copy; {{ date('Y') }} Fast Express Shipping. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>
