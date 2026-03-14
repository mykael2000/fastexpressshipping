<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-medium text-fes-orange">User Dashboard</p>
                <h2 class="text-2xl font-extrabold text-fes-navy">My Dashboard</h2>
                <p class="mt-1 text-sm text-gray-500">
                    Monitor your shipment requests, payment progress, and delivery activity in one place.
                </p>
            </div>

            <a
                href="{{ route('user.requests.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-fes-orange px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-orange-600"
            >
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Submit New Request
            </a>
        </div>
    </x-slot>

    <div class="bg-gray-50 py-10">
        <div class="mx-auto max-w-7xl space-y-8 px-4 sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="flex items-start gap-3 rounded-2xl border border-green-200 bg-green-50 px-4 py-4 text-sm text-green-700 shadow-sm">
                    <svg class="mt-0.5 h-5 w-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            @if(session('error'))
                <div class="flex items-start gap-3 rounded-2xl border border-red-200 bg-red-50 px-4 py-4 text-sm text-red-700 shadow-sm">
                    <svg class="mt-0.5 h-5 w-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <div>{{ session('error') }}</div>
                </div>
            @endif

            @php
                $totalRequests = $requests->total();
                $pendingCount = $requests->where('status', 'pending')->count();
                $paidCount = $requests->where('status', 'paid')->count();
                $shippedCount = $requests->where('status', 'shipped')->count();
            @endphp

            <!-- Welcome / Hero -->
            <section class="relative overflow-hidden rounded-3xl bg-fes-navy shadow-xl">
                <div class="absolute inset-0 bg-gradient-to-r from-fes-navy via-fes-navy to-slate-900"></div>
                <div class="absolute -top-16 -right-16 h-56 w-56 rounded-full bg-fes-orange/10 blur-3xl"></div>
                <div class="absolute -bottom-16 -left-16 h-56 w-56 rounded-full bg-white/5 blur-3xl"></div>

                <div class="relative grid gap-8 p-6 sm:p-8 lg:grid-cols-3 lg:p-10">
                    <div class="lg:col-span-2">
                        <span class="inline-flex rounded-full border border-white/10 bg-white/10 px-4 py-2 text-sm font-medium text-white">
                            Welcome back
                        </span>

                        <h3 class="mt-5 text-3xl font-extrabold text-white sm:text-4xl">
                            Hello, {{ auth()->user()->name }}!
                        </h3>

                        <p class="mt-4 max-w-2xl text-base leading-7 text-gray-300 sm:text-lg">
                            Manage your shipment requests, review payment updates, track delivery progress,
                            and stay informed at every stage of the shipping process.
                        </p>

                        <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                            <a
                                href="{{ route('user.requests.create') }}"
                                class="inline-flex items-center justify-center rounded-xl bg-fes-orange px-5 py-3 text-sm font-semibold text-white transition hover:bg-orange-600"
                            >
                                Submit New Request
                            </a>

                            <a
                                href="#requests-table"
                                class="inline-flex items-center justify-center rounded-xl border border-white/20 bg-white/10 px-5 py-3 text-sm font-semibold text-white transition hover:bg-white/15"
                            >
                                View My Requests
                            </a>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-white/10 bg-white/10 p-6 backdrop-blur-sm">
                        <h4 class="text-lg font-bold text-white">Account Overview</h4>
                        <div class="mt-6 space-y-4">
                            <div class="flex items-center justify-between border-b border-white/10 pb-3">
                                <span class="text-sm text-gray-300">Account Name</span>
                                <span class="text-sm font-semibold text-white">{{ auth()->user()->name }}</span>
                            </div>
                            <div class="flex items-center justify-between border-b border-white/10 pb-3">
                                <span class="text-sm text-gray-300">Email</span>
                                <span class="text-sm font-semibold text-white">{{ auth()->user()->email }}</span>
                            </div>
                            <div class="flex items-center justify-between border-b border-white/10 pb-3">
                                <span class="text-sm text-gray-300">Requests</span>
                                <span class="text-sm font-semibold text-white">{{ $totalRequests }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-300">Dashboard Access</span>
                                <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                    Active
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Stats -->
            <section class="grid gap-6 sm:grid-cols-2 xl:grid-cols-4">
                <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Requests</p>
                            <p class="mt-3 text-3xl font-extrabold text-fes-navy">{{ $totalRequests }}</p>
                        </div>
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-fes-orange/10">
                            <svg class="h-6 w-6 text-fes-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                    </div>
                    <p class="mt-4 text-sm text-gray-500">All shipment requests submitted from your account.</p>
                </div>

                <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Pending</p>
                            <p class="mt-3 text-3xl font-extrabold text-yellow-600">{{ $pendingCount }}</p>
                        </div>
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-yellow-100">
                            <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="mt-4 text-sm text-gray-500">Requests awaiting approval, processing, or next action.</p>
                </div>

                <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Paid</p>
                            <p class="mt-3 text-3xl font-extrabold text-green-600">{{ $paidCount }}</p>
                        </div>
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-green-100">
                            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                    </div>
                    <p class="mt-4 text-sm text-gray-500">Requests with completed or confirmed payment status.</p>
                </div>

                <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Shipped</p>
                            <p class="mt-3 text-3xl font-extrabold text-indigo-600">{{ $shippedCount }}</p>
                        </div>
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-indigo-100">
                            <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h13l4 4v6a2 2 0 01-2 2h-1a3 3 0 11-6 0H9a3 3 0 11-6 0H2V9a2 2 0 012-2h1z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="mt-4 text-sm text-gray-500">Requests currently in transit or marked as shipped.</p>
                </div>
            </section>

            <!-- Quick Actions -->
            <section class="grid gap-6 lg:grid-cols-3">
                <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-bold text-fes-navy">Quick Actions</h3>
                    <p class="mt-2 text-sm text-gray-500">Access the most important actions from your dashboard.</p>

                    <div class="mt-6 grid gap-3">
                        <a href="{{ route('user.requests.create') }}" class="flex items-center justify-between rounded-xl border border-gray-200 px-4 py-3 text-sm font-medium text-gray-700 transition hover:border-fes-orange hover:text-fes-orange">
                            <span>Submit New Shipment Request</span>
                            <span>→</span>
                        </a>
                        <a href="#requests-table" class="flex items-center justify-between rounded-xl border border-gray-200 px-4 py-3 text-sm font-medium text-gray-700 transition hover:border-fes-orange hover:text-fes-orange">
                            <span>View My Requests</span>
                            <span>→</span>
                        </a>
                    </div>
                </div>

                <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-bold text-fes-navy">Tracking Tips</h3>
                    <p class="mt-2 text-sm text-gray-500">Helpful reminders for managing shipment requests smoothly.</p>

                    <div class="mt-6 space-y-4">
                        <div>
                            <h4 class="text-sm font-semibold text-fes-navy">Review status updates</h4>
                            <p class="mt-1 text-sm text-gray-500">Check your dashboard regularly for request approvals and payment notices.</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-fes-navy">Confirm shipment details</h4>
                            <p class="mt-1 text-sm text-gray-500">Ensure your sender and recipient information is correct when submitting a request.</p>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl bg-fes-navy p-6 text-white shadow-sm">
                    <h3 class="text-lg font-bold">Shipping Support</h3>
                    <p class="mt-2 text-sm text-gray-300">
                        Our team is committed to making your shipping experience clear, secure and efficient.
                    </p>

                    <div class="mt-6 space-y-3">
                        <div class="rounded-xl border border-white/10 bg-white/10 px-4 py-3 text-sm text-gray-200">
                            Submit requests with complete shipment details for faster processing.
                        </div>
                        <div class="rounded-xl border border-white/10 bg-white/10 px-4 py-3 text-sm text-gray-200">
                            Monitor changes in status such as payment required, approved, paid and shipped.
                        </div>
                    </div>
                </div>
            </section>

            <!-- Requests Table -->
            <section id="requests-table" class="overflow-hidden rounded-3xl border border-gray-100 bg-white shadow-sm">
                <div class="flex flex-col gap-3 border-b border-gray-100 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h3 class="text-xl font-bold text-fes-navy">Shipment Requests</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Review all shipment requests submitted through your account.
                        </p>
                    </div>
                    <span class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-600">
                        {{ $requests->total() }} total
                    </span>
                </div>

                @if($requests->isEmpty())
                    <div class="px-6 py-16 text-center">
                        <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-fes-orange/10">
                            <svg class="h-10 w-10 text-fes-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        <h4 class="mt-6 text-xl font-bold text-fes-navy">No shipment requests yet</h4>
                        <p class="mx-auto mt-2 max-w-md text-sm text-gray-500">
                            You haven’t submitted any shipment requests yet. Start by creating your first request and track it from this dashboard.
                        </p>
                        <a
                            href="{{ route('user.requests.create') }}"
                            class="mt-6 inline-flex items-center justify-center rounded-xl bg-fes-orange px-5 py-3 text-sm font-semibold text-white transition hover:bg-orange-600"
                        >
                            Submit Request
                        </a>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                <tr>
                                    <th class="px-6 py-4">ID</th>
                                    <th class="px-6 py-4">Date</th>
                                    <th class="px-6 py-4">Status</th>
                                    <th class="px-6 py-4">From → To</th>
                                    <th class="px-6 py-4">Service</th>
                                    <th class="px-6 py-4">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
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

                                    <tr class="transition hover:bg-gray-50">
                                        <td class="whitespace-nowrap px-6 py-4 font-mono text-xs text-gray-500">
                                            #{{ $req->id }}
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-gray-600">
                                            {{ $req->created_at->format('M j, Y') }}
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4">
                                            <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $badge }}">
                                                {{ ucfirst(str_replace('_', ' ', $req->status)) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-gray-600">
                                            {{ $req->sender_country ?? '—' }} → {{ $req->recipient_country ?? '—' }}
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 capitalize text-gray-600">
                                            {{ $req->service_level ?? '—' }}
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4">
                                            <a
                                                href="{{ route('user.requests.show', $req) }}"
                                                class="inline-flex rounded-lg bg-fes-orange/10 px-3 py-2 text-xs font-semibold text-fes-orange transition hover:bg-fes-orange hover:text-white"
                                            >
                                                View Details
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($requests->hasPages())
                        <div class="border-t border-gray-100 px-6 py-4">
                            {{ $requests->links() }}
                        </div>
                    @endif
                @endif
            </section>
        </div>
    </div>
</x-app-layout>
