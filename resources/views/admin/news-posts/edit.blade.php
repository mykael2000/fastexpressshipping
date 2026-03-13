@extends('layouts.admin')
@section('title', 'Edit: ' . $newsPost->title)

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-fes-navy">Edit News Post</h1>
    <a href="{{ route('admin.news-posts.index') }}" class="text-sm text-gray-500 hover:text-gray-700">← Back</a>
</div>

<div class="max-w-3xl">
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
        <form method="POST" action="{{ route('admin.news-posts.update', $newsPost) }}" class="space-y-5">
            @csrf @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Title <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title', $newsPost->title) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-fes-orange @error('title') border-red-400 @enderror">
                @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                <input type="text" name="slug" value="{{ old('slug', $newsPost->slug) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-fes-orange @error('slug') border-red-400 @enderror">
                @error('slug')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Excerpt</label>
                <textarea name="excerpt" rows="2"
                          class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-fes-orange @error('excerpt') border-red-400 @enderror">{{ old('excerpt', $newsPost->excerpt) }}</textarea>
                @error('excerpt')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Body <span class="text-red-500">*</span></label>
                <textarea name="body" rows="12"
                          class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-fes-orange @error('body') border-red-400 @enderror">{{ old('body', $newsPost->body) }}</textarea>
                @error('body')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Publish Date</label>
                    <input type="datetime-local" name="published_at"
                           value="{{ old('published_at', $newsPost->published_at?->format('Y-m-d\TH:i')) }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-fes-orange">
                </div>
                <div class="flex items-center gap-3 pt-6">
                    <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published', $newsPost->is_published) ? 'checked' : '' }} class="rounded text-fes-orange">
                    <label for="is_published" class="text-sm font-medium text-gray-700">Published</label>
                </div>
            </div>

            <div class="flex items-center gap-4 pt-2">
                <button type="submit" class="bg-fes-orange text-white font-semibold px-8 py-2.5 rounded-lg hover:bg-orange-600 transition">Save Changes</button>
                <a href="{{ route('admin.news-posts.index') }}" class="text-sm text-gray-500 hover:text-gray-700">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
