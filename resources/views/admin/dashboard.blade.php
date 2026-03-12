@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
<h1 class="text-2xl font-bold text-fes-navy mb-6">Dashboard</h1>

<!-- Stats Grid -->
<div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
    @php
        $statCards = [
            ['label' => 'Total Shipments',   'value' => $stats['total_shipments']   ?? 0, 'color' => 'bg-fes-navy',    'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'],
            ['label' => 'Total Requests',    'value' => $stats['total_requests']    ?? 0, 'color' => 'bg-blue-500',    'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
            ['label' => 'Pending Requests',  'value' => $stats['pending_requests']  ?? 0, 'color' => 'bg-yellow-500', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
            ['label' => 'Pending Payments',  'value' => $stats['pending_payments']  ?? 0, 'color' => 'bg-purple-500', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
            ['label' => 'Total Users',       'value' => $stats['total_users']       ?? 0, 'color' => 'bg-green-500',  'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
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
    <!-- Recent Requests -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
            <h2 class="font-semibold text-fes-navy">Recent Requests</h2>
            <a href="{{ route('admin.shipment-requests.index') }}" class="text-fes-orange text-sm hover:underline">View all</a>
        </div>
        <ul class="divide-y divide-gray-50">
            @forelse($recentRequests ?? [] as $req)
            @php
            $rb = match($req->status) {
                'pending'          => 'bg-yellow-100 text-yellow-700',
                'approved'         => 'bg-blue-100 text-blue-700',
                'denied'           => 'bg-red-100 text-red-700',
                'payment_required' => 'bg-purple-100 text-purple-700',
                'paid'             => 'bg-green-100 text-green-700',
                default            => 'bg-gray-100 text-gray-600',
            };
            @endphp
            <li class="px-5 py-3 flex items-center justify-between gap-2 text-sm">
                <a href="{{ route('admin.shipment-requests.show', $req) }}" class="font-mono text-fes-navy text-xs hover:underline">#{{ $req->id }}</a>
                <span class="text-gray-500 text-xs truncate flex-1 px-2">{{ $req->user->name ?? '—' }}</span>
                <span class="text-xs px-2 py-0.5 rounded-full {{ $rb }}">{{ ucfirst(str_replace('_',' ',$req->status)) }}</span>
            </li>
            @empty
            <li class="px-5 py-8 text-center text-gray-400 text-sm">No requests yet.</li>
            @endforelse
        </ul>
    </div>

    <!-- Recent Shipments -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
            <h2 class="font-semibold text-fes-navy">Recent Shipments</h2>
            <a href="{{ route('admin.shipments.index') }}" class="text-fes-orange text-sm hover:underline">View all</a>
        </div>
        <ul class="divide-y divide-gray-50">
            @forelse($recentShipments ?? [] as $s)
            <li class="px-5 py-3 flex items-center justify-between gap-2">
                <a href="{{ route('admin.shipments.show', $s) }}" class="font-mono text-fes-navy text-sm hover:underline">{{ $s->tracking_number }}</a>
                <span class="text-gray-500 text-xs truncate flex-1 text-right">{{ $s->recipient_name ?? '—' }}</span>
                <span class="text-xs px-2 py-0.5 rounded-full {{ ['delivered'=>'bg-green-100 text-green-700','exception'=>'bg-red-100 text-red-700','in_transit'=>'bg-yellow-100 text-yellow-700'][$s->status] ?? 'bg-gray-100 text-gray-600' }}">{{ method_exists($s, 'statusLabel') ? $s->statusLabel() : ucfirst($s->status) }}</span>
            </li>
            @empty
            <li class="px-5 py-8 text-center text-gray-400 text-sm">No shipments yet.</li>
            @endforelse
        </ul>
    </div>
</div>
@endsection
