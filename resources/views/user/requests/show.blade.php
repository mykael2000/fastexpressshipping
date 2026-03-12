<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800">Shipment Request #{{ $request->id }}</h2>
            <a href="{{ route('user.dashboard') }}" class="text-sm text-gray-500 hover:text-gray-700">← Back to Dashboard</a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 px-4 space-y-6">

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">{{ session('success') }}</div>
            @endif

            {{-- Status Banner --}}
            @php
            $badge = match($request->status) {
                'pending'          => ['bg-yellow-100 text-yellow-700', 'Pending Review'],
                'approved'         => ['bg-blue-100 text-blue-700', 'Approved'],
                'denied'           => ['bg-red-100 text-red-700', 'Denied'],
                'payment_required' => ['bg-purple-100 text-purple-700', 'Payment Required'],
                'paid'             => ['bg-green-100 text-green-700', 'Payment Confirmed'],
                'shipped'          => ['bg-indigo-100 text-indigo-700', 'Shipped'],
                default            => ['bg-gray-100 text-gray-600', ucfirst($request->status)],
            };
            @endphp
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Status</p>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $badge[0] }}">{{ $badge[1] }}</span>
                    @if($request->status === 'denied' && $request->admin_notes)
                        <p class="text-red-600 text-sm mt-2"><span class="font-medium">Admin note:</span> {{ $request->admin_notes }}</p>
                    @endif
                </div>
                <div class="text-right text-sm text-gray-500">
                    <p>Submitted {{ $request->created_at->format('M j, Y H:i') }}</p>
                    <p class="capitalize">{{ $request->service_level ?? '—' }} service</p>
                </div>
            </div>

            {{-- Sender / Recipient --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-bold text-fes-navy mb-4 text-sm uppercase tracking-wide">Sender</h3>
                    <dl class="space-y-2 text-sm">
                        <div><dt class="text-gray-400 text-xs">Name</dt><dd class="text-gray-800">{{ $request->sender_name }}</dd></div>
                        <div><dt class="text-gray-400 text-xs">Email</dt><dd class="text-gray-800">{{ $request->sender_email }}</dd></div>
                        <div><dt class="text-gray-400 text-xs">Phone</dt><dd class="text-gray-800">{{ $request->sender_phone ?? '—' }}</dd></div>
                        <div>
                            <dt class="text-gray-400 text-xs">Address</dt>
                            <dd class="text-gray-800">
                                {{ $request->sender_address1 }}<br>
                                @if($request->sender_address2){{ $request->sender_address2 }}<br>@endif
                                {{ $request->sender_city }}, {{ $request->sender_state }} {{ $request->sender_postal }}<br>
                                {{ $request->sender_country }}
                            </dd>
                        </div>
                    </dl>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-bold text-fes-navy mb-4 text-sm uppercase tracking-wide">Recipient</h3>
                    <dl class="space-y-2 text-sm">
                        <div><dt class="text-gray-400 text-xs">Name</dt><dd class="text-gray-800">{{ $request->recipient_name }}</dd></div>
                        <div><dt class="text-gray-400 text-xs">Email</dt><dd class="text-gray-800">{{ $request->recipient_email }}</dd></div>
                        <div><dt class="text-gray-400 text-xs">Phone</dt><dd class="text-gray-800">{{ $request->recipient_phone ?? '—' }}</dd></div>
                        <div>
                            <dt class="text-gray-400 text-xs">Address</dt>
                            <dd class="text-gray-800">
                                {{ $request->recipient_address1 }}<br>
                                @if($request->recipient_address2){{ $request->recipient_address2 }}<br>@endif
                                {{ $request->recipient_city }}, {{ $request->recipient_state }} {{ $request->recipient_postal }}<br>
                                {{ $request->recipient_country }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            {{-- Package Items --}}
            @if($request->packageItems && $request->packageItems->count())
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-bold text-fes-navy">Package Items</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                            <tr>
                                <th class="px-4 py-3 text-left">Type</th>
                                <th class="px-4 py-3 text-left">Qty</th>
                                <th class="px-4 py-3 text-left">Weight</th>
                                <th class="px-4 py-3 text-left">Dimensions</th>
                                <th class="px-4 py-3 text-left">Declared Value</th>
                                <th class="px-4 py-3 text-left">Contents</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($request->packageItems as $item)
                            <tr>
                                <td class="px-4 py-3 capitalize">{{ $item->package_type }}</td>
                                <td class="px-4 py-3">{{ $item->quantity }}</td>
                                <td class="px-4 py-3">{{ $item->weight }} {{ $item->weight_unit }}</td>
                                <td class="px-4 py-3">{{ $item->length }} × {{ $item->width }} × {{ $item->height }} {{ $item->dimension_unit }}</td>
                                <td class="px-4 py-3">{{ number_format($item->declared_value, 2) }} {{ $item->currency }}</td>
                                <td class="px-4 py-3 text-gray-500">{{ $item->contents_description ?? '—' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            {{-- Shipment Info --}}
            @if($request->shipment)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-fes-navy mb-4">Shipment Tracking</h3>
                <div class="flex flex-wrap items-center gap-4">
                    <div>
                        <p class="text-xs text-gray-400">Tracking Number</p>
                        <p class="font-mono font-bold text-fes-navy text-lg">{{ $request->shipment->tracking_number }}</p>
                    </div>
                    <a href="{{ route('track.show', $request->shipment->tracking_number) }}" class="bg-fes-orange text-white text-sm font-semibold px-5 py-2.5 rounded-lg hover:bg-orange-600 transition">
                        Track Shipment
                    </a>
                </div>
            </div>
            @endif

            {{-- Payment Info --}}
            @if($request->cryptoPayments && $request->cryptoPayments->count())
            @php $payment = $request->cryptoPayments->first(); @endphp
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-fes-navy mb-4">Payment</h3>
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div class="space-y-1 text-sm">
                        <p><span class="text-gray-400">Amount:</span> <span class="font-bold">${{ number_format($payment->amount_usd, 2) }} USD</span></p>
                        <p><span class="text-gray-400">Coin:</span> <span class="font-medium uppercase">{{ $payment->coin_type }}</span></p>
                        <p>
                            <span class="text-gray-400">Status:</span>
                            @php
                            $pb = match($payment->status) {
                                'pending'   => 'bg-yellow-100 text-yellow-700',
                                'submitted' => 'bg-blue-100 text-blue-700',
                                'paid'      => 'bg-green-100 text-green-700',
                                'rejected'  => 'bg-red-100 text-red-700',
                                default     => 'bg-gray-100 text-gray-600',
                            };
                            @endphp
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $pb }}">{{ ucfirst($payment->status) }}</span>
                        </p>
                    </div>
                    @if(in_array($payment->status, ['pending', 'submitted']))
                        <a href="{{ route('user.payments.show', $payment) }}" class="bg-fes-orange text-white text-sm font-semibold px-5 py-2.5 rounded-lg hover:bg-orange-600 transition">
                            View &amp; Pay
                        </a>
                    @endif
                </div>
            </div>
            @endif

        </div>
    </div>
</x-app-layout>
