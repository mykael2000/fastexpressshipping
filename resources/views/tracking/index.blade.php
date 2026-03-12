@extends('layouts.public')
@section('title', 'Track Your Shipment — Fast Express Shipping')

@section('content')
<!-- Hero Section -->
<section class="bg-fes-navy py-20 px-4">
    <div class="max-w-3xl mx-auto text-center">
        <h1 class="text-4xl sm:text-5xl font-extrabold text-white mb-4 leading-tight">
            Track Your <span class="text-fes-orange">Shipment</span>
        </h1>
        <p class="text-gray-300 text-lg mb-10">Enter your tracking number to get real-time shipment updates.</p>

        <form action="{{ route('track') }}" method="POST" class="flex flex-col sm:flex-row gap-3 max-w-xl mx-auto">
            @csrf
            <div class="flex-1">
                <input
                    type="text"
                    name="tracking_number"
                    value="{{ old('tracking_number') }}"
                    placeholder="Enter tracking number (e.g. FES1234567890)"
                    class="w-full px-5 py-4 rounded-lg text-gray-800 text-base focus:outline-none focus:ring-2 focus:ring-fes-orange @error('tracking_number') ring-2 ring-red-500 @enderror"
                    maxlength="50"
                    autofocus
                >
            </div>
            <button type="submit"
                class="bg-fes-orange hover:bg-orange-600 text-white font-bold px-8 py-4 rounded-lg transition duration-150 shadow-lg">
                Track
            </button>
        </form>

        @error('tracking_number')
            <div class="mt-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm inline-block">
                {{ $message }}
            </div>
        @enderror
    </div>
</section>

<!-- Features Section -->
<section class="max-w-7xl mx-auto px-4 py-16 grid grid-cols-1 sm:grid-cols-3 gap-8">
    <div class="text-center p-6 bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="w-12 h-12 bg-fes-orange/10 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-6 h-6 text-fes-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20 10 10 0 000-20z"/>
            </svg>
        </div>
        <h3 class="font-bold text-fes-navy text-lg mb-2">Real-Time Updates</h3>
        <p class="text-gray-500 text-sm">Follow your package at every stage of its journey.</p>
    </div>
    <div class="text-center p-6 bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="w-12 h-12 bg-fes-orange/10 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-6 h-6 text-fes-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
        </div>
        <h3 class="font-bold text-fes-navy text-lg mb-2">Instant Notifications</h3>
        <p class="text-gray-500 text-sm">Receive email &amp; SMS alerts on every shipment update.</p>
    </div>
    <div class="text-center p-6 bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="w-12 h-12 bg-fes-orange/10 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-6 h-6 text-fes-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
        </div>
        <h3 class="font-bold text-fes-navy text-lg mb-2">Secure &amp; Reliable</h3>
        <p class="text-gray-500 text-sm">Your shipment data is safe with us, always.</p>
    </div>
</section>
@endsection
