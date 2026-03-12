@extends('layouts.public')
@section('title', 'FAQ — Fast Express Shipping')

@section('content')
{{-- Hero --}}
<section class="bg-fes-navy text-white py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl font-bold mb-3">Frequently Asked Questions</h1>
        <p class="text-gray-300 text-lg">Everything you need to know about shipping with us.</p>
    </div>
</section>

<section class="py-16 bg-white">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8" x-data="{ open: null }">
        @php
        $faqs = [
            [
                'q' => 'How do I track my shipment?',
                'a' => 'You can track your shipment by entering your tracking number on our homepage. Tracking updates are available in real time as your package moves through our network. You can also receive SMS and email notifications by providing your contact details at booking.',
            ],
            [
                'q' => 'How long does standard shipping take?',
                'a' => 'Standard shipping typically takes 3–5 business days for domestic deliveries. Delivery times may vary based on the origin and destination, public holidays, and carrier capacity. For guaranteed delivery windows, consider our Express or Overnight options.',
            ],
            [
                'q' => 'What items are prohibited from shipping?',
                'a' => 'Prohibited items include hazardous materials, flammable substances, illegal drugs, live animals, perishable foods without temperature-control agreements, firearms and ammunition (without proper licensing), and cash or negotiable instruments. When submitting a request, you will be required to acknowledge that your shipment does not contain prohibited items.',
            ],
            [
                'q' => 'How is shipping cost calculated?',
                'a' => 'Shipping costs are based on the dimensional weight or actual weight (whichever is greater), the origin and destination, the selected service level (standard, express, overnight), and any additional services such as insurance or signature required. You will receive a quote when you submit a shipment request.',
            ],
            [
                'q' => 'Can I ship internationally?',
                'a' => 'Yes! We ship to over 120 countries worldwide. International shipments require complete customs documentation, including HS codes, declared values, and accurate contents descriptions. We offer DDP (Delivered Duty Paid) and DAP (Delivered At Place) terms. Our team can assist with customs compliance.',
            ],
            [
                'q' => 'What payment methods do you accept?',
                'a' => 'We currently accept cryptocurrency payments (Bitcoin, Ethereum, and USDT-TRC20). Once your shipment request is approved, you will receive a payment request with the wallet address and amount. Payments must be completed within the expiry window shown on your payment page.',
            ],
            [
                'q' => 'What happens if my package is lost or damaged?',
                'a' => 'In the rare event of a lost or damaged shipment, please contact our support team within 7 days of the expected delivery date. We will file a carrier claim on your behalf. If you purchased additional insurance, claims are processed within 5 business days. Proof of value (receipt or invoice) may be required.',
            ],
            [
                'q' => 'Can I change or cancel a shipment after submitting?',
                'a' => 'Modifications or cancellations can be requested before a shipment is picked up or dispatched. Once a shipment is in transit, changes may not be possible. Please contact our support team as soon as possible if you need to make a change. Cancellation fees may apply depending on the service level.',
            ],
            [
                'q' => 'How do I prepare my package for shipping?',
                'a' => 'Use a sturdy box appropriate for the weight and fragility of your items. Wrap fragile items individually with bubble wrap or packing paper, and fill empty space with packing peanuts or air pillows. Seal all seams with strong packing tape. Clearly label the box with the recipient\'s address and your return address. Do not use worn or previously used boxes for heavy items.',
            ],
            [
                'q' => 'What is a HS code and do I need one?',
                'a' => 'A Harmonized System (HS) code is an internationally standardized system of names and numbers used to classify traded products for customs purposes. HS codes are required for all international shipments. If you\'re unsure of the HS code for your goods, you can look it up on the World Customs Organization website, or our team can assist you during the shipment request process.',
            ],
            [
                'q' => 'Do you offer scheduled pickups?',
                'a' => 'Yes. When submitting a shipment request, you can choose between dropping off your package at one of our partner locations or scheduling a pickup. Pickup slots are available Monday through Saturday. You can select a preferred time window (morning, afternoon, or evening), and a courier will arrive within that window.',
            ],
        ];
        @endphp

        <div class="space-y-3">
            @foreach($faqs as $index => $faq)
            <div class="border border-gray-200 rounded-xl overflow-hidden">
                <button
                    @click="open === {{ $index }} ? open = null : open = {{ $index }}"
                    class="w-full flex items-center justify-between px-6 py-4 text-left text-fes-navy font-medium hover:bg-gray-50 transition">
                    <span>{{ $faq['q'] }}</span>
                    <svg class="w-5 h-5 flex-shrink-0 transition-transform duration-200"
                         :class="open === {{ $index }} ? 'rotate-180' : ''"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open === {{ $index }}" x-cloak class="px-6 pb-5 text-gray-600 text-sm leading-relaxed border-t border-gray-100 pt-4">
                    {{ $faq['a'] }}
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-12 bg-fes-navy rounded-xl p-8 text-center text-white">
            <h3 class="text-lg font-bold mb-2">Didn't find your answer?</h3>
            <p class="text-gray-300 text-sm mb-5">Our support team is happy to help with any questions not covered here.</p>
            <a href="{{ route('contact') }}" class="inline-block bg-fes-orange text-white font-semibold px-6 py-3 rounded-lg hover:bg-orange-600 transition">Contact Support</a>
        </div>
    </div>
</section>
@endsection
