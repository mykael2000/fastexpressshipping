<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800">Crypto Payment</h2>
            @if($payment->shipmentRequest)
                <a href="{{ route('user.requests.show', $payment->shipmentRequest) }}" class="text-sm text-gray-500 hover:text-gray-700">← Back to Request</a>
            @endif
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 px-4 space-y-6">

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">{{ session('error') }}</div>
            @endif

            {{-- Status --}}
            @php
            $badge = match($payment->status) {
                'pending'   => ['bg-yellow-100 text-yellow-700', 'Awaiting Payment'],
                'submitted' => ['bg-blue-100 text-blue-700',    'Proof Submitted — Under Review'],
                'paid'      => ['bg-green-100 text-green-700',  'Payment Confirmed'],
                'rejected'  => ['bg-red-100 text-red-700',      'Payment Rejected'],
                default     => ['bg-gray-100 text-gray-600',    ucfirst($payment->status)],
            };
            @endphp
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center justify-between">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $badge[0] }}">{{ $badge[1] }}</span>
                @if($payment->expires_at)
                    <p class="text-sm text-gray-500">Expires: <span class="font-medium">{{ $payment->expires_at->format('M j, Y H:i') }} UTC</span></p>
                @endif
            </div>

            {{-- Payment Details --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-5">
                <h3 class="font-bold text-fes-navy">Payment Details</h3>

                <div class="bg-gray-50 rounded-xl p-5 text-center">
                    <p class="text-4xl font-bold text-fes-navy">${{ number_format($payment->amount_usd, 2) }}</p>
                    <p class="text-gray-400 text-sm mt-1">USD</p>
                </div>

                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Coin</p>
                    <p class="font-bold text-fes-navy text-lg uppercase">{{ $payment->coin_type }}</p>
                </div>

                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-2">Wallet Address</p>
                    <div class="flex items-center gap-3 bg-gray-50 rounded-xl p-4 border border-gray-200" x-data="{ copied: false }">
                        <code class="font-mono text-sm text-gray-800 break-all flex-1">{{ $payment->wallet_address }}</code>
                        <button type="button"
                                @click="navigator.clipboard.writeText('{{ $payment->wallet_address }}'); copied = true; setTimeout(() => copied = false, 2000)"
                                class="flex-shrink-0 text-xs font-semibold px-3 py-1.5 rounded-lg transition"
                                :class="copied ? 'bg-green-100 text-green-700' : 'bg-fes-navy text-white hover:bg-fes-navy-dark'">
                            <span x-text="copied ? '✓ Copied' : 'Copy'"></span>
                        </button>
                    </div>
                </div>

                {{-- QR placeholder --}}
                <div class="border-2 border-dashed border-gray-200 rounded-xl p-8 text-center text-gray-400">
                    <svg class="w-12 h-12 mx-auto mb-3 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 3v-3m-3 3h.01M4 4h4v4H4V4zm12 0h4v4h-4V4zM4 16h4v4H4v-4z"/>
                    </svg>
                    <p class="text-sm font-medium">Scan QR or copy address above</p>
                    <p class="text-xs mt-1">Send exactly the requested amount in {{ strtoupper($payment->coin_type) }}</p>
                </div>
            </div>

            {{-- Paid message --}}
            @if($payment->status === 'paid')
                <div class="bg-green-50 border border-green-200 rounded-xl p-6 text-center">
                    <svg class="w-12 h-12 text-green-500 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <h3 class="font-bold text-green-800 text-lg mb-1">Payment Confirmed!</h3>
                    <p class="text-green-700 text-sm">Your payment has been verified. Our team is processing your shipment.</p>
                </div>

            {{-- Proof upload (pending or submitted) --}}
            @elseif(in_array($payment->status, ['pending', 'submitted']))
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-bold text-fes-navy mb-1">Submit Payment Proof</h3>
                    <p class="text-gray-500 text-sm mb-5">After sending the payment, upload a screenshot or receipt and optionally provide the transaction hash.</p>

                    @if($payment->status === 'submitted')
                        <div class="mb-4 bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-lg text-sm">
                            Proof already submitted. You can resubmit if needed.
                        </div>
                    @endif

                    <form method="POST" action="{{ route('user.payments.proof', $payment) }}" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Proof Screenshot / Receipt <span class="text-red-500">*</span></label>
                            <input type="file" name="proof_file" accept="image/*,.pdf"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-fes-orange @error('proof_file') border-red-400 @enderror">
                            @error('proof_file')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Transaction Hash (optional)</label>
                            <input type="text" name="tx_hash" value="{{ old('tx_hash') }}" placeholder="e.g. 0xabc123..."
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-fes-orange">
                        </div>
                        <button type="submit" class="w-full bg-fes-orange text-white font-semibold py-3 rounded-lg hover:bg-orange-600 transition">
                            Submit Payment Proof
                        </button>
                    </form>
                </div>

            {{-- Rejected --}}
            @elseif($payment->status === 'rejected')
                <div class="bg-red-50 border border-red-200 rounded-xl p-6">
                    <h3 class="font-bold text-red-800 mb-1">Payment Rejected</h3>
                    @if($payment->admin_notes)
                        <p class="text-red-700 text-sm">Admin note: {{ $payment->admin_notes }}</p>
                    @endif
                    <p class="text-red-600 text-sm mt-2">Please contact support if you believe this is an error.</p>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
