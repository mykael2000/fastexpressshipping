@extends('layouts.admin')
@section('title', 'Edit Shipment')
@section('content')
<div class="max-w-3xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.shipments.show', $shipment) }}" class="text-gray-400 hover:text-fes-navy transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <h1 class="text-2xl font-bold text-fes-navy">Edit Shipment</h1>
    </div>
    <form method="POST" action="{{ route('admin.shipments.update', $shipment) }}" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-5">
        @csrf @method('PUT')
        @include('admin.shipments._form')
        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-fes-orange hover:bg-orange-600 text-white font-semibold px-6 py-2.5 rounded-lg text-sm transition">Save Changes</button>
            <a href="{{ route('admin.shipments.show', $shipment) }}" class="text-gray-500 hover:text-gray-700 px-4 py-2.5 text-sm">Cancel</a>
        </div>
    </form>
</div>
@endsection
