@extends('layouts.public')
@section('title', $page->title . ' — Fast Express Shipping')

@section('content')
<section class="bg-fes-navy text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold">{{ $page->title }}</h1>
    </div>
</section>

<section class="py-14 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <article class="prose prose-slate max-w-none">
            {!! $page->content !!}
        </article>
    </div>
</section>
@endsection
