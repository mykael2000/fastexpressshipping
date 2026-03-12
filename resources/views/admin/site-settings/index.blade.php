@extends('layouts.admin')
@section('title', 'Site Settings')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-fes-navy">Site Settings</h1>
</div>

@if(session('success'))
    <div class="mb-5 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">{{ session('success') }}</div>
@endif

<form method="POST" action="{{ route('admin.site-settings.update') }}" class="max-w-2xl space-y-6">
    @csrf

    {{-- Crypto Wallets --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
        <h3 class="font-bold text-fes-navy mb-5 flex items-center gap-2">
            <svg class="w-5 h-5 text-fes-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Cryptocurrency Wallet Addresses
        </h3>
        <div class="space-y-4">
            @php
            $cryptoSettings = [
                ['key' => 'wallet_btc',          'label' => 'Bitcoin (BTC) Wallet Address',     'placeholder' => 'bc1q...'],
                ['key' => 'wallet_eth',          'label' => 'Ethereum (ETH) Wallet Address',    'placeholder' => '0x...'],
                ['key' => 'wallet_usdt_trc20',   'label' => 'USDT TRC-20 Wallet Address',       'placeholder' => 'T...'],
            ];
            @endphp
            @foreach($cryptoSettings as $s)
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ $s['label'] }}</label>
                <input type="text" name="settings[{{ $s['key'] }}]"
                       value="{{ old('settings.'.$s['key'], $settings->where('key', $s['key'])->first()?->value ?? '') }}"
                       placeholder="{{ $s['placeholder'] }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-fes-orange @error('settings.'.$s['key']) border-red-400 @enderror">
                @error('settings.'.$s['key'])<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            @endforeach
        </div>
    </div>

    {{-- Other grouped settings --}}
    @foreach($settings->groupBy('group') as $group => $groupSettings)
        @if($group === 'crypto') @continue @endif
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
            <h3 class="font-bold text-fes-navy mb-5 capitalize">{{ $group ?: 'General' }} Settings</h3>
            <div class="space-y-4">
                @foreach($groupSettings as $setting)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ ucfirst(str_replace('_', ' ', $setting->key)) }}</label>
                    <input type="text" name="settings[{{ $setting->key }}]"
                           value="{{ old('settings.'.$setting->key, $setting->value) }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-fes-orange">
                </div>
                @endforeach
            </div>
        </div>
    @endforeach

    <div class="flex items-center gap-4">
        <button type="submit" class="bg-fes-orange text-white font-semibold px-8 py-2.5 rounded-lg hover:bg-orange-600 transition">Save Settings</button>
    </div>
</form>
@endsection
