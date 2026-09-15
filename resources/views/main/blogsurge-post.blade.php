@extends('layouts.app')

@section('content')
    @php
        $isLocalPath = str_starts_with(request()->getRequestUri(), '/thestellarsurge/public');
        $publicBaseUrl = request()->getSchemeAndHttpHost() . '/thestellarsurge/public';
        $blogUrl = $isLocalPath ? $publicBaseUrl . '/blogsurge' : route('blogsurge');
    @endphp
    <header class="bg-plum text-ivory">
        <nav class="section-shell flex items-center justify-between py-5">
            <a href="{{ url('/') }}"><img src="{{ $siteSettings->mediaUrl($siteSettings->logo_path, asset('logos/Main logo.png')) }}" alt="{{ $siteSettings->site_name }}" class="h-12 w-auto"></a>
            <a href="{{ $blogUrl }}" class="text-sm text-ivory/80 hover:text-gold">All BlogSurge stories</a>
        </nav>
    </header>
    <main class="bg-ivory py-16 md:py-24">
        <article class="section-shell max-w-4xl">
            <div class="flex flex-wrap items-center gap-3 text-sm uppercase tracking-[0.3em] text-plum/70">
                <span>{{ $post->published_at?->format('d M Y') }}</span>
                @if ($post->is_featured)
                    <span class="rounded-full bg-gold/20 px-3 py-1 text-[10px] font-semibold tracking-[0.15em] text-plum">Featured</span>
                @endif
            </div>
            <h1 class="mt-5 text-5xl leading-tight text-plum md:text-7xl">{{ $post->title }}</h1>
            @if ($post->excerpt)
                <p class="mt-7 text-xl leading-relaxed text-charcoal/75">{{ $post->excerpt }}</p>
            @endif
            @if ($post->coverImageUrl())
                <img src="{{ $post->coverImageUrl() }}" alt="{{ $post->title }}" class="mt-10 max-h-[32rem] w-full rounded-3xl object-cover shadow-brand">
            @endif
            <div class="mt-8 flex flex-wrap items-center gap-4 border-y border-plum/10 py-4">
                <button type="button" data-share-url="{{ request()->fullUrl() }}" data-share-title="{{ $post->title }}" class="rounded-full bg-plum px-5 py-2.5 text-sm font-semibold text-ivory transition hover:bg-charcoal">Share this story</button>
                <span class="text-sm text-charcoal/60">Share the story with your community.</span>
            </div>
            <div class="blog-content mt-10 text-lg leading-loose text-charcoal/85">{!! $post->content !!}</div>
        </article>
    </main>
@endsection

@push('styles')
    <style>
        .blog-content h2, .blog-content h3 { margin: 2rem 0 0.75rem; color: #32152f; font-family: 'Playfair Display', serif; line-height: 1.2; }
        .blog-content h2 { font-size: 2rem; }
        .blog-content h3 { font-size: 1.5rem; }
        .blog-content p { margin: 1rem 0; }
        .blog-content ul, .blog-content ol { margin: 1rem 0; padding-left: 1.5rem; }
        .blog-content ul { list-style: disc; }
        .blog-content ol { list-style: decimal; }
        .blog-content blockquote { margin: 1.5rem 0; border-left: 3px solid #c8a46a; padding-left: 1rem; font-style: italic; }
        .blog-content a { color: #32152f; text-decoration: underline; }
        .blog-content pre { overflow-x: auto; border-radius: 0.75rem; background: #32152f; padding: 1rem; color: #f7f2e9; font-size: 0.9rem; line-height: 1.5; }
    </style>
@endpush
