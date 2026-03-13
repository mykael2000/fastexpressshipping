@extends('layouts.public')
@section('title', 'Service Alerts — Fast Express Shipping')

@section('content')
<section class="bg-fes-navy text-white py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl font-bold mb-3">Service Alerts</h1>
        <p class="text-gray-300 text-lg">Stay informed about disruptions, maintenance windows, and service updates.</p>
    </div>
</section>

<section class="py-14 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($alerts->isEmpty())
            <div class="text-center py-20">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-fes-navy mb-2">No Current Service Alerts</h2>
                <p class="text-gray-500">All systems are operating normally. Check back here for any service disruptions or maintenance notices.</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach($alerts as $alert)
                    @php
                    $colors = [
                        'info'    => ['bg' => 'bg-blue-50',   'border' => 'border-blue-300',  'icon_bg' => 'bg-blue-100',   'icon' => 'text-blue-600',   'badge' => 'bg-blue-100 text-blue-700',   'title' => 'text-blue-900'],
                        'warning' => ['bg' => 'bg-yellow-50', 'border' => 'border-yellow-300','icon_bg' => 'bg-yellow-100', 'icon' => 'text-yellow-600', 'badge' => 'bg-yellow-100 text-yellow-700','title' => 'text-yellow-900'],
                        'danger'  => ['bg' => 'bg-red-50',    'border' => 'border-red-300',   'icon_bg' => 'bg-red-100',    'icon' => 'text-red-600',    'badge' => 'bg-red-100 text-red-700',     'title' => 'text-red-900'],
                        'success' => ['bg' => 'bg-green-50',  'border' => 'border-green-300', 'icon_bg' => 'bg-green-100',  'icon' => 'text-green-600',  'badge' => 'bg-green-100 text-green-700',  'title' => 'text-green-900'],
                    ];
                    $c = $colors[$alert->type] ?? $colors['info'];
                    @endphp
                    <div class="{{ $c['bg'] }} border {{ $c['border'] }} rounded-xl p-5 flex gap-4">
                        <div class="w-10 h-10 {{ $c['icon_bg'] }} rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                            @if($alert->type === 'danger')
                                <svg class="w-5 h-5 {{ $c['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            @elseif($alert->type === 'warning')
                                <svg class="w-5 h-5 {{ $c['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            @elseif($alert->type === 'success')
                                <svg class="w-5 h-5 {{ $c['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            @else
                                <svg class="w-5 h-5 {{ $c['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-wrap items-center gap-2 mb-1">
                                <h3 class="font-bold {{ $c['title'] }}">{{ $alert->title }}</h3>
                                <span class="text-xs font-semibold px-2 py-0.5 rounded-full {{ $c['badge'] }} uppercase">{{ $alert->type }}</span>
                            </div>
                            <p class="text-gray-700 text-sm leading-relaxed">{{ $alert->message }}</p>
                            <div class="flex flex-wrap gap-4 mt-3 text-xs text-gray-500">
                                @if($alert->starts_at)
                                    <span>From: {{ $alert->starts_at->format('M j, Y H:i') }}</span>
                                @endif
                                @if($alert->ends_at)
                                    <span>Until: {{ $alert->ends_at->format('M j, Y H:i') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <p class="text-center text-gray-400 text-sm mt-10">Last updated: {{ now()->format('M j, Y H:i') }} UTC</p>
    </div>
</section>
@endsection
