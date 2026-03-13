@extends('layouts.public')
@section('title', 'Our Services — Fast Express Shipping')

@section('content')
{{-- Hero --}}
<section class="bg-fes-navy text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl font-bold mb-4">Our Shipping Services</h1>
        <p class="text-gray-300 text-lg max-w-2xl mx-auto">From standard delivery to time-critical overnight freight, we have the right solution for every shipment.</p>
    </div>
</section>

{{-- Core Services --}}
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-fes-navy mb-10 text-center">Domestic Shipping</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            {{-- Standard --}}
            <div class="border border-gray-200 rounded-2xl p-8 hover:shadow-lg transition">
                <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center mb-5">
                    <svg class="w-7 h-7 text-fes-navy" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-fes-navy mb-2">Standard Shipping</h3>
                <p class="text-gray-500 text-sm mb-4">3–5 business days. The most economical choice for non-urgent deliveries.</p>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li class="flex items-center gap-2"><svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg> Real-time tracking</li>
                    <li class="flex items-center gap-2"><svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg> Up to 70 kg per package</li>
                    <li class="flex items-center gap-2"><svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg> Door-to-door delivery</li>
                </ul>
            </div>
            {{-- Express --}}
            <div class="border-2 border-fes-orange rounded-2xl p-8 hover:shadow-lg transition relative">
                <span class="absolute -top-3 left-6 bg-fes-orange text-white text-xs font-semibold px-3 py-1 rounded-full">Most Popular</span>
                <div class="w-14 h-14 bg-orange-100 rounded-xl flex items-center justify-center mb-5">
                    <svg class="w-7 h-7 text-fes-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-fes-navy mb-2">Express Shipping</h3>
                <p class="text-gray-500 text-sm mb-4">1–2 business days. For time-sensitive shipments that need to arrive quickly.</p>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li class="flex items-center gap-2"><svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg> Priority handling</li>
                    <li class="flex items-center gap-2"><svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg> SMS & email updates</li>
                    <li class="flex items-center gap-2"><svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg> Signature confirmation</li>
                </ul>
            </div>
            {{-- Overnight --}}
            <div class="border border-gray-200 rounded-2xl p-8 hover:shadow-lg transition">
                <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center mb-5">
                    <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-fes-navy mb-2">Overnight Delivery</h3>
                <p class="text-gray-500 text-sm mb-4">Next business day by 10:30 AM. When it absolutely must be there tomorrow.</p>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li class="flex items-center gap-2"><svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg> Guaranteed delivery time</li>
                    <li class="flex items-center gap-2"><svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg> Dedicated courier</li>
                    <li class="flex items-center gap-2"><svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg> Proof of delivery</li>
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- Additional Services --}}
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-fes-navy mb-10 text-center">Specialty Services</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
            $specialties = [
                ['title' => 'International Shipping', 'desc' => 'Worldwide delivery with full customs documentation, duties & tax pre-payment options, and DDP/DAP terms available.', 'color' => 'bg-blue-100 text-blue-700', 'icon' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['title' => 'Special Handling', 'desc' => 'Fragile, high-value, or temperature-sensitive items handled with care. Custom packaging, white-glove service, and climate-controlled options.', 'color' => 'bg-yellow-100 text-yellow-700', 'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
                ['title' => 'Freight Services', 'desc' => 'LTL and FTL freight for oversized or pallet shipments. Nationwide carrier network with competitive rates and full liability coverage.', 'color' => 'bg-green-100 text-green-700', 'icon' => 'M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2M8 4v4h8V4M8 4V2h8v2'],
                ['title' => 'Return Logistics', 'desc' => 'Streamlined return shipping with prepaid labels, drop-off or scheduled pickup, and real-time return status for both sender and recipient.', 'color' => 'bg-pink-100 text-pink-700', 'icon' => 'M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6'],
                ['title' => 'Warehousing & Fulfilment', 'desc' => 'Short and long-term storage, pick-and-pack fulfilment, inventory management, and same-day dispatch for e-commerce sellers.', 'color' => 'bg-indigo-100 text-indigo-700', 'icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'],
                ['title' => 'Insurance & Compliance', 'desc' => 'Comprehensive cargo insurance up to $50,000. Customs compliance consulting, HS code classification, and export documentation.', 'color' => 'bg-gray-100 text-gray-700', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
            ];
            @endphp
            @foreach($specialties as $s)
            <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-md transition">
                <div class="w-12 h-12 {{ $s['color'] }} rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $s['icon'] }}"/>
                    </svg>
                </div>
                <h3 class="font-bold text-fes-navy mb-2">{{ $s['title'] }}</h3>
                <p class="text-gray-500 text-sm">{{ $s['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="bg-fes-navy py-14">
    <div class="max-w-3xl mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold text-white mb-4">Ready to Ship?</h2>
        <p class="text-gray-300 mb-8">Create a free account and submit your first shipment request in minutes.</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('register') }}" class="bg-fes-orange text-white font-semibold px-8 py-3 rounded-lg hover:bg-orange-600 transition">Get Started</a>
            <a href="{{ route('contact') }}" class="border border-white text-white font-semibold px-8 py-3 rounded-lg hover:bg-white hover:text-fes-navy transition">Contact Us</a>
        </div>
    </div>
</section>
@endsection
