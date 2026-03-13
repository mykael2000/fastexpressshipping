@extends('layouts.public')
@section('title', 'Contact Us — Fast Express Shipping')

@section('content')
{{-- Hero --}}
<section class="bg-fes-navy text-white py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl font-bold mb-3">Contact Us</h1>
        <p class="text-gray-300 text-lg">We're here to help. Reach out any time.</p>
    </div>
</section>

<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            {{-- Contact Info --}}
            <div class="space-y-8">
                <div>
                    <h2 class="text-xl font-bold text-fes-navy mb-6">Get in Touch</h2>
                    @php
                    $info = [
                        ['label' => 'Address', 'value' => '1200 Commerce Blvd, Suite 300, Atlanta, GA 30301', 'icon' => 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z'],
                        ['label' => 'Phone', 'value' => '+1 (800) 555-3478', 'icon' => 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z'],
                        ['label' => 'Email', 'value' => 'support@fastexpressshipping.com', 'icon' => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
                        ['label' => 'Business Hours', 'value' => 'Mon–Fri 7:00 AM – 8:00 PM ET', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                    ];
                    @endphp
                    @foreach($info as $i)
                    <div class="flex items-start gap-4 mb-5">
                        <div class="w-10 h-10 bg-fes-navy rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $i['icon'] }}"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">{{ $i['label'] }}</p>
                            <p class="text-gray-700 text-sm mt-0.5">{{ $i['value'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="bg-fes-navy rounded-xl p-5 text-white text-sm">
                    <p class="font-semibold mb-1">Need urgent help?</p>
                    <p class="text-gray-300">For time-critical shipments or emergencies, call our 24/7 hotline:</p>
                    <p class="text-fes-orange font-bold text-lg mt-2">+1 (800) 555-9911</p>
                </div>
            </div>

            {{-- Contact Form --}}
            <div class="lg:col-span-2">
                <h2 class="text-xl font-bold text-fes-navy mb-6">Send Us a Message</h2>

                @if(session('contact_success'))
                    <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-4 rounded-lg text-sm flex items-center gap-2">
                        <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        Thank you! Your message has been received. We'll respond within one business day.
                    </div>
                @endif

                <form method="POST" action="{{ route('contact') }}" class="space-y-5">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="contact_name">Your Name <span class="text-red-500">*</span></label>
                            <input type="text" id="contact_name" name="name" value="{{ old('name') }}"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-fes-orange focus:border-transparent @error('name') border-red-400 @enderror">
                            @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="contact_email">Email Address <span class="text-red-500">*</span></label>
                            <input type="email" id="contact_email" name="email" value="{{ old('email') }}"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-fes-orange focus:border-transparent @error('email') border-red-400 @enderror">
                            @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="contact_subject">Subject <span class="text-red-500">*</span></label>
                        <input type="text" id="contact_subject" name="subject" value="{{ old('subject') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-fes-orange focus:border-transparent @error('subject') border-red-400 @enderror">
                        @error('subject')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="contact_message">Message <span class="text-red-500">*</span></label>
                        <textarea id="contact_message" name="message" rows="6"
                                  class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-fes-orange focus:border-transparent @error('message') border-red-400 @enderror">{{ old('message') }}</textarea>
                        @error('message')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <button type="submit" class="bg-fes-orange text-white font-semibold px-8 py-3 rounded-lg hover:bg-orange-600 transition">Send Message</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
