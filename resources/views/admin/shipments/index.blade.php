@extends('layouts.admin')
@section('title', 'Shipments')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-fes-navy">Shipments</h1>
    <a href="{{ route('admin.shipments.create') }}" class="bg-fes-orange hover:bg-orange-600 text-white font-semibold px-5 py-2.5 rounded-lg text-sm transition shadow-sm">
        + New Shipment
    </a>
</div>

<!-- Filters -->
<form method="GET" class="flex flex-col sm:flex-row gap-3 mb-6 bg-white border border-gray-100 rounded-xl shadow-sm p-4">
    <input name="search" value="{{ request('search') }}" placeholder="Search tracking #, name, email…" class="flex-1 border border-gray-200 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-fes-orange">
    <select name="status" class="border border-gray-200 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-fes-orange">
        <option value="">All Statuses</option>
        @foreach($statusOptions as $val => $label)
            <option value="{{ $val }}" @selected(request('status') === $val)>{{ $label }}</option>
        @endforeach
    </select>
    <button type="submit" class="bg-fes-navy text-white px-5 py-2 rounded-lg text-sm hover:bg-fes-navy-dark transition">Filter</button>
    @if(request()->hasAny(['search','status']))
        <a href="{{ route('admin.shipments.index') }}" class="text-gray-500 hover:text-gray-700 px-3 py-2 text-sm">Clear</a>
    @endif
</form>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-100">
            <tr>
                <th class="text-left px-4 py-3 text-gray-500 font-medium">Tracking #</th>
                <th class="text-left px-4 py-3 text-gray-500 font-medium hidden sm:table-cell">Recipient</th>
                <th class="text-left px-4 py-3 text-gray-500 font-medium hidden md:table-cell">Destination</th>
                <th class="text-left px-4 py-3 text-gray-500 font-medium">Status</th>
                <th class="text-left px-4 py-3 text-gray-500 font-medium hidden lg:table-cell">ETA</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($shipments as $shipment)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-4 py-3 font-mono font-semibold text-fes-navy">
                    <a href="{{ route('admin.shipments.show', $shipment) }}" class="hover:underline">{{ $shipment->tracking_number }}</a>
                </td>
                <td class="px-4 py-3 text-gray-600 hidden sm:table-cell">{{ $shipment->recipient_name }}</td>
                <td class="px-4 py-3 text-gray-500 hidden md:table-cell">{{ $shipment->destination }}</td>
                <td class="px-4 py-3">
                    <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ ['delivered'=>'bg-green-100 text-green-700','exception'=>'bg-red-100 text-red-700','in_transit'=>'bg-yellow-100 text-yellow-700','out_for_delivery'=>'bg-purple-100 text-purple-700','picked_up'=>'bg-blue-100 text-blue-700'][$shipment->status] ?? 'bg-gray-100 text-gray-600' }}">
                        {{ $shipment->statusLabel() }}
                    </span>
                </td>
                <td class="px-4 py-3 text-gray-500 hidden lg:table-cell">{{ $shipment->eta ? $shipment->eta->format('M d, Y') : '—' }}</td>
                <td class="px-4 py-3 text-right">
                    <a href="{{ route('admin.shipments.edit', $shipment) }}" class="text-fes-orange hover:underline text-xs mr-3">Edit</a>
                    <form method="POST" action="{{ route('admin.shipments.destroy', $shipment) }}" class="inline" onsubmit="return confirm('Delete this shipment?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-500 hover:underline text-xs">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-4 py-12 text-center text-gray-400">No shipments found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    @if($shipments->hasPages())
        <div class="px-4 py-3 border-t border-gray-100">{{ $shipments->links() }}</div>
    @endif
</div>
@endsection
