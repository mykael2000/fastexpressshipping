@extends('layouts.public')
@section('title', $post->title . ' — Fast Express Shipping')

@section('content')
<section class="bg-fes-navy text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('news.index') }}" class="inline-flex items-center gap-1 text-gray-300 hover:text-white text-sm mb-4 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back to News
        </a>
        <h1 class="text-3xl font-bold leading-snug max-w-3xl">{{ $post->title }}</h1>
        @if($post->published_at)
            <p class="text-gray-400 text-sm mt-3">Published {{ $post->published_at->format('F j, Y') }}</p>
        @endif
    </div>
</section>

<section class="py-14 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            {{-- Article Body --}}
            <article class="lg:col-span-2 prose prose-slate max-w-none">
                {!! $post->body !!}
            </article>

            {{-- Sidebar --}}
            <aside class="space-y-6">
                <div class="bg-gray-50 rounded-xl p-6 border border-gray-100">
                    <h3 class="font-bold text-fes-navy mb-4 text-sm uppercase tracking-wide">Recent Posts</h3>
                    @if($recent->isEmpty())
                        <p class="text-gray-400 text-sm">No other posts yet.</p>
                    @else
                        <ul class="space-y-4">
                            @foreach($recent as $r)
                            <li class="border-b border-gray-200 pb-4 last:border-0 last:pb-0">
                                <a href="{{ route('news.show', $r->slug) }}" class="font-medium text-fes-navy hover:text-fes-orange text-sm transition leading-snug">{{ $r->title }}</a>
                                @if($r->published_at)
                                    <p class="text-gray-400 text-xs mt-1">{{ $r->published_at->format('M j, Y') }}</p>
                                @endif
                            </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div class="bg-fes-navy rounded-xl p-6 text-white text-center">
                    <h3 class="font-bold mb-2">Ready to Ship?</h3>
                    <p class="text-gray-300 text-sm mb-4">Create an account and submit your first shipment request today.</p>
                    <a href="{{ route('register') }}" class="inline-block bg-fes-orange text-white font-semibold px-5 py-2.5 rounded-lg hover:bg-orange-600 transition text-sm">Get Started</a>
                </div>
            </aside>
        </div>
    </div>
</section>
@endsection
