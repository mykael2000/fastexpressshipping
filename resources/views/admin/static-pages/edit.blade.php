@extends('layouts.admin')
@section('title', 'Edit: ' . $staticPage->title)

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-fes-navy">Edit Static Page</h1>
    <div class="flex items-center gap-3">
        <a href="{{ route('pages.show', $staticPage->slug) }}" target="_blank" class="text-sm text-gray-500 hover:text-gray-700">View Page ↗</a>
        <a href="{{ route('admin.static-pages.index') }}" class="text-sm text-gray-500 hover:text-gray-700">← Back</a>
    </div>
</div>

<div class="max-w-3xl">
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
        <form method="POST" action="{{ route('admin.static-pages.update', $staticPage) }}" class="space-y-5">
            @csrf @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Title <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title', $staticPage->title) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-fes-orange @error('title') border-red-400 @enderror">
                @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Slug <span class="text-red-500">*</span></label>
                <input type="text" name="slug" value="{{ old('slug', $staticPage->slug) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-fes-orange @error('slug') border-red-400 @enderror">
                @error('slug')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Content</label>
                <textarea name="content" rows="16"
                          class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-fes-orange @error('content') border-red-400 @enderror">{{ old('content', $staticPage->content) }}</textarea>
                <p class="text-xs text-gray-400 mt-1">HTML is supported.</p>
                @error('content')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 border-t border-gray-100 pt-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nav Order</label>
                    <input type="number" name="nav_order" value="{{ old('nav_order', $staticPage->nav_order) }}" min="0"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-fes-orange">
                </div>
                <div class="flex items-center gap-3 pt-6">
                    <input type="checkbox" name="show_in_nav" id="show_in_nav" value="1" {{ old('show_in_nav', $staticPage->show_in_nav) ? 'checked' : '' }} class="rounded text-fes-orange">
                    <label for="show_in_nav" class="text-sm font-medium text-gray-700">Show in Nav</label>
                </div>
                <div class="flex items-center gap-3 pt-6">
                    <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published', $staticPage->is_published) ? 'checked' : '' }} class="rounded text-fes-orange">
                    <label for="is_published" class="text-sm font-medium text-gray-700">Published</label>
                </div>
            </div>

            <div class="flex items-center gap-4 pt-2">
                <button type="submit" class="bg-fes-orange text-white font-semibold px-8 py-2.5 rounded-lg hover:bg-orange-600 transition">Save Changes</button>
                <a href="{{ route('admin.static-pages.index') }}" class="text-sm text-gray-500 hover:text-gray-700">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
