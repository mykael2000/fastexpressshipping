@extends('layouts.public')
@section('title', 'Track Your Shipment — Fast Express Shipping')

@section('content')
<div id="top" class="bg-white">

    <!-- Hero -->
    <section class="relative overflow-hidden bg-fes-navy">
        <div class="absolute inset-0 bg-gradient-to-r from-fes-navy via-fes-navy to-slate-900"></div>
        <div class="absolute -top-24 -right-24 h-72 w-72 rounded-full bg-fes-orange/10 blur-3xl"></div>
        <div class="absolute -bottom-24 -left-24 h-72 w-72 rounded-full bg-white/5 blur-3xl"></div>

        <div class="relative mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-24">
            <div class="grid items-center gap-12 lg:grid-cols-2">
                <div>
                    <span class="inline-flex rounded-full border border-white/10 bg-white/10 px-4 py-2 text-sm font-medium text-white">
                        Fast, secure and reliable shipment tracking
                    </span>

                    <h1 class="mt-6 max-w-3xl text-4xl font-extrabold leading-tight text-white sm:text-5xl lg:text-6xl">
                        Track Your
                        <span class="text-fes-orange">Shipment</span>
                        in Real Time
                    </h1>

                    <p class="mt-5 max-w-2xl text-lg leading-8 text-gray-300">
                        Enter your tracking number to get real-time shipment updates, transit milestones,
                        estimated delivery information, and current package status.
                    </p>

                    <form action="{{ route('track') }}" method="POST" class="mt-8 rounded-2xl bg-white p-4 shadow-2xl">
                        @csrf
                        <div class="flex flex-col gap-3 sm:flex-row">
                            <div class="flex-1">
                                <label for="tracking_number" class="sr-only">Tracking Number</label>
                                <input
                                    id="tracking_number"
                                    type="text"
                                    name="tracking_number"
                                    value="{{ old('tracking_number') }}"
                                    placeholder="Enter tracking number (e.g. FES1234567890)"
                                    maxlength="50"
                                    autofocus
                                    class="w-full rounded-xl border border-gray-200 px-5 py-4 text-base text-gray-900 placeholder:text-gray-400 focus:border-fes-orange focus:outline-none focus:ring-2 focus:ring-fes-orange @error('tracking_number') border-red-300 ring-2 ring-red-500 @enderror"
                                >
                            </div>

                            <button
                                type="submit"
                                class="rounded-xl bg-fes-orange px-8 py-4 font-bold text-white transition hover:bg-orange-600">
                                Track Shipment
                            </button>
                        </div>

                        <div class="mt-3 flex flex-col gap-1 text-sm text-gray-500 sm:flex-row sm:items-center sm:justify-between">
                            <p>Track domestic and international shipments with a valid tracking number.</p>
                            <p class="font-medium text-fes-navy">Available 24/7</p>
                        </div>
                    </form>

                    @error('tracking_number')
                        <div class="mt-4 inline-flex rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                            {{ $message }}
                        </div>
                    @enderror

                    <div class="mt-8 grid grid-cols-2 gap-4 sm:grid-cols-4">
                        <div class="rounded-2xl border border-white/10 bg-white/10 p-4 text-center">
                            <p class="text-2xl font-extrabold text-white">24/7</p>
                            <p class="mt-1 text-sm text-gray-300">Tracking Access</p>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/10 p-4 text-center">
                            <p class="text-2xl font-extrabold text-white">220+</p>
                            <p class="mt-1 text-sm text-gray-300">Countries Covered</p>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/10 p-4 text-center">
                            <p class="text-2xl font-extrabold text-white">Fast</p>
                            <p class="mt-1 text-sm text-gray-300">Delivery Updates</p>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/10 p-4 text-center">
                            <p class="text-2xl font-extrabold text-white">Secure</p>
                            <p class="mt-1 text-sm text-gray-300">Shipment Handling</p>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="overflow-hidden rounded-3xl border border-white/10 bg-white shadow-2xl">
                        <img
                            src="{{ asset('images/cargo2.jpg') }}"
                            alt="Shipment and cargo operations"
                            class="h-64 w-full object-cover sm:h-72"
                        >
                        <div class="p-6">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-sm text-gray-500">Sample Shipment Overview</p>
                                    <h2 class="mt-1 text-2xl font-bold text-fes-navy">Tracking Dashboard</h2>
                                </div>
                                <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                    In Transit
                                </span>
                            </div>

                            <div class="mt-8 space-y-6">
                                <div class="flex gap-4">
                                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-fes-orange/10">
                                        <svg class="h-5 w-5 text-fes-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10m-11 9h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v11a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-fes-navy">Estimated Delivery</h3>
                                        <p class="mt-1 text-sm text-gray-500">Expected by Friday, 6:00 PM</p>
                                    </div>
                                </div>

                                <div class="flex gap-4">
                                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-blue-100">
                                        <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A2 2 0 013 15.382V6.618a2 2 0 011.553-1.894l4-1A2 2 0 019 3.764V20zm6 0V3.764a2 2 0 011.447-.94l4 1A2 2 0 0121 6.618v8.764a2 2 0 01-1.106 1.894L15 20z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-fes-navy">Current Location</h3>
                                        <p class="mt-1 text-sm text-gray-500">Regional Distribution Hub</p>
                                    </div>
                                </div>

                                <div class="flex gap-4">
                                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-green-100">
                                        <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-fes-navy">Shipment Progress</h3>
                                        <p class="mt-1 text-sm text-gray-500">Package processed and moving through network</p>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-8">
                                <div class="mb-2 flex justify-between text-sm text-gray-500">
                                    <span>Order Received</span>
                                    <span>Out for Delivery</span>
                                </div>
                                <div class="h-3 w-full overflow-hidden rounded-full bg-gray-200">
                                    <div class="h-3 w-2/3 rounded-full bg-fes-orange"></div>
                                </div>
                            </div>

                            <div class="mt-8 grid grid-cols-2 gap-4">
                                <div class="rounded-2xl border border-gray-100 bg-gray-50 p-4">
                                    <p class="text-xs uppercase tracking-wide text-gray-400">Tracking ID</p>
                                    <p class="mt-1 font-semibold text-fes-navy">FES1234567890</p>
                                </div>
                                <div class="rounded-2xl border border-gray-100 bg-gray-50 p-4">
                                    <p class="text-xs uppercase tracking-wide text-gray-400">Service Type</p>
                                    <p class="mt-1 font-semibold text-fes-navy">Express Delivery</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="overflow-hidden rounded-2xl border border-white/10 bg-white shadow-lg">
                            <img src="{{ asset('images/cargo5.jpg') }}" alt="Container yard" class="h-40 w-full object-cover">
                            <div class="p-4">
                                <h3 class="font-bold text-fes-navy">Container Movement</h3>
                                <p class="mt-1 text-sm text-gray-500">Monitor container handling, transfer and terminal activity.</p>
                            </div>
                        </div>

                        <div class="overflow-hidden rounded-2xl border border-white/10 bg-white shadow-lg">
                            <img src="{{ asset('images/cargo4.jpg') }}" alt="Cargo loading" class="h-40 w-full object-cover">
                            <div class="p-4">
                                <h3 class="font-bold text-fes-navy">Cargo Dispatch</h3>
                                <p class="mt-1 text-sm text-gray-500">Track the loading and dispatch stages of important shipments.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Shipment Gallery -->
    <section class="py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-3xl text-center">
                <h2 class="text-3xl font-extrabold text-fes-navy sm:text-4xl">
                    Shipment & Container Gallery
                </h2>
                <p class="mt-4 text-lg text-gray-600">
                    Showcase your containers, shipments, loading operations and delivery milestones with dedicated image areas.
                </p>
            </div>

            <div class="mt-12 grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
                    <img src="{{ asset('images/cargo.jpg') }}" alt="Shipment image 1" class="h-56 w-full object-cover">
                    <div class="p-5">
                        <h3 class="text-lg font-bold text-fes-navy">Shipment Arrival</h3>
                        <p class="mt-2 text-sm text-gray-500">Use this area for incoming shipment photos at destination terminals.</p>
                    </div>
                </div>

                <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
                    <img src="{{ asset('images/cargo3.jpg') }}" alt="Shipment image 2" class="h-56 w-full object-cover">
                    <div class="p-5">
                        <h3 class="text-lg font-bold text-fes-navy">Container Inspection</h3>
                        <p class="mt-2 text-sm text-gray-500">Display inspection photos of containers before dispatch or release.</p>
                    </div>
                </div>

                <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
                    <img src="{{ asset('images/cargo6.jpg') }}" alt="Shipment image 3" class="h-56 w-full object-cover">
                    <div class="p-5">
                        <h3 class="text-lg font-bold text-fes-navy">Cargo Handling</h3>
                        <p class="mt-2 text-sm text-gray-500">Highlight cargo loading and unloading operations across logistics hubs.</p>
                    </div>
                </div>

                <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
                    <img src="{{ asset('images/cargo2.jpg') }}" alt="Shipment image 4" class="h-56 w-full object-cover">
                    <div class="p-5">
                        <h3 class="text-lg font-bold text-fes-navy">Delivery Confirmation</h3>
                        <p class="mt-2 text-sm text-gray-500">Show successful delivery photos for completed shipment milestones.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Stats -->
    <section class="border-y border-gray-100 bg-white">
        <div class="mx-auto grid max-w-7xl grid-cols-2 gap-6 px-4 py-8 text-center sm:px-6 lg:grid-cols-4 lg:px-8">
            <div>
                <p class="text-2xl font-extrabold text-fes-navy">99%</p>
                <p class="mt-1 text-sm text-gray-500">Shipment visibility</p>
            </div>
            <div>
                <p class="text-2xl font-extrabold text-fes-navy">24/7</p>
                <p class="mt-1 text-sm text-gray-500">Customer support access</p>
            </div>
            <div>
                <p class="text-2xl font-extrabold text-fes-navy">Global</p>
                <p class="mt-1 text-sm text-gray-500">International network</p>
            </div>
            <div>
                <p class="text-2xl font-extrabold text-fes-navy">Safe</p>
                <p class="mt-1 text-sm text-gray-500">Secure shipment monitoring</p>
            </div>
        </div>
    </section>

    <!-- Container Showcase -->
    <section class="bg-gray-50 py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid items-center gap-10 lg:grid-cols-2">
                <div>
                    <h2 class="text-3xl font-extrabold text-fes-navy sm:text-4xl">
                        Dedicated Areas for Container and Cargo Images
                    </h2>
                    <p class="mt-4 text-lg text-gray-600">
                        Present container shipments, warehouse operations, cargo processing and transport visuals in a more professional way.
                    </p>

                    <div class="mt-8 space-y-4">
                        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                            <h3 class="font-bold text-fes-navy">Container Yard Photos</h3>
                            <p class="mt-2 text-sm text-gray-500">Use this section to show stacked containers, movement at terminals and yard organization.</p>
                        </div>

                        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                            <h3 class="font-bold text-fes-navy">Shipment Processing Photos</h3>
                            <p class="mt-2 text-sm text-gray-500">Add visuals for packaging, inspection, loading, scanning and clearance stages.</p>
                        </div>

                        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                            <h3 class="font-bold text-fes-navy">Delivery Milestone Photos</h3>
                            <p class="mt-2 text-sm text-gray-500">Show images for transit checkpoints, destination arrival and delivery confirmation.</p>
                        </div>
                    </div>
                </div>

                <div class="grid gap-6 sm:grid-cols-2">
                    <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
                        <img src="{{ asset('images/cargo6.jpg') }}" alt="Container showcase 1" class="h-52 w-full object-cover">
                    </div>
                    <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm sm:mt-10">
                        <img src="{{ asset('images/cargo7.jpg') }}" alt="Container showcase 2" class="h-52 w-full object-cover">
                    </div>
                    <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
                        <img src="{{ asset('images/cargo8.jpg') }}" alt="Container showcase 3" class="h-52 w-full object-cover">
                    </div>
                    <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm sm:mt-10">
                        <img src="{{ asset('images/cargo5.jpg') }}" alt="Container showcase 4" class="h-52 w-full object-cover">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-3xl text-center">
                <h2 class="text-3xl font-extrabold text-fes-navy sm:text-4xl">
                    Why Track With Fast Express Shipping?
                </h2>
                <p class="mt-4 text-lg text-gray-600">
                    We make shipment tracking simple, transparent and reliable so you always know where your package is and what happens next.
                </p>
            </div>

            <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm transition hover:shadow-md">
                    <div class="flex h-14 w-14 items-center justify-center rounded-full bg-fes-orange/10">
                        <svg class="h-7 w-7 text-fes-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20 10 10 0 000-20z"/>
                        </svg>
                    </div>
                    <h3 class="mt-5 text-lg font-bold text-fes-navy">Real-Time Updates</h3>
                    <p class="mt-2 text-sm leading-6 text-gray-500">
                        Follow your package at every stage of its journey with timely status updates.
                    </p>
                </div>

                <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm transition hover:shadow-md">
                    <div class="flex h-14 w-14 items-center justify-center rounded-full bg-fes-orange/10">
                        <svg class="h-7 w-7 text-fes-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                    </div>
                    <h3 class="mt-5 text-lg font-bold text-fes-navy">Instant Notifications</h3>
                    <p class="mt-2 text-sm leading-6 text-gray-500">
                        Receive email and SMS alerts when major shipment events occur.
                    </p>
                </div>

                <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm transition hover:shadow-md">
                    <div class="flex h-14 w-14 items-center justify-center rounded-full bg-fes-orange/10">
                        <svg class="h-7 w-7 text-fes-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h3 class="mt-5 text-lg font-bold text-fes-navy">Secure &amp; Reliable</h3>
                    <p class="mt-2 text-sm leading-6 text-gray-500">
                        Your shipment information is protected and accessible whenever you need it.
                    </p>
                </div>

                <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm transition hover:shadow-md">
                    <div class="flex h-14 w-14 items-center justify-center rounded-full bg-fes-orange/10">
                        <svg class="h-7 w-7 text-fes-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h13l4 4v6a2 2 0 01-2 2h-1a3 3 0 11-6 0H9a3 3 0 11-6 0H2V9a2 2 0 012-2h1z"/>
                        </svg>
                    </div>
                    <h3 class="mt-5 text-lg font-bold text-fes-navy">Delivery Transparency</h3>
                    <p class="mt-2 text-sm leading-6 text-gray-500">
                        Know when your shipment is picked up, processed, in transit, and delivered.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Highlight Banner -->
    <section class="py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-6 lg:grid-cols-3">
                <div class="relative overflow-hidden rounded-3xl lg:col-span-2">
                    <img src="{{ asset('images/cargo6.jpg') }}" alt="Warehouse and shipment operations" class="h-full min-h-[320px] w-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-r from-fes-navy/90 via-fes-navy/70 to-transparent"></div>
                    <div class="absolute inset-0 flex items-end p-8">
                        <div class="max-w-xl">
                            <h2 class="text-3xl font-extrabold text-white">Professional Logistics Visibility</h2>
                            <p class="mt-3 text-gray-200">
                                Add high-quality shipment, warehouse and container visuals to build trust and make the page more engaging.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
                        <img src="{{ asset('images/cargo4.jpg') }}" alt="Shipment side image 1" class="h-40 w-full object-cover">
                        <div class="p-5">
                            <h3 class="font-bold text-fes-navy">Port Handling</h3>
                            <p class="mt-2 text-sm text-gray-500">Great place for port or customs checkpoint images.</p>
                        </div>
                    </div>

                    <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
                        <img src="{{ asset('images/cargo.jpg') }}" alt="Shipment side image 2" class="h-40 w-full object-cover">
                        <div class="p-5">
                            <h3 class="font-bold text-fes-navy">Final Mile Delivery</h3>
                            <p class="mt-2 text-sm text-gray-500">Use this block for delivery vans, drop-off confirmation, or destination images.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Process -->
    <section class="bg-gray-50 py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-3xl text-center">
                <h2 class="text-3xl font-extrabold text-fes-navy sm:text-4xl">
                    How Shipment Tracking Works
                </h2>
                <p class="mt-4 text-lg text-gray-600">
                    From pickup to final delivery, every major movement is recorded so you can follow your package with confidence.
                </p>
            </div>

            <div class="mt-12 grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-fes-orange text-lg font-bold text-white">1</div>
                    <h3 class="mt-5 text-lg font-bold text-fes-navy">Shipment Created</h3>
                    <p class="mt-2 text-sm leading-6 text-gray-500">
                        A shipment label is generated and your package is registered in our delivery network.
                    </p>
                </div>

                <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-fes-orange text-lg font-bold text-white">2</div>
                    <h3 class="mt-5 text-lg font-bold text-fes-navy">Package Picked Up</h3>
                    <p class="mt-2 text-sm leading-6 text-gray-500">
                        Your parcel is collected and scanned into transit for movement toward its destination.
                    </p>
                </div>

                <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-fes-orange text-lg font-bold text-white">3</div>
                    <h3 class="mt-5 text-lg font-bold text-fes-navy">In Transit</h3>
                    <p class="mt-2 text-sm leading-6 text-gray-500">
                        Your shipment moves through sorting centers and transportation hubs with status updates.
                    </p>
                </div>

                <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-fes-orange text-lg font-bold text-white">4</div>
                    <h3 class="mt-5 text-lg font-bold text-fes-navy">Delivered</h3>
                    <p class="mt-2 text-sm leading-6 text-gray-500">
                        The shipment reaches its destination and delivery confirmation is recorded.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Help / Services -->
    <section class="py-16 sm:py-20">
        <div class="mx-auto grid max-w-7xl gap-8 px-4 sm:px-6 lg:grid-cols-2 lg:px-8">
            <div class="rounded-2xl border border-gray-100 bg-white p-8 shadow-sm">
                <h2 class="text-2xl font-extrabold text-fes-navy">Need Help With Tracking?</h2>
                <p class="mt-3 text-gray-600">
                    If you cannot find your shipment right away, a few common issues may be the reason.
                </p>

                <div class="mt-8 space-y-6">
                    <div>
                        <h3 class="text-base font-semibold text-fes-navy">Check your tracking number</h3>
                        <p class="mt-1 text-sm leading-6 text-gray-500">
                            Make sure the number is entered correctly without extra spaces or missing characters.
                        </p>
                    </div>

                    <div>
                        <h3 class="text-base font-semibold text-fes-navy">Allow time for first scan</h3>
                        <p class="mt-1 text-sm leading-6 text-gray-500">
                            New shipments may take some time before the first update appears in the tracking system.
                        </p>
                    </div>

                    <div>
                        <h3 class="text-base font-semibold text-fes-navy">Look for status changes</h3>
                        <p class="mt-1 text-sm leading-6 text-gray-500">
                            Transit updates may appear as your shipment moves between operational hubs.
                        </p>
                    </div>

                    <div>
                        <h3 class="text-base font-semibold text-fes-navy">Contact support if needed</h3>
                        <p class="mt-1 text-sm leading-6 text-gray-500">
                            If your shipment has no updates for an extended period, our support team can assist further.
                        </p>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl bg-fes-navy p-8 text-white shadow-sm">
                <h2 class="text-2xl font-extrabold">Shipping Services You Can Trust</h2>
                <p class="mt-3 text-gray-300">
                    Fast Express Shipping supports individuals and businesses with dependable delivery services designed for speed, visibility and peace of mind.
                </p>

                <div class="mt-8 space-y-4">
                    <div class="flex gap-3">
                        <svg class="mt-1 h-5 w-5 shrink-0 text-fes-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <p class="text-gray-200">Domestic express shipping for urgent deliveries</p>
                    </div>

                    <div class="flex gap-3">
                        <svg class="mt-1 h-5 w-5 shrink-0 text-fes-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <p class="text-gray-200">International courier services with tracking visibility</p>
                    </div>

                    <div class="flex gap-3">
                        <svg class="mt-1 h-5 w-5 shrink-0 text-fes-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <p class="text-gray-200">Business logistics support for recurring shipments</p>
                    </div>

                    <div class="flex gap-3">
                        <svg class="mt-1 h-5 w-5 shrink-0 text-fes-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <p class="text-gray-200">Reliable package handling from origin to destination</p>
                    </div>
                </div>

                <div class="mt-8 rounded-2xl border border-white/10 bg-white/10 p-5">
                    <h3 class="font-semibold">Customer Promise</h3>
                    <p class="mt-2 text-sm leading-6 text-gray-300">
                        We are committed to making shipment tracking easy, accessible and dependable for every customer.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section class="bg-gray-50 py-16 sm:py-20">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-3xl text-center">
                <h2 class="text-3xl font-extrabold text-fes-navy sm:text-4xl">
                    Frequently Asked Questions
                </h2>
                <p class="mt-4 text-lg text-gray-600">
                    Answers to common questions about shipment tracking and delivery visibility.
                </p>
            </div>

            <div class="mt-12 space-y-5">
                <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-bold text-fes-navy">Why is my tracking number not working?</h3>
                    <p class="mt-2 text-sm leading-6 text-gray-500">
                        Your shipment may not have received its first scan yet, or the tracking number may have been entered incorrectly.
                    </p>
                </div>

                <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-bold text-fes-navy">How often is shipment information updated?</h3>
                    <p class="mt-2 text-sm leading-6 text-gray-500">
                        Tracking updates are usually posted whenever the package reaches a new checkpoint in the delivery network.
                    </p>
                </div>

                <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-bold text-fes-navy">Can I track international packages?</h3>
                    <p class="mt-2 text-sm leading-6 text-gray-500">
                        Yes. International shipments can be tracked using the assigned tracking number, subject to scan availability across locations.
                    </p>
                </div>

                <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-bold text-fes-navy">What should I do if delivery is delayed?</h3>
                    <p class="mt-2 text-sm leading-6 text-gray-500">
                        Check the latest shipment scan for transit details. If there has been no movement for an unusual period, contact support for assistance.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="bg-fes-orange py-16">
        <div class="mx-auto max-w-5xl px-4 text-center sm:px-6 lg:px-8">
            <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                Ready to Track Your Shipment?
            </h2>
            <p class="mx-auto mt-4 max-w-2xl text-lg text-orange-50">
                Enter your tracking number above to view the latest package status, delivery milestones and shipment updates.
            </p>

            <a
                href="#top"
                onclick="window.scrollTo({ top: 0, behavior: 'smooth' }); return false;"
                class="mt-8 inline-flex items-center rounded-xl bg-white px-8 py-4 font-bold text-fes-orange transition hover:bg-gray-100">
                Track Now
            </a>
        </div>
    </section>

</div>
@endsection
