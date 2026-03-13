@extends('layouts.admin')
@section('title', 'News Posts')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-fes-navy">News Posts</h1>
    <a href="{{ route('admin.news-posts.create') }}" class="bg-fes-orange text-white text-sm font-semibold px-5 py-2.5 rounded-lg hover:bg-orange-600 transition inline-flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Create Post
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    @if($posts->isEmpty())
        <div class="py-16 text-center text-gray-400 text-sm">No posts yet. Create your first one!</div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wide">
                    <tr>
                        <th class="px-5 py-3 text-left">Title</th>
                        <th class="px-5 py-3 text-left">Published</th>
                        <th class="px-5 py-3 text-left">Status</th>
                        <th class="px-5 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($posts as $post)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-5 py-4">
                            <p class="font-medium text-gray-800">{{ $post->title }}</p>
                            <p class="text-xs text-gray-400 font-mono">{{ $post->slug }}</p>
                        </td>
                        <td class="px-5 py-4 text-gray-500">{{ $post->published_at ? $post->published_at->format('M j, Y') : '—' }}</td>
                        <td class="px-5 py-4">
                            @if($post->is_published)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">Published</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-500">Draft</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 flex items-center gap-3">
                            <a href="{{ route('admin.news-posts.edit', $post) }}" class="text-fes-orange hover:underline font-medium text-xs">Edit</a>
                            <form method="POST" action="{{ route('admin.news-posts.destroy', $post) }}" onsubmit="return confirm('Delete this post?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-600 font-medium text-xs">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($posts->hasPages())
            <div class="px-5 py-4 border-t border-gray-100">{{ $posts->links() }}</div>
        @endif
    @endif
</div>
@endsection
