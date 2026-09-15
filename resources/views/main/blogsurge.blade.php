@extends('layouts.app')

@section('content')
    @php
        $isLocalPath = str_starts_with(request()->getRequestUri(), '/thestellarsurge/public');
        $publicBaseUrl = request()->getSchemeAndHttpHost() . '/thestellarsurge/public';
        $consultationUrl = $isLocalPath ? $publicBaseUrl . '/consultation' : route('consultation');
    @endphp
    <header class="bg-plum text-ivory">
        <nav class="section-shell flex items-center justify-between py-5">
            <a href="{{ url('/') }}"><img src="{{ $siteSettings->mediaUrl($siteSettings->logo_path, asset('logos/Main logo.png')) }}" alt="{{ $siteSettings->site_name }}" class="h-12 w-auto"></a>
            <div class="flex items-center gap-5 text-sm text-ivory/80">
                <a href="{{ url('/') }}" class="hover:text-gold">Home</a>
                <a href="{{ $consultationUrl }}" class="hover:text-gold">Consultation</a>
            </div>
        </nav>
    </header>
    <main class="bg-ivory py-16 md:py-24">
        <div class="section-shell">
            <div class="max-w-3xl">
                <p class="text-sm uppercase tracking-[0.3em] text-plum/70">Ideas in motion</p>
                <h1 class="mt-5 text-5xl text-plum md:text-7xl">BlogSurge</h1>
                <p class="mt-6 text-lg leading-relaxed text-charcoal/75">Stories, insights, and practical inspiration from the world of meaningful experiences.</p>
            </div>
            <div class="mt-14 grid gap-7 md:grid-cols-2 lg:grid-cols-3">
                @forelse ($posts as $post)
                    <article class="overflow-hidden rounded-3xl border border-[#e7d9c7] bg-white shadow-brand">
                        <div class="h-56 bg-[#efe3d5]">
                            @if ($post->coverImageUrl())
                                <img src="{{ $post->coverImageUrl() }}" alt="{{ $post->title }}" class="h-full w-full object-cover">
                            @else
                                <div class="flex h-full items-end bg-plum p-6 text-gold"><span class="text-5xl">SS</span></div>
                            @endif
                        </div>
                        <div class="p-6">
                            <div class="flex items-center justify-between gap-3">
                                <p class="text-xs uppercase tracking-[0.2em] text-plum/60">{{ $post->published_at?->format('d M Y') }}</p>
                                @if ($post->is_featured)
                                    <span class="rounded-full bg-gold/20 px-2.5 py-1 text-[10px] font-semibold uppercase tracking-[0.15em] text-plum">Featured</span>
                                @endif
                            </div>
                            <h2 class="mt-3 text-2xl text-plum">{{ $post->title }}</h2>
                            <p class="mt-4 text-sm leading-relaxed text-charcoal/75">{{ $post->excerpt ?: Str::limit($post->content, 150) }}</p>
                            <div class="mt-6 flex flex-wrap items-center gap-4">
                                <a href="{{ $isLocalPath ? $publicBaseUrl . '/blogsurge/' . $post->slug : route('blogsurge.post', $post->slug) }}" class="inline-flex font-semibold text-plum">Read story <span class="ml-2" aria-hidden="true">→</span></a>
                                <button type="button" data-share-url="{{ $isLocalPath ? $publicBaseUrl . '/blogsurge/' . $post->slug : route('blogsurge.post', $post->slug) }}" data-share-title="{{ $post->title }}" class="text-sm font-semibold text-plum/70 hover:text-plum">Share</button>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="rounded-3xl border border-dashed border-plum/20 bg-white/60 p-10 text-charcoal/70 md:col-span-2 lg:col-span-3">New stories are on the way. Check back soon.</div>
                @endforelse
            </div>
            <div class="mt-10">{{ $posts->links() }}</div>
        </div>
    </main>
@endsection
