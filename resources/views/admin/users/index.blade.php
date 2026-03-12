@extends('layouts.admin')
@section('title', 'Users')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-fes-navy">Users</h1>
</div>

{{-- Filter --}}
<form method="GET" class="mb-5 flex flex-wrap gap-3 items-center">
    <select name="role" onchange="this.form.submit()"
            class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-fes-orange">
        <option value="">All Roles</option>
        @foreach(['user','staff','admin'] as $r)
            <option value="{{ $r }}" {{ request('role') === $r ? 'selected' : '' }}>{{ ucfirst($r) }}</option>
        @endforeach
    </select>
    @if(request('role'))
        <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-400 hover:text-gray-600">Clear</a>
    @endif
</form>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    @if($users->isEmpty())
        <div class="py-16 text-center text-gray-400 text-sm">No users found.</div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wide">
                    <tr>
                        <th class="px-5 py-3 text-left">Name</th>
                        <th class="px-5 py-3 text-left">Email</th>
                        <th class="px-5 py-3 text-left">Role</th>
                        <th class="px-5 py-3 text-left">Phone</th>
                        <th class="px-5 py-3 text-left">Joined</th>
                        <th class="px-5 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($users as $user)
                    @php
                    $roleBadge = match($user->role) {
                        'admin' => 'bg-red-100 text-red-700',
                        'staff' => 'bg-blue-100 text-blue-700',
                        default => 'bg-gray-100 text-gray-600',
                    };
                    @endphp
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-fes-navy rounded-full flex items-center justify-center text-white text-xs font-bold flex-shrink-0">{{ substr($user->name, 0, 1) }}</div>
                                <span class="font-medium text-gray-800">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-4 text-gray-500">{{ $user->email }}</td>
                        <td class="px-5 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $roleBadge }}">{{ ucfirst($user->role) }}</span>
                        </td>
                        <td class="px-5 py-4 text-gray-500">{{ $user->phone ?? '—' }}</td>
                        <td class="px-5 py-4 text-gray-500">{{ $user->created_at->format('M j, Y') }}</td>
                        <td class="px-5 py-4">
                            <a href="{{ route('admin.users.edit', $user) }}" class="text-fes-orange hover:underline font-medium text-xs">Edit</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
            <div class="px-5 py-4 border-t border-gray-100">{{ $users->links() }}</div>
        @endif
    @endif
</div>
@endsection
