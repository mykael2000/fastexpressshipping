@extends('layouts.public')
@section('title', 'News — Fast Express Shipping')

@section('content')
<section class="bg-fes-navy text-white py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl font-bold mb-3">News &amp; Updates</h1>
        <p class="text-gray-300 text-lg">Company news, service announcements, and industry insights.</p>
    </div>
</section>

<section class="py-14 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($posts->isEmpty())
            <div class="text-center py-20 text-gray-400">
                <svg class="w-16 h-16 mx-auto mb-4 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                </svg>
                <p class="text-lg font-medium">No posts yet. Check back soon!</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($posts as $post)
                <article class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition flex flex-col">
                    <div class="h-3 bg-fes-navy"></div>
                    <div class="p-6 flex flex-col flex-1">
                        <div class="flex items-center gap-2 text-xs text-gray-400 mb-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            {{ $post->published_at ? $post->published_at->format('M j, Y') : 'Draft' }}
                        </div>
                        <h2 class="font-bold text-fes-navy text-lg mb-3 leading-snug">
                            <a href="{{ route('news.show', $post->slug) }}" class="hover:text-fes-orange transition">{{ $post->title }}</a>
                        </h2>
                        @if($post->excerpt)
                            <p class="text-gray-500 text-sm leading-relaxed flex-1">{{ Str::limit($post->excerpt, 160) }}</p>
                        @endif
                        <div class="mt-5 pt-4 border-t border-gray-100">
                            <a href="{{ route('news.show', $post->slug) }}" class="text-fes-orange text-sm font-semibold hover:underline flex items-center gap-1">
                                Read More
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>

            @if($posts->hasPages())
                <div class="mt-10">
                    {{ $posts->links() }}
                </div>
            @endif
        @endif
    </div>
</section>
@endsection
