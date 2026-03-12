@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
<h1 class="text-2xl font-bold text-fes-navy mb-6">Dashboard</h1>

<!-- Stats Grid -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    @php
        $statCards = [
            ['label' => 'Total Shipments', 'value' => $stats['total'], 'color' => 'bg-fes-navy', 'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'],
            ['label' => 'In Transit', 'value' => $stats['in_transit'], 'color' => 'bg-yellow-500', 'icon' => 'M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0'],
            ['label' => 'Delivered', 'value' => $stats['delivered'], 'color' => 'bg-green-500', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
            ['label' => 'Exceptions', 'value' => $stats['exception'], 'color' => 'bg-red-500', 'icon' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'],
        ];
    @endphp
    @foreach($statCards as $card)
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center gap-4">
        <div class="{{ $card['color'] }} w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}"/>
            </svg>
        </div>
        <div>
            <p class="text-2xl font-bold text-fes-navy">{{ $card['value'] }}</p>
            <p class="text-gray-500 text-xs">{{ $card['label'] }}</p>
        </div>
    </div>
    @endforeach
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Shipments -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
            <h2 class="font-semibold text-fes-navy">Recent Shipments</h2>
            <a href="{{ route('admin.shipments.index') }}" class="text-fes-orange text-sm hover:underline">View all</a>
        </div>
        <ul class="divide-y divide-gray-50">
            @forelse($recentShipments as $s)
            <li class="px-5 py-3 flex items-center justify-between gap-2">
                <a href="{{ route('admin.shipments.show', $s) }}" class="font-mono text-fes-navy text-sm hover:underline">{{ $s->tracking_number }}</a>
                <span class="text-gray-500 text-xs truncate flex-1 text-right">{{ $s->recipient_name }}</span>
                <span class="text-xs px-2 py-0.5 rounded-full {{ ['delivered'=>'bg-green-100 text-green-700','exception'=>'bg-red-100 text-red-700','in_transit'=>'bg-yellow-100 text-yellow-700'][$s->status] ?? 'bg-gray-100 text-gray-600' }}">{{ $s->statusLabel() }}</span>
            </li>
            @empty
            <li class="px-5 py-8 text-center text-gray-400 text-sm">No shipments yet.</li>
            @endforelse
        </ul>
    </div>

    <!-- Recent Notification Logs -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="px-5 py-4 border-b border-gray-100">
            <h2 class="font-semibold text-fes-navy">Recent Notifications</h2>
        </div>
        <ul class="divide-y divide-gray-50">
            @forelse($recentLogs as $log)
            <li class="px-5 py-3 flex items-center justify-between gap-2 text-sm">
                <span class="font-mono text-fes-navy text-xs">{{ $log->shipment->tracking_number ?? '—' }}</span>
                <span class="text-gray-500 text-xs">{{ strtoupper($log->channel) }}</span>
                <span class="text-xs px-2 py-0.5 rounded-full {{ ['sent'=>'bg-green-100 text-green-700','failed'=>'bg-red-100 text-red-700','skipped'=>'bg-gray-100 text-gray-500'][$log->status] ?? 'bg-gray-100 text-gray-600' }}">{{ $log->status }}</span>
                <span class="text-gray-400 text-xs">{{ $log->created_at->diffForHumans() }}</span>
            </li>
            @empty
            <li class="px-5 py-8 text-center text-gray-400 text-sm">No notifications sent yet.</li>
            @endforelse
        </ul>
    </div>
</div>
@endsection
