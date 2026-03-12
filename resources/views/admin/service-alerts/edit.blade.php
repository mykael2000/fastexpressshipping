@extends('layouts.admin')
@section('title', 'Edit Alert')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-fes-navy">Edit Service Alert</h1>
    <a href="{{ route('admin.service-alerts.index') }}" class="text-sm text-gray-500 hover:text-gray-700">← Back</a>
</div>

<div class="max-w-xl">
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
        <form method="POST" action="{{ route('admin.service-alerts.update', $serviceAlert) }}" class="space-y-5">
            @csrf @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Title <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title', $serviceAlert->title) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-fes-orange @error('title') border-red-400 @enderror">
                @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Message <span class="text-red-500">*</span></label>
                <textarea name="message" rows="4"
                          class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-fes-orange @error('message') border-red-400 @enderror">{{ old('message', $serviceAlert->message) }}</textarea>
                @error('message')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Type <span class="text-red-500">*</span></label>
                <select name="type" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-fes-orange @error('type') border-red-400 @enderror">
                    @foreach(['info','warning','danger','success'] as $t)
                        <option value="{{ $t }}" {{ old('type', $serviceAlert->type) === $t ? 'selected' : '' }}>{{ ucfirst($t) }}</option>
                    @endforeach
                </select>
                @error('type')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Starts At</label>
                    <input type="datetime-local" name="starts_at"
                           value="{{ old('starts_at', $serviceAlert->starts_at?->format('Y-m-d\TH:i')) }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-fes-orange">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Ends At</label>
                    <input type="datetime-local" name="ends_at"
                           value="{{ old('ends_at', $serviceAlert->ends_at?->format('Y-m-d\TH:i')) }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-fes-orange">
                </div>
            </div>

            <div class="flex items-center gap-3">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $serviceAlert->is_active) ? 'checked' : '' }} class="rounded text-fes-orange">
                <label for="is_active" class="text-sm font-medium text-gray-700">Active</label>
            </div>

            <div class="flex items-center gap-4 pt-2">
                <button type="submit" class="bg-fes-orange text-white font-semibold px-8 py-2.5 rounded-lg hover:bg-orange-600 transition">Save Changes</button>
                <a href="{{ route('admin.service-alerts.index') }}" class="text-sm text-gray-500 hover:text-gray-700">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
