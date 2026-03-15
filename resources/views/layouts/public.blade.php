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

@php $whatsappNumber = \App\Models\SiteSetting::get('whatsapp_number'); @endphp
@if($whatsappNumber)
<a href="https://wa.me/{{ $whatsappNumber }}" target="_blank" rel="noopener noreferrer"
   title="Chat with us on WhatsApp"
   class="fixed bottom-6 left-6 z-50 w-14 h-14 bg-green-500 hover:bg-green-600 text-white rounded-full shadow-lg flex items-center justify-center transition-colors duration-200">
    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
    </svg>
</a>
@endif

</body>
</html>
