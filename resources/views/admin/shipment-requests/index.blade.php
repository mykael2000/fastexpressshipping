@extends('layouts.admin')
@section('title', 'Shipment Requests')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-fes-navy">Shipment Requests</h1>
</div>

{{-- Filter --}}
<form method="GET" class="mb-5 flex flex-wrap gap-3 items-center">
    <select name="status" onchange="this.form.submit()"
            class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-fes-orange">
        <option value="">All Statuses</option>
        @foreach(['pending','approved','denied','payment_required','paid','shipped'] as $s)
            <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
        @endforeach
    </select>
    @if(request('status'))
        <a href="{{ route('admin.shipment-requests.index') }}" class="text-sm text-gray-400 hover:text-gray-600">Clear</a>
    @endif
</form>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    @if($requests->isEmpty())
        <div class="py-16 text-center text-gray-400 text-sm">No shipment requests found.</div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wide">
                    <tr>
                        <th class="px-5 py-3 text-left">ID</th>
                        <th class="px-5 py-3 text-left">User</th>
                        <th class="px-5 py-3 text-left">Date</th>
                        <th class="px-5 py-3 text-left">Status</th>
                        <th class="px-5 py-3 text-left">Route</th>
                        <th class="px-5 py-3 text-left">Service</th>
                        <th class="px-5 py-3 text-left">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($requests as $req)
                    @php
                    $badge = match($req->status) {
                        'pending'          => 'bg-yellow-100 text-yellow-700',
                        'approved'         => 'bg-blue-100 text-blue-700',
                        'denied'           => 'bg-red-100 text-red-700',
                        'payment_required' => 'bg-purple-100 text-purple-700',
                        'paid'             => 'bg-green-100 text-green-700',
                        'shipped'          => 'bg-indigo-100 text-indigo-700',
                        default            => 'bg-gray-100 text-gray-600',
                    };
                    @endphp
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-5 py-4 font-mono text-gray-500 text-xs">#{{ $req->id }}</td>
                        <td class="px-5 py-4">
                            <p class="font-medium text-gray-800">{{ $req->user->name ?? '—' }}</p>
                            <p class="text-xs text-gray-400">{{ $req->user->email ?? '' }}</p>
                        </td>
                        <td class="px-5 py-4 text-gray-600">{{ $req->created_at->format('M j, Y') }}</td>
                        <td class="px-5 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badge }}">
                                {{ ucfirst(str_replace('_', ' ', $req->status)) }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-gray-600">{{ $req->sender_country ?? '—' }} → {{ $req->recipient_country ?? '—' }}</td>
                        <td class="px-5 py-4 text-gray-600 capitalize">{{ $req->service_level ?? '—' }}</td>
                        <td class="px-5 py-4">
                            <a href="{{ route('admin.shipment-requests.show', $req) }}" class="text-fes-orange hover:underline font-medium text-xs">View</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($requests->hasPages())
            <div class="px-5 py-4 border-t border-gray-100">{{ $requests->links() }}</div>
        @endif
    @endif
</div>
@endsection
