<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Fast Express Shipping') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-900">
        <div class="relative min-h-screen overflow-hidden bg-fes-navy">
            <div class="absolute inset-0 bg-gradient-to-br from-fes-navy via-fes-navy to-slate-900"></div>
            <div class="absolute -top-20 -right-20 h-72 w-72 rounded-full bg-fes-orange/10 blur-3xl"></div>
            <div class="absolute -bottom-20 -left-20 h-72 w-72 rounded-full bg-white/5 blur-3xl"></div>

            <div class="relative flex min-h-screen items-center justify-center px-4 py-10 sm:px-6 lg:px-8">
                <div class="w-full max-w-md">
                    <div class="mb-8 text-center">
                        <a href="/" class="inline-block">
                            <h1 class="text-3xl font-extrabold tracking-tight text-white">
                                Fast Express <span class="text-fes-orange">Shipping</span>
                            </h1>
                            <p class="mt-2 text-sm text-gray-300">
                                Secure shipment tracking and delivery management
                            </p>
                        </a>
                    </div>

                    <div class="rounded-3xl border border-white/10 bg-white p-6 shadow-2xl sm:p-8">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
