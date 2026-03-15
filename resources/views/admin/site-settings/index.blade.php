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

    {{-- Bank Transfer Details --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
        <h3 class="font-bold text-fes-navy mb-5 flex items-center gap-2">
            <svg class="w-5 h-5 text-fes-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>
            </svg>
            Bank Transfer Details
        </h3>
        <div class="space-y-4">
            @php
            $bankSettings = [
                ['key' => 'bank_name',           'label' => 'Bank Name',           'placeholder' => 'e.g. First Bank'],
                ['key' => 'bank_account_name',   'label' => 'Account Name',        'placeholder' => 'e.g. Fast Express Shipping Ltd'],
                ['key' => 'bank_account_number', 'label' => 'Account Number',      'placeholder' => 'e.g. 0123456789'],
                ['key' => 'bank_note',           'label' => 'Bank Note (optional)', 'placeholder' => 'e.g. Use tracking number as reference'],
            ];
            @endphp
            @foreach($bankSettings as $s)
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ $s['label'] }}</label>
                <input type="text" name="settings[{{ $s['key'] }}]"
                       value="{{ old('settings.'.$s['key'], \App\Models\SiteSetting::get($s['key'], '')) }}"
                       placeholder="{{ $s['placeholder'] }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-fes-orange">
            </div>
            @endforeach
        </div>
    </div>

    {{-- WhatsApp --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
        <h3 class="font-bold text-fes-navy mb-5 flex items-center gap-2">
            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
            </svg>
            WhatsApp Widget
        </h3>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">WhatsApp Number</label>
            <input type="text" name="settings[whatsapp_number]"
                   value="{{ old('settings.whatsapp_number', \App\Models\SiteSetting::get('whatsapp_number', '')) }}"
                   placeholder="e.g. 2348012345678"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-fes-orange">
            <p class="text-gray-400 text-xs mt-1">Digits only, include country code, no + or spaces. Example: <code>2348012345678</code> (Nigeria) or <code>14155552671</code> (US).</p>
        </div>
    </div>

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
                       value="{{ old('settings.'.$s['key'], ($settings->flatten(1)->where('key', $s['key'])->first()?->value ?? '') ?? '') }}"
                       placeholder="{{ $s['placeholder'] }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-fes-orange @error('settings.'.$s['key']) border-red-400 @enderror">
                @error('settings.'.$s['key'])<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            @endforeach
        </div>
    </div>

    {{-- Other grouped settings --}}
    {{-- @foreach($settings->groupBy('group') as $group => $groupSettings)
        @if($group === 'crypto') @continue @endif
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
            <h3 class="font-bold text-fes-navy mb-5 capitalize">{{ $group ?: 'General' }} Settings</h3>
            <div class="space-y-4">
                @foreach($groupSettings as $setting)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ ucfirst(str_replace('_', ' ', $setting->key)) }}</label>
                    @if($setting->key === 'contact_address')
                    <textarea name="settings[{{ $setting->key }}]" rows="2"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-fes-orange">{{ old('settings.'.$setting->key, $setting->value) }}</textarea>
                    @else
                    <input type="text" name="settings[{{ $setting->key }}]"
                           value="{{ old('settings.'.$setting->key, $setting->value) }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-fes-orange">
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    @endforeach --}}

    <div class="flex items-center gap-4">
        <button type="submit" class="bg-fes-orange text-white font-semibold px-8 py-2.5 rounded-lg hover:bg-orange-600 transition">Save Settings</button>
    </div>
</form>
@endsection
