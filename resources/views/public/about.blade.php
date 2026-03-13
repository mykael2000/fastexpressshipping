@extends('layouts.public')
@section('title', 'About Us — Fast Express Shipping')

@section('content')
{{-- Hero --}}
<section class="bg-fes-navy text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl font-bold mb-4">About Fast Express Shipping</h1>
        <p class="text-gray-300 text-lg max-w-2xl mx-auto">Delivering reliability, speed, and trust since 2018.</p>
    </div>
</section>

{{-- Story --}}
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-3xl font-bold text-fes-navy mb-5">Our Story</h2>
                <p class="text-gray-600 mb-4">Fast Express Shipping was founded in 2018 with a simple belief: businesses and individuals deserve a shipping partner that treats every package as a priority — not just another box in a pile.</p>
                <p class="text-gray-600 mb-4">Starting with a small fleet of three vans and a team of eight, we handled local deliveries for small businesses in the greater metro area. Our commitment to on-time delivery and transparent communication set us apart from the start.</p>
                <p class="text-gray-600">By 2022 we had expanded to a national carrier network, built our proprietary tracking platform, and began offering international shipping to over 120 countries. Today, we process thousands of shipments daily — but we've never lost that founding commitment to treating every package with care.</p>
            </div>
            <div class="bg-gray-50 rounded-2xl p-8 grid grid-cols-2 gap-6 text-center">
                @php
                $milestones = [
                    ['value' => '2018', 'label' => 'Founded'],
                    ['value' => '120+', 'label' => 'Countries Served'],
                    ['value' => '2M+', 'label' => 'Packages Delivered'],
                    ['value' => '99.1%', 'label' => 'On-Time Rate'],
                ];
                @endphp
                @foreach($milestones as $m)
                <div class="bg-white rounded-xl py-6 px-4 shadow-sm border border-gray-100">
                    <p class="text-3xl font-bold text-fes-orange">{{ $m['value'] }}</p>
                    <p class="text-gray-500 text-sm mt-1">{{ $m['label'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- Mission & Values --}}
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-fes-navy mb-3">Our Mission & Values</h2>
            <p class="text-gray-500 max-w-xl mx-auto">Everything we do is guided by four core principles.</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
            $values = [
                ['title' => 'Reliability', 'desc' => 'We do what we say. Every shipment is tracked, every commitment is honored.', 'color' => 'bg-blue-600'],
                ['title' => 'Speed', 'desc' => 'Time is money. We optimize every step of the shipping process for the fastest delivery.', 'color' => 'bg-fes-orange'],
                ['title' => 'Transparency', 'desc' => 'No hidden fees. Real-time tracking. Honest communication at every step.', 'color' => 'bg-green-600'],
                ['title' => 'Care', 'desc' => 'Your packages matter to you — so they matter to us. We handle every item with respect.', 'color' => 'bg-purple-600'],
            ];
            @endphp
            @foreach($values as $v)
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 text-center">
                <div class="w-12 h-12 {{ $v['color'] }} rounded-xl mx-auto mb-4 flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <h3 class="font-bold text-fes-navy mb-2">{{ $v['title'] }}</h3>
                <p class="text-gray-500 text-sm">{{ $v['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Team --}}
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-fes-navy mb-3">Meet the Team</h2>
            <p class="text-gray-500 max-w-xl mx-auto">Our leadership team brings decades of combined experience in logistics, technology, and customer service.</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @php
            $team = [
                ['name' => 'Marcus J. Reed', 'role' => 'CEO & Co-Founder', 'bio' => '15 years in global logistics. Previously VP of Operations at Continental Freight.'],
                ['name' => 'Priya Nair', 'role' => 'CTO', 'bio' => 'Built our proprietary tracking platform. Former engineer at a Fortune 500 logistics firm.'],
                ['name' => 'David Osei', 'role' => 'Head of Operations', 'bio' => 'Manages carrier partnerships and last-mile delivery across all regions.'],
                ['name' => 'Sofia Marchetti', 'role' => 'Customer Success Director', 'bio' => 'Ensures every client receives white-glove support from quote to delivery.'],
            ];
            @endphp
            @foreach($team as $member)
            <div class="text-center">
                <div class="w-24 h-24 bg-fes-navy rounded-full mx-auto mb-4 flex items-center justify-center">
                    <span class="text-3xl font-bold text-white">{{ substr($member['name'], 0, 1) }}</span>
                </div>
                <h3 class="font-bold text-fes-navy">{{ $member['name'] }}</h3>
                <p class="text-fes-orange text-sm font-medium mb-2">{{ $member['role'] }}</p>
                <p class="text-gray-500 text-sm">{{ $member['bio'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Global Reach --}}
<section class="bg-fes-navy py-14 text-white text-center">
    <div class="max-w-3xl mx-auto px-4">
        <h2 class="text-3xl font-bold mb-4">Global Reach, Local Touch</h2>
        <p class="text-gray-300 mb-6">We operate through a network of trusted partners across North America, Europe, Asia-Pacific, and beyond. Wherever your shipment needs to go, we have the route covered.</p>
        <a href="{{ route('services') }}" class="inline-block bg-fes-orange text-white font-semibold px-8 py-3 rounded-lg hover:bg-orange-600 transition">Explore Our Services</a>
    </div>
</section>
@endsection
