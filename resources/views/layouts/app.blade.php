<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Fast Express Shipping') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet"/>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-50 text-gray-900">

<div class="min-h-screen flex flex-col">

    {{-- Top Navigation --}}
    @include('layouts.navigation')

    {{-- Page Header --}}
    @isset($header)
        <header class="bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                {{ $header }}
            </div>
        </header>
    @endisset


    {{-- Dashboard Banner --}}
    <div class="bg-fes-navy relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-fes-navy via-fes-navy to-slate-900"></div>
        <div class="absolute -top-16 -right-16 w-60 h-60 bg-fes-orange/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-16 -left-16 w-60 h-60 bg-white/5 rounded-full blur-3xl"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                <div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-white">
                        Fast Express Shipping Dashboard
                    </h1>

                    <p class="mt-2 text-gray-300 text-sm">
                        Manage shipments, requests, payments and delivery updates from your account.
                    </p>
                </div>

                <div class="flex items-center gap-4 text-sm text-gray-300">
                    <span class="hidden sm:inline">
                        Logged in as
                    </span>

                    <span class="font-semibold text-white">
                        {{ auth()->user()->name }}
                    </span>
                </div>

            </div>
        </div>
    </div>


    {{-- Main Content --}}
    <main class="flex-1">
        {{ $slot }}
    </main>

</div>
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
