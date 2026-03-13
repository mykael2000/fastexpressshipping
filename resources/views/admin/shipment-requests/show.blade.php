@extends('layouts.admin')
@section('title', 'Request #' . $shipmentRequest->id)

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-fes-navy">Request #{{ $shipmentRequest->id }}</h1>
    <a href="{{ route('admin.shipment-requests.index') }}" class="text-sm text-gray-500 hover:text-gray-700">← Back</a>
</div>

@php
$badge = match($shipmentRequest->status) {
    'pending'          => 'bg-yellow-100 text-yellow-700',
    'approved'         => 'bg-blue-100 text-blue-700',
    'denied'           => 'bg-red-100 text-red-700',
    'payment_required' => 'bg-purple-100 text-purple-700',
    'paid'             => 'bg-green-100 text-green-700',
    'shipped'          => 'bg-indigo-100 text-indigo-700',
    default            => 'bg-gray-100 text-gray-600',
};
@endphp

<div class="space-y-6">
    {{-- Status & Actions --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Status</p>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $badge }}">
                    {{ ucfirst(str_replace('_', ' ', $shipmentRequest->status)) }}
                </span>
                @if($shipmentRequest->reviewer)
                    <p class="text-xs text-gray-400 mt-2">Reviewed by {{ $shipmentRequest->reviewer->name }} on {{ $shipmentRequest->reviewed_at?->format('M j, Y H:i') }}</p>
                @endif
            </div>
            <div class="flex flex-wrap gap-3">
                {{-- Pending actions --}}
                @if($shipmentRequest->status === 'pending')
                    <form method="POST" action="{{ route('admin.shipment-requests.approve', $shipmentRequest) }}">
                        @csrf
                        <button type="submit" class="bg-blue-600 text-white text-sm font-semibold px-4 py-2 rounded-lg hover:bg-blue-700 transition">Approve</button>
                    </form>
                    <div x-data="{ open: false }">
                        <button @click="open = !open" class="bg-red-100 text-red-700 text-sm font-semibold px-4 py-2 rounded-lg hover:bg-red-200 transition">Deny</button>
                        <div x-show="open" x-cloak class="absolute mt-2 bg-white border border-gray-200 rounded-xl shadow-lg p-4 z-10 w-72">
                            <form method="POST" action="{{ route('admin.shipment-requests.deny', $shipmentRequest) }}" class="space-y-3">
                                @csrf
                                <textarea name="admin_notes" rows="3" placeholder="Reason for denial…" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-400"></textarea>
                                <button type="submit" class="w-full bg-red-600 text-white text-sm font-semibold py-2 rounded-lg hover:bg-red-700 transition">Confirm Deny</button>
                            </form>
                        </div>
                    </div>
                    <div x-data="{ open: false }">
                        <button @click="open = !open" class="bg-purple-100 text-purple-700 text-sm font-semibold px-4 py-2 rounded-lg hover:bg-purple-200 transition">Require Payment</button>
                        <div x-show="open" x-cloak class="absolute mt-2 bg-white border border-gray-200 rounded-xl shadow-lg p-4 z-10 w-72">
                            <form method="POST" action="{{ route('admin.shipment-requests.require-payment', $shipmentRequest) }}" class="space-y-3">
                                @csrf
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Coin</label>
                                    <select name="coin_type" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                                        <option value="btc">Bitcoin (BTC)</option>
                                        <option value="eth">Ethereum (ETH)</option>
                                        <option value="usdt_trc20">USDT TRC-20</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Amount (USD)</label>
                                    <input type="number" step="0.01" name="amount_usd" placeholder="0.00" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                                </div>
                                <button type="submit" class="w-full bg-purple-600 text-white text-sm font-semibold py-2 rounded-lg hover:bg-purple-700 transition">Send Payment Request</button>
                            </form>
                        </div>
                    </div>
                @endif

                {{-- Approved: create shipment --}}
                @if($shipmentRequest->status === 'approved')
                    <a href="{{ route('admin.shipment-requests.create-shipment', $shipmentRequest) }}"
                       class="bg-fes-navy text-white text-sm font-semibold px-4 py-2 rounded-lg hover:bg-fes-navy-dark transition">
                        Create Shipment
                    </a>
                @endif

                {{-- Payment required: link to payment --}}
                @if($shipmentRequest->status === 'payment_required' && $shipmentRequest->cryptoPayments->count())
                    <a href="{{ route('admin.crypto-payments.show', $shipmentRequest->cryptoPayments->first()) }}"
                       class="bg-purple-600 text-white text-sm font-semibold px-4 py-2 rounded-lg hover:bg-purple-700 transition">
                        View Payment
                    </a>
                @endif
            </div>
        </div>
    </div>

    {{-- Sender / Recipient --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
            <h3 class="font-bold text-fes-navy mb-4 text-sm uppercase tracking-wide">Sender</h3>
            <dl class="space-y-2 text-sm">
                <div><dt class="text-gray-400 text-xs">Name</dt><dd>{{ $shipmentRequest->sender_name }}</dd></div>
                <div><dt class="text-gray-400 text-xs">Email</dt><dd>{{ $shipmentRequest->sender_email }}</dd></div>
                <div><dt class="text-gray-400 text-xs">Phone</dt><dd>{{ $shipmentRequest->sender_phone ?? '—' }}</dd></div>
                <div><dt class="text-gray-400 text-xs">Address</dt>
                    <dd>{{ $shipmentRequest->sender_address1 }}, {{ $shipmentRequest->sender_city }}, {{ $shipmentRequest->sender_country }}</dd>
                </div>
            </dl>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
            <h3 class="font-bold text-fes-navy mb-4 text-sm uppercase tracking-wide">Recipient</h3>
            <dl class="space-y-2 text-sm">
                <div><dt class="text-gray-400 text-xs">Name</dt><dd>{{ $shipmentRequest->recipient_name }}</dd></div>
                <div><dt class="text-gray-400 text-xs">Email</dt><dd>{{ $shipmentRequest->recipient_email }}</dd></div>
                <div><dt class="text-gray-400 text-xs">Phone</dt><dd>{{ $shipmentRequest->recipient_phone ?? '—' }}</dd></div>
                <div><dt class="text-gray-400 text-xs">Address</dt>
                    <dd>{{ $shipmentRequest->recipient_address1 }}, {{ $shipmentRequest->recipient_city }}, {{ $shipmentRequest->recipient_country }}</dd>
                </div>
            </dl>
        </div>
    </div>

    {{-- Package Items --}}
    @if($shipmentRequest->packageItems && $shipmentRequest->packageItems->count())
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="font-bold text-fes-navy">Packages</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                    <tr>
                        <th class="px-4 py-3 text-left">Type</th>
                        <th class="px-4 py-3 text-left">Qty</th>
                        <th class="px-4 py-3 text-left">Weight</th>
                        <th class="px-4 py-3 text-left">Dimensions</th>
                        <th class="px-4 py-3 text-left">Value</th>
                        <th class="px-4 py-3 text-left">Contents</th>
                        <th class="px-4 py-3 text-left">HS Code</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($shipmentRequest->packageItems as $item)
                    <tr>
                        <td class="px-4 py-3 capitalize">{{ $item->package_type }}</td>
                        <td class="px-4 py-3">{{ $item->quantity }}</td>
                        <td class="px-4 py-3">{{ $item->weight }} {{ $item->weight_unit }}</td>
                        <td class="px-4 py-3">{{ $item->length }} × {{ $item->width }} × {{ $item->height }} {{ $item->dimension_unit }}</td>
                        <td class="px-4 py-3">{{ number_format($item->declared_value, 2) }} {{ $item->currency }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $item->contents_description ?? '—' }}</td>
                        <td class="px-4 py-3 font-mono text-xs">{{ $item->hs_code ?? '—' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- Shipment Link --}}
    @if($shipmentRequest->shipment)
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 flex items-center justify-between">
        <div>
            <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Linked Shipment</p>
            <p class="font-mono font-bold text-fes-navy">{{ $shipmentRequest->shipment->tracking_number }}</p>
        </div>
        <a href="{{ route('admin.shipments.show', $shipmentRequest->shipment) }}" class="text-fes-orange hover:underline text-sm font-medium">View Shipment →</a>
    </div>
    @endif

    {{-- Notes --}}
    @if($shipmentRequest->notes)
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
        <h3 class="font-bold text-fes-navy mb-2 text-sm">User Notes</h3>
        <p class="text-gray-600 text-sm">{{ $shipmentRequest->notes }}</p>
    </div>
    @endif
</div>
@endsection
