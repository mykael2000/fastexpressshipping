@extends('layouts.public')
@section('title', 'Tracking: ' . $shipment->tracking_number . ' — Fast Express Shipping')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">

    <!-- Back -->
    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-fes-navy hover:text-fes-orange text-sm font-medium mb-6 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Track Another Shipment
    </a>

    <!-- Shipment Summary Card -->
    <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden mb-8">
        <div class="bg-fes-navy px-6 py-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <p class="text-gray-400 text-xs uppercase tracking-widest mb-1">Tracking Number</p>
                <p class="text-white font-mono text-xl font-bold">{{ $shipment->tracking_number }}</p>
            </div>
            @php
                $statusColors = [
                    'created'          => 'bg-gray-500',
                    'picked_up'        => 'bg-blue-500',
                    'in_transit'       => 'bg-yellow-500',
                    'out_for_delivery' => 'bg-purple-500',
                    'delivered'        => 'bg-green-500',
                    'exception'        => 'bg-red-500',
                ];
                $color = $statusColors[$shipment->status] ?? 'bg-gray-500';
            @endphp
            <span class="{{ $color }} text-white text-sm font-semibold px-4 py-2 rounded-full shadow-sm">
                {{ $shipment->statusLabel() }}
            </span>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 gap-px bg-gray-100">
            @php
                $fields = [
                    ['label' => 'From', 'value' => $shipment->origin],
                    ['label' => 'To', 'value' => $shipment->destination],
                    ['label' => 'Service', 'value' => ucfirst($shipment->service_level)],
                    ['label' => 'Recipient', 'value' => $shipment->recipient_name],
                    ['label' => 'Shipped', 'value' => $shipment->shipped_date ? $shipment->shipped_date->format('M d, Y') : '—'],
                    ['label' => 'Est. Delivery', 'value' => $shipment->eta ? $shipment->eta->format('M d, Y') : '—'],
                    ['label' => 'Payment Mode', 'value' => $shipment->paymentModeLabel()],
                    ['label' => 'Weight', 'value' => $shipment->weight_kg !== null ? number_format((float) $shipment->weight_kg, 2) . ' kg' : '—'],
                ];
            @endphp
            @foreach($fields as $field)
            <div class="bg-white px-5 py-4">
                <p class="text-gray-400 text-xs uppercase tracking-widest mb-1">{{ $field['label'] }}</p>
                <p class="text-fes-navy font-semibold text-sm">{{ $field['value'] }}</p>
            </div>
            @endforeach
        </div>

        @if($shipment->remark)
        <div class="bg-white px-5 py-4 border-t border-gray-100">
            <p class="text-gray-400 text-xs uppercase tracking-widest mb-1">Remark</p>
            <p class="text-fes-navy text-sm">{{ $shipment->remark }}</p>
        </div>
        @endif

        {{-- Payment Section --}}
        @if($shipment->payment_mode)
        <div class="bg-white px-5 py-4 border-t border-gray-100">
            <p class="text-gray-400 text-xs uppercase tracking-widest mb-3">Payment</p>
            @if($shipment->payment_status === 'paid')
                <div class="flex items-center gap-2 mb-1">
                    <span class="bg-green-100 text-green-700 text-xs font-bold px-3 py-1 rounded-full uppercase">PAID</span>
                    @if($shipment->paid_at)
                        <span class="text-gray-400 text-xs">{{ $shipment->paid_at->format('M d, Y H:i') }}</span>
                    @endif
                </div>
            @else
                <div class="mb-3">
                    <span class="bg-yellow-100 text-yellow-700 text-xs font-bold px-3 py-1 rounded-full uppercase">UNPAID</span>
                </div>
                <p class="text-fes-navy text-sm font-medium mb-2">Payment Method: {{ $shipment->paymentModeLabel() }}</p>
                @if($shipment->payment_mode === 'bank')
                    <div class="space-y-1 text-sm text-gray-700">
                        @if($paymentSettings['bank_name'])
                            <p><span class="text-gray-400 text-xs">Bank:</span> {{ $paymentSettings['bank_name'] }}</p>
                        @endif
                        @if($paymentSettings['bank_account_name'])
                            <p><span class="text-gray-400 text-xs">Account Name:</span> {{ $paymentSettings['bank_account_name'] }}</p>
                        @endif
                        @if($paymentSettings['bank_account_number'])
                            <p><span class="text-gray-400 text-xs">Account Number:</span> <span class="font-mono font-semibold">{{ $paymentSettings['bank_account_number'] }}</span></p>
                        @endif
                        @if($paymentSettings['bank_note'])
                            <p class="text-gray-500 text-xs italic mt-1">{{ $paymentSettings['bank_note'] }}</p>
                        @endif
                    </div>
                @else
                    @php
                        $walletKey = $shipment->walletSettingKey();
                        $walletAddress = $walletKey ? ($paymentSettings[$walletKey] ?? null) : null;
                    @endphp
                    @if($walletAddress)
                        <p class="text-xs text-gray-400 mb-1">Send payment to:</p>
                        <p class="font-mono text-sm break-all text-fes-navy bg-gray-50 rounded-lg px-3 py-2">{{ $walletAddress }}</p>
                    @endif
                @endif
            @endif
        </div>
        @endif
    </div>

    <!-- Tracking Timeline -->
    <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-6">
        <h2 class="text-fes-navy font-bold text-lg mb-6">Shipment Activity</h2>

        @if($shipment->trackingEvents->isEmpty())
            <p class="text-gray-400 text-sm text-center py-8">No tracking events recorded yet.</p>
        @else
        <div class="relative">
            <!-- vertical line -->
            <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-gray-200"></div>

            <ul class="space-y-6">
                @foreach($shipment->trackingEvents as $index => $event)
                @php
                    $eventColors = [
                        'pickup'            => 'bg-blue-500',
                        'transit'           => 'bg-yellow-500',
                        'delivery_attempt'  => 'bg-orange-500',
                        'out_for_delivery'  => 'bg-purple-500',
                        'delivered'         => 'bg-green-500',
                        'exception'         => 'bg-red-500',
                        'info'              => 'bg-gray-400',
                    ];
                    $dotColor = $eventColors[$event->event_type] ?? 'bg-gray-400';
                    $isLatest = $index === 0;
                @endphp
                <li class="relative flex gap-6 pl-10">
                    <!-- dot -->
                    <div class="absolute left-0 top-1 w-8 h-8 {{ $dotColor }} rounded-full flex items-center justify-center shadow-sm {{ $isLatest ? 'ring-4 ring-offset-2 ring-gray-200' : '' }}">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414L8.414 15l-5.121-5.121a1 1 0 011.414-1.414L8.414 12.172l6.879-6.879a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1">
                            <p class="text-fes-navy font-semibold text-sm">
                                {{ \App\Models\TrackingEvent::eventTypeOptions()[$event->event_type] ?? ucfirst($event->event_type) }}
                            </p>
                            <time class="text-gray-400 text-xs">{{ $event->occurred_at->format('M d, Y · H:i') }}</time>
                        </div>
                        @if($event->location)
                            <p class="text-gray-500 text-xs mt-0.5">📍 {{ $event->location }}</p>
                        @endif
                        <p class="text-gray-600 text-sm mt-1">{{ $event->description }}</p>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>

    @if($officeAddress)
    <!-- Office Address -->
    <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-6 mt-6">
        <h2 class="text-fes-navy font-bold text-lg mb-2">Our Address</h2>
        <p class="text-gray-600 text-sm">{{ $officeAddress }}</p>
    </div>
    @endif

</div>
@endsection
