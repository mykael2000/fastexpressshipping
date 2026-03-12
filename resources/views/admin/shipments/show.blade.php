@extends('layouts.admin')
@section('title', 'Shipment ' . $shipment->tracking_number)

@section('content')
<div class="flex items-center justify-between mb-6 flex-wrap gap-3">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.shipments.index') }}" class="text-gray-400 hover:text-fes-navy transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <h1 class="text-2xl font-bold text-fes-navy font-mono">{{ $shipment->tracking_number }}</h1>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('admin.shipments.edit', $shipment) }}" class="bg-fes-orange hover:bg-orange-600 text-white font-semibold px-4 py-2 rounded-lg text-sm transition">Edit</a>
        <a href="{{ route('track.show', $shipment->tracking_number) }}" target="_blank" class="border border-gray-200 text-gray-600 hover:border-fes-navy px-4 py-2 rounded-lg text-sm transition">Public View</a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Details -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Summary Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-fes-navy px-5 py-4 flex items-center justify-between">
                <p class="text-white font-semibold">Shipment Summary</p>
                @php
                    $c = ['delivered'=>'bg-green-500','exception'=>'bg-red-500','in_transit'=>'bg-yellow-500','out_for_delivery'=>'bg-purple-500','picked_up'=>'bg-blue-500','created'=>'bg-gray-500'];
                @endphp
                <span class="{{ $c[$shipment->status] ?? 'bg-gray-500' }} text-white text-xs font-semibold px-3 py-1 rounded-full">{{ $shipment->statusLabel() }}</span>
            </div>
            <dl class="grid grid-cols-2 gap-px bg-gray-100">
                @php
                    $fields = [
                        'Origin' => $shipment->origin,
                        'Destination' => $shipment->destination,
                        'Service Level' => ucfirst($shipment->service_level),
                        'Recipient' => $shipment->recipient_name,
                        'Email' => $shipment->recipient_email ?: '—',
                        'Phone' => $shipment->recipient_phone ?: '—',
                        'Shipped Date' => $shipment->shipped_date ? $shipment->shipped_date->format('M d, Y H:i') : '—',
                        'ETA' => $shipment->eta ? $shipment->eta->format('M d, Y H:i') : '—',
                    ];
                @endphp
                @foreach($fields as $label => $value)
                <div class="bg-white px-4 py-3">
                    <dt class="text-gray-400 text-xs mb-0.5">{{ $label }}</dt>
                    <dd class="text-fes-navy text-sm font-medium">{{ $value }}</dd>
                </div>
                @endforeach
            </dl>
            @if($shipment->notes)
            <div class="px-5 py-3 border-t border-gray-100">
                <p class="text-gray-400 text-xs mb-1">Notes</p>
                <p class="text-gray-600 text-sm">{{ $shipment->notes }}</p>
            </div>
            @endif
        </div>

        <!-- Tracking Events -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                <h2 class="font-semibold text-fes-navy">Tracking Events</h2>
                <a href="{{ route('admin.shipments.events.create', $shipment) }}" class="bg-fes-orange hover:bg-orange-600 text-white font-semibold px-4 py-1.5 rounded-lg text-xs transition">+ Add Event</a>
            </div>
            @if($shipment->trackingEvents->isEmpty())
                <p class="text-center text-gray-400 text-sm py-8">No tracking events yet.</p>
            @else
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="text-left px-4 py-2 text-gray-500 font-medium text-xs">Date/Time</th>
                        <th class="text-left px-4 py-2 text-gray-500 font-medium text-xs hidden sm:table-cell">Location</th>
                        <th class="text-left px-4 py-2 text-gray-500 font-medium text-xs">Type</th>
                        <th class="text-left px-4 py-2 text-gray-500 font-medium text-xs hidden md:table-cell">Description</th>
                        <th class="px-4 py-2"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($shipment->trackingEvents as $event)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2.5 text-gray-600 text-xs whitespace-nowrap">{{ $event->occurred_at->format('M d, Y H:i') }}</td>
                        <td class="px-4 py-2.5 text-gray-500 text-xs hidden sm:table-cell">{{ $event->location ?: '—' }}</td>
                        <td class="px-4 py-2.5 text-xs">
                            <span class="px-1.5 py-0.5 rounded bg-gray-100 text-gray-600">{{ \App\Models\TrackingEvent::eventTypeOptions()[$event->event_type] ?? $event->event_type }}</span>
                        </td>
                        <td class="px-4 py-2.5 text-gray-500 text-xs hidden md:table-cell max-w-xs truncate">{{ $event->description }}</td>
                        <td class="px-4 py-2.5 text-right whitespace-nowrap">
                            <a href="{{ route('admin.shipments.events.edit', [$shipment, $event]) }}" class="text-fes-orange hover:underline text-xs mr-2">Edit</a>
                            <form method="POST" action="{{ route('admin.shipments.events.destroy', [$shipment, $event]) }}" class="inline" onsubmit="return confirm('Delete this event?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline text-xs">Del</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>

    <!-- Right Column -->
    <div class="space-y-6">
        <!-- Notification Prefs -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <h3 class="font-semibold text-fes-navy mb-3">Notification Preferences</h3>
            <ul class="space-y-2 text-sm">
                <li class="flex items-center gap-2">
                    <svg class="w-4 h-4 {{ $shipment->notify_email ? 'text-green-500' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/></svg>
                    <span class="{{ $shipment->notify_email ? 'text-gray-700' : 'text-gray-400' }}">Email</span>
                    @if($shipment->recipient_email)<span class="text-gray-400 text-xs">{{ $shipment->recipient_email }}</span>@endif
                </li>
                <li class="flex items-center gap-2">
                    <svg class="w-4 h-4 {{ $shipment->notify_sms ? 'text-green-500' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/></svg>
                    <span class="{{ $shipment->notify_sms ? 'text-gray-700' : 'text-gray-400' }}">SMS</span>
                    @if($shipment->recipient_phone)<span class="text-gray-400 text-xs">{{ $shipment->recipient_phone }}</span>@endif
                </li>
            </ul>
        </div>

        <!-- Notification Logs -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <h3 class="font-semibold text-fes-navy mb-3">Notification Log</h3>
            @if($shipment->notificationLogs->isEmpty())
                <p class="text-gray-400 text-xs">No notifications sent.</p>
            @else
            <ul class="space-y-2">
                @foreach($shipment->notificationLogs->take(10) as $log)
                <li class="text-xs flex items-start gap-2">
                    <span class="px-1.5 py-0.5 rounded text-[10px] font-medium {{ ['sent'=>'bg-green-100 text-green-700','failed'=>'bg-red-100 text-red-700','skipped'=>'bg-gray-100 text-gray-500'][$log->status] ?? 'bg-gray-100 text-gray-600' }}">{{ strtoupper($log->channel) }} {{ $log->status }}</span>
                    <div class="flex-1 min-w-0">
                        <p class="text-gray-500 truncate">{{ $log->recipient }}</p>
                        @if($log->message)<p class="text-gray-400 truncate">{{ $log->message }}</p>@endif
                        <p class="text-gray-300">{{ $log->created_at->diffForHumans() }}</p>
                    </div>
                </li>
                @endforeach
            </ul>
            @endif
        </div>
    </div>
</div>
@endsection
