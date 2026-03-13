@extends('layouts.admin')
@section('title', 'Payment #' . $cryptoPayment->id)

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-fes-navy">Crypto Payment #{{ $cryptoPayment->id }}</h1>
    <a href="{{ route('admin.crypto-payments.index') }}" class="text-sm text-gray-500 hover:text-gray-700">← Back</a>
</div>

@php
$badge = match($cryptoPayment->status) {
    'pending'   => ['bg-yellow-100 text-yellow-700', 'Pending'],
    'submitted' => ['bg-blue-100 text-blue-700',    'Proof Submitted'],
    'paid'      => ['bg-green-100 text-green-700',  'Paid'],
    'rejected'  => ['bg-red-100 text-red-700',      'Rejected'],
    default     => ['bg-gray-100 text-gray-600',    ucfirst($cryptoPayment->status)],
};
@endphp

<div class="space-y-6 max-w-3xl">
    {{-- Overview --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
        <div class="grid grid-cols-2 md:grid-cols-3 gap-5 text-sm">
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Status</p>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $badge[0] }}">{{ $badge[1] }}</span>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Amount</p>
                <p class="font-bold text-fes-navy text-xl">${{ number_format($cryptoPayment->amount_usd, 2) }} USD</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Coin</p>
                <p class="font-bold uppercase">{{ $cryptoPayment->coin_type }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">User</p>
                <p class="font-medium">{{ $cryptoPayment->user->name ?? '—' }}</p>
                <p class="text-gray-400 text-xs">{{ $cryptoPayment->user->email ?? '' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Request</p>
                @if($cryptoPayment->shipmentRequest)
                    <a href="{{ route('admin.shipment-requests.show', $cryptoPayment->shipmentRequest) }}" class="text-fes-orange hover:underline font-mono text-sm">#{{ $cryptoPayment->shipment_request_id }}</a>
                @else
                    <span class="text-gray-400">—</span>
                @endif
            </div>
            @if($cryptoPayment->expires_at)
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Expires</p>
                <p>{{ $cryptoPayment->expires_at->format('M j, Y H:i') }}</p>
            </div>
            @endif
        </div>
    </div>

    {{-- Wallet --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
        <h3 class="font-bold text-fes-navy mb-3">Wallet Address</h3>
        <code class="block bg-gray-50 rounded-lg px-4 py-3 font-mono text-sm text-gray-800 break-all">{{ $cryptoPayment->wallet_address }}</code>
    </div>

    {{-- Proof --}}
    @if($cryptoPayment->proof_path)
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
        <h3 class="font-bold text-fes-navy mb-3">Submitted Proof</h3>
        <a href="{{ Storage::url($cryptoPayment->proof_path) }}" target="_blank" class="text-fes-orange hover:underline text-sm">View Proof File</a>
        @if($cryptoPayment->tx_hash)
            <div class="mt-3">
                <p class="text-xs text-gray-400 mb-1">Transaction Hash</p>
                <code class="font-mono text-sm text-gray-700 break-all">{{ $cryptoPayment->tx_hash }}</code>
            </div>
        @endif
    </div>
    @endif

    {{-- Actions for submitted --}}
    @if($cryptoPayment->status === 'submitted')
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
        <h3 class="font-bold text-fes-navy mb-4">Review Payment</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <form method="POST" action="{{ route('admin.crypto-payments.mark-paid', $cryptoPayment) }}" class="space-y-3">
                @csrf
                <textarea name="admin_notes" rows="2" placeholder="Admin notes (optional)" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400"></textarea>
                <button type="submit" class="w-full bg-green-600 text-white font-semibold py-2.5 rounded-lg hover:bg-green-700 transition">✓ Mark as Paid</button>
            </form>
            <form method="POST" action="{{ route('admin.crypto-payments.mark-rejected', $cryptoPayment) }}" class="space-y-3">
                @csrf
                <textarea name="admin_notes" rows="2" placeholder="Reason for rejection…" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-400"></textarea>
                <button type="submit" class="w-full bg-red-600 text-white font-semibold py-2.5 rounded-lg hover:bg-red-700 transition">✕ Mark as Rejected</button>
            </form>
        </div>
    </div>
    @endif

    @if($cryptoPayment->admin_notes)
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
        <h3 class="font-bold text-fes-navy mb-2 text-sm">Admin Notes</h3>
        <p class="text-gray-600 text-sm">{{ $cryptoPayment->admin_notes }}</p>
    </div>
    @endif
</div>
@endsection
