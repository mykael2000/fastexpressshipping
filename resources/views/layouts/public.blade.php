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
    <header class="bg-fes-navy shadow-md relative">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <div class="w-9 h-9 bg-fes-orange rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zm7 0a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM.75 2h1.63l.64 3H17l1.25 6.5H3.73L2.75 2H.75a.75.75 0 010-1.5h2.5a.75.75 0 01.73.58l.15.92z"/>
                    </svg>
                </div>
                <span class="text-white font-bold text-lg tracking-tight">Fast<span class="text-fes-orange">Express</span> Shipping</span>
            </a>
            <!-- Desktop nav -->
            <div class="hidden md:flex items-center gap-5 text-sm" x-data="{ mobileOpen: false }">
                <a href="{{ route('home') }}" class="text-gray-300 hover:text-white transition">Track</a>
                <a href="{{ route('services') }}" class="text-gray-300 hover:text-white transition">Services</a>
                <a href="{{ route('about') }}" class="text-gray-300 hover:text-white transition">About</a>
                <a href="{{ route('contact') }}" class="text-gray-300 hover:text-white transition">Contact</a>
                <a href="{{ route('faq') }}" class="text-gray-300 hover:text-white transition">FAQ</a>
                <a href="{{ route('news.index') }}" class="text-gray-300 hover:text-white transition">News</a>
                <a href="{{ route('service-alerts') }}" class="text-gray-300 hover:text-white transition">Alerts</a>
                @auth
                    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'staff')
                        <a href="{{ route('admin.dashboard') }}" class="bg-fes-orange text-white px-3 py-1.5 rounded-lg hover:bg-orange-600 transition font-medium">Admin</a>
                    @else
                        <a href="{{ route('user.dashboard') }}" class="bg-fes-orange text-white px-3 py-1.5 rounded-lg hover:bg-orange-600 transition font-medium">My Dashboard</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="text-gray-300 hover:text-white transition">Login</a>
                    <a href="{{ route('register') }}" class="bg-fes-orange text-white px-3 py-1.5 rounded-lg hover:bg-orange-600 transition font-medium">Register</a>
                @endauth
            </div>
            <!-- Mobile menu button -->
            <div class="md:hidden" x-data="{ open: false }">
                <button @click="open = !open" class="text-gray-300 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <div x-show="open" @click.away="open = false" class="absolute top-16 left-0 right-0 bg-fes-navy-dark shadow-lg py-3 px-4 z-50 space-y-2 text-sm">
                    <a href="{{ route('home') }}" class="block text-gray-300 hover:text-white py-1">Track Shipment</a>
                    <a href="{{ route('services') }}" class="block text-gray-300 hover:text-white py-1">Services</a>
                    <a href="{{ route('about') }}" class="block text-gray-300 hover:text-white py-1">About</a>
                    <a href="{{ route('contact') }}" class="block text-gray-300 hover:text-white py-1">Contact</a>
                    <a href="{{ route('faq') }}" class="block text-gray-300 hover:text-white py-1">FAQ</a>
                    <a href="{{ route('news.index') }}" class="block text-gray-300 hover:text-white py-1">News</a>
                    <a href="{{ route('service-alerts') }}" class="block text-gray-300 hover:text-white py-1">Service Alerts</a>
                    @auth
                        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'staff')
                            <a href="{{ route('admin.dashboard') }}" class="block text-fes-orange hover:text-white py-1">Admin Panel</a>
                        @else
                            <a href="{{ route('user.dashboard') }}" class="block text-fes-orange hover:text-white py-1">My Dashboard</a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="block text-gray-300 hover:text-white py-1">Login</a>
                        <a href="{{ route('register') }}" class="block text-fes-orange hover:text-white py-1">Register</a>
                    @endauth
                </div>
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
<!-- Smartsupp Live Chat script -->
<script type="text/javascript">
var _smartsupp = _smartsupp || {};
_smartsupp.key = '339fea848d6f2758df4a1e5744a1267a6aee1301';
window.smartsupp||(function(d) {
  var s,c,o=smartsupp=function(){ o._.push(arguments)};o._=[];
  s=d.getElementsByTagName('script')[0];c=d.createElement('script');
  c.type='text/javascript';c.charset='utf-8';c.async=true;
  c.src='https://www.smartsuppchat.com/loader.js?';s.parentNode.insertBefore(c,s);
})(document);
</script>
<noscript>Powered by <a href="https://www.smartsupp.com" target="_blank">Smartsupp</a></noscript>

</body>
</html>
