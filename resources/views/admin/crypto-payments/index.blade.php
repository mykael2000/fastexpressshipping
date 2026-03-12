@extends('layouts.admin')
@section('title', 'Crypto Payments')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-fes-navy">Crypto Payments</h1>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    @if($payments->isEmpty())
        <div class="py-16 text-center text-gray-400 text-sm">No payments found.</div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wide">
                    <tr>
                        <th class="px-5 py-3 text-left">ID</th>
                        <th class="px-5 py-3 text-left">User</th>
                        <th class="px-5 py-3 text-left">Request</th>
                        <th class="px-5 py-3 text-left">Coin</th>
                        <th class="px-5 py-3 text-left">Amount (USD)</th>
                        <th class="px-5 py-3 text-left">Status</th>
                        <th class="px-5 py-3 text-left">Submitted</th>
                        <th class="px-5 py-3 text-left">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($payments as $payment)
                    @php
                    $badge = match($payment->status) {
                        'pending'   => 'bg-yellow-100 text-yellow-700',
                        'submitted' => 'bg-blue-100 text-blue-700',
                        'paid'      => 'bg-green-100 text-green-700',
                        'rejected'  => 'bg-red-100 text-red-700',
                        default     => 'bg-gray-100 text-gray-600',
                    };
                    @endphp
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-5 py-4 font-mono text-gray-500 text-xs">#{{ $payment->id }}</td>
                        <td class="px-5 py-4">
                            <p class="font-medium text-gray-800">{{ $payment->user->name ?? '—' }}</p>
                            <p class="text-xs text-gray-400">{{ $payment->user->email ?? '' }}</p>
                        </td>
                        <td class="px-5 py-4">
                            @if($payment->shipmentRequest)
                                <a href="{{ route('admin.shipment-requests.show', $payment->shipmentRequest) }}" class="text-fes-orange hover:underline text-xs font-mono">#{{ $payment->shipment_request_id }}</a>
                            @else
                                <span class="text-gray-400">—</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 uppercase font-semibold text-xs">{{ $payment->coin_type }}</td>
                        <td class="px-5 py-4 font-semibold">${{ number_format($payment->amount_usd, 2) }}</td>
                        <td class="px-5 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badge }}">{{ ucfirst($payment->status) }}</span>
                        </td>
                        <td class="px-5 py-4 text-gray-500 text-xs">{{ $payment->created_at->format('M j, Y') }}</td>
                        <td class="px-5 py-4">
                            <a href="{{ route('admin.crypto-payments.show', $payment) }}" class="text-fes-orange hover:underline font-medium text-xs">View</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($payments->hasPages())
            <div class="px-5 py-4 border-t border-gray-100">{{ $payments->links() }}</div>
        @endif
    @endif
</div>
@endsection
