@extends('layouts.admin')
@section('title', 'Service Alerts')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-fes-navy">Service Alerts</h1>
    <a href="{{ route('admin.service-alerts.create') }}" class="bg-fes-orange text-white text-sm font-semibold px-5 py-2.5 rounded-lg hover:bg-orange-600 transition inline-flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Create Alert
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    @if($alerts->isEmpty())
        <div class="py-16 text-center text-gray-400 text-sm">No service alerts yet.</div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wide">
                    <tr>
                        <th class="px-5 py-3 text-left">Title</th>
                        <th class="px-5 py-3 text-left">Type</th>
                        <th class="px-5 py-3 text-left">Active</th>
                        <th class="px-5 py-3 text-left">Starts</th>
                        <th class="px-5 py-3 text-left">Ends</th>
                        <th class="px-5 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($alerts as $alert)
                    @php
                    $typeBadge = match($alert->type) {
                        'info'    => 'bg-blue-100 text-blue-700',
                        'warning' => 'bg-yellow-100 text-yellow-700',
                        'danger'  => 'bg-red-100 text-red-700',
                        'success' => 'bg-green-100 text-green-700',
                        default   => 'bg-gray-100 text-gray-600',
                    };
                    @endphp
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-5 py-4 font-medium text-gray-800">{{ $alert->title }}</td>
                        <td class="px-5 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $typeBadge }}">{{ ucfirst($alert->type) }}</span>
                        </td>
                        <td class="px-5 py-4">
                            @if($alert->is_active)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">Active</span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-400">Inactive</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-gray-500 text-xs">{{ $alert->starts_at?->format('M j, Y H:i') ?? '—' }}</td>
                        <td class="px-5 py-4 text-gray-500 text-xs">{{ $alert->ends_at?->format('M j, Y H:i') ?? '—' }}</td>
                        <td class="px-5 py-4 flex items-center gap-3">
                            <a href="{{ route('admin.service-alerts.edit', $alert) }}" class="text-fes-orange hover:underline font-medium text-xs">Edit</a>
                            <form method="POST" action="{{ route('admin.service-alerts.destroy', $alert) }}" onsubmit="return confirm('Delete this alert?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-600 font-medium text-xs">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
