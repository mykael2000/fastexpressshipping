@extends('layouts.admin')
@section('title', 'Create Shipment from Request #' . $shipmentRequest->id)

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-fes-navy">Create Shipment</h1>
    <a href="{{ route('admin.shipment-requests.show', $shipmentRequest) }}" class="text-sm text-gray-500 hover:text-gray-700">← Back to Request</a>
</div>

<div class="max-w-xl">
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 mb-5">
        <h3 class="font-semibold text-gray-700 mb-3 text-sm">Request Summary</h3>
        <dl class="grid grid-cols-2 gap-3 text-sm">
            <div><dt class="text-gray-400 text-xs">Request ID</dt><dd class="font-mono">#{{ $shipmentRequest->id }}</dd></div>
            <div><dt class="text-gray-400 text-xs">User</dt><dd>{{ $shipmentRequest->user->name ?? '—' }}</dd></div>
            <div><dt class="text-gray-400 text-xs">From</dt><dd>{{ $shipmentRequest->sender_country }}</dd></div>
            <div><dt class="text-gray-400 text-xs">To</dt><dd>{{ $shipmentRequest->recipient_country }}</dd></div>
        </dl>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
        <form method="POST" action="{{ route('admin.shipment-requests.store-shipment', $shipmentRequest) }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Service Level</label>
                <select name="service_level" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-fes-orange @error('service_level') border-red-400 @enderror">
                    <option value="standard" {{ ($shipmentRequest->service_level ?? '') === 'standard' ? 'selected' : '' }}>Standard</option>
                    <option value="express" {{ ($shipmentRequest->service_level ?? '') === 'express' ? 'selected' : '' }}>Express</option>
                    <option value="overnight" {{ ($shipmentRequest->service_level ?? '') === 'overnight' ? 'selected' : '' }}>Overnight</option>
                </select>
                @error('service_level')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Admin Notes (optional)</label>
                <textarea name="notes" rows="4" placeholder="Internal notes about this shipment…"
                          class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-fes-orange">{{ old('notes') }}</textarea>
            </div>

            <div class="flex items-center gap-4 pt-2">
                <button type="submit" class="bg-fes-navy text-white font-semibold px-8 py-2.5 rounded-lg hover:bg-fes-navy-dark transition">
                    Create Shipment
                </button>
                <a href="{{ route('admin.shipment-requests.show', $shipmentRequest) }}" class="text-sm text-gray-500 hover:text-gray-700">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
