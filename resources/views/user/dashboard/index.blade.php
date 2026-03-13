<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800">My Dashboard</h2>
            <a href="{{ route('user.requests.create') }}" class="bg-fes-orange text-white text-sm font-semibold px-5 py-2.5 rounded-lg hover:bg-orange-600 transition inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Submit New Request
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 px-4">

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm flex items-center gap-2">
                    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm flex items-center gap-2">
                    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    {{ session('error') }}
                </div>
            @endif

            {{-- Welcome --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-800 text-lg mb-1">Welcome back, {{ auth()->user()->name }}!</h3>
                <p class="text-gray-500 text-sm">Track your shipment requests, view payment details, and manage your account below.</p>
            </div>

            {{-- Requests Table --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="font-bold text-gray-800">Shipment Requests</h3>
                    <span class="text-xs text-gray-400">{{ $requests->total() }} total</span>
                </div>

                @if($requests->isEmpty())
                    <div class="py-16 text-center text-gray-400">
                        <svg class="w-14 h-14 mx-auto mb-4 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        <p class="font-medium">No requests yet</p>
                        <p class="text-sm mt-1">Submit your first shipment request to get started.</p>
                        <a href="{{ route('user.requests.create') }}" class="inline-block mt-4 bg-fes-orange text-white text-sm font-semibold px-5 py-2.5 rounded-lg hover:bg-orange-600 transition">Submit Request</a>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wide">
                                <tr>
                                    <th class="px-6 py-3 text-left">ID</th>
                                    <th class="px-6 py-3 text-left">Date</th>
                                    <th class="px-6 py-3 text-left">Status</th>
                                    <th class="px-6 py-3 text-left">From → To</th>
                                    <th class="px-6 py-3 text-left">Service</th>
                                    <th class="px-6 py-3 text-left">Action</th>
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
                                    <td class="px-6 py-4 font-mono text-gray-500 text-xs">#{{ $req->id }}</td>
                                    <td class="px-6 py-4 text-gray-600">{{ $req->created_at->format('M j, Y') }}</td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badge }}">
                                            {{ ucfirst(str_replace('_', ' ', $req->status)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600">
                                        {{ $req->sender_country ?? '—' }} → {{ $req->recipient_country ?? '—' }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-600 capitalize">{{ $req->service_level ?? '—' }}</td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('user.requests.show', $req) }}" class="text-fes-orange hover:underline font-medium text-xs">View</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if($requests->hasPages())
                        <div class="px-6 py-4 border-t border-gray-100">
                            {{ $requests->links() }}
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
