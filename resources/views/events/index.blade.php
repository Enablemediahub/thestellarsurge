@extends('layouts.events')

@section('events-content')
    @php
        $eventsHost = request()->getHost();
        $isPathPortal = str_starts_with(request()->getRequestUri(), '/thestellarsurge/public');
        $mainSiteUrl = $eventsHost === 'events.thestellarsurge.com'
            ? 'https://thestellarsurge.com/'
            : ($isPathPortal ? route('home.path') : route('home'));
        $eventShowRoute = $eventsHost === 'events.thestellarsurge.com' ? 'events.show' : ($isPathPortal ? 'events.show.path' : 'events.show.local');
        $eventCheckoutRoute = $eventsHost === 'events.thestellarsurge.com' ? 'events.checkout' : ($isPathPortal ? 'events.checkout.path' : 'events.checkout.local');
    @endphp
    <section class="bg-[#e27f7f] py-16 text-ivory md:py-20">
        <div class="section-shell">
            <p class="text-sm uppercase tracking-[0.35em] text-white/80">Stellar Surge Events</p>
            <h1 class="mt-5 max-w-3xl text-5xl leading-none md:text-7xl">Experiences that move people.</h1>
            <p class="mt-6 max-w-xl text-lg text-white/85">Discover the next room, story, and moment being created by Stellar Surge.</p>
        </div>
    </section>

    @if ($featuredEvents->isNotEmpty())
        <section data-featured-slider class="featured-program-layer" aria-label="Featured programs">
            <div class="featured-program-modal">
                <button type="button" data-featured-close class="featured-program-close" aria-label="Close featured programs">&times;</button>
                <div class="featured-program-slides">
                    @foreach ($featuredEvents as $index => $featured)
                        @php($featuredImage = $featured->bannerImageUrl() ?? 'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?auto=format&fit=crop&w=1600&q=80')
                        <article data-featured-slide class="featured-program-slide {{ $index === 0 ? 'is-active' : '' }}">
                            <div class="featured-program-image">
                                <img src="{{ $featuredImage }}" alt="{{ $featured->title }} flyer">
                            </div>
                            <div class="featured-program-copy">
                                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-[#e27f7f]">Featured program {{ $index + 1 }} of {{ $featuredEvents->count() }}</p>
                                <h2 class="mt-4 text-4xl text-plum md:text-5xl">{{ $featured->title }}</h2>
                                <p class="mt-4 text-charcoal/75">{{ $featured->summary }}</p>
                                <div class="mt-6 space-y-2 text-sm text-charcoal/75">
                                    <p><strong>Date:</strong> {{ $featured->start_at->format('d M Y, h:i A') }}</p>
                                    <p><strong>Location:</strong> {{ $featured->location }}</p>
                                </div>
                                <div class="mt-8 flex flex-wrap gap-3">
                                    <a href="{{ route($eventCheckoutRoute, ['slug' => $featured->slug]) }}" class="rounded-full bg-[#e27f7f] px-5 py-3 text-sm font-semibold text-white transition hover:bg-plum">Get tickets</a>
                                    <a href="{{ route($eventShowRoute, ['slug' => $featured->slug]) }}" class="rounded-full border border-[#e27f7f] px-5 py-3 text-sm font-semibold text-[#e27f7f] transition hover:bg-[#e27f7f] hover:text-white">View program</a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
                @if ($featuredEvents->count() > 1)
                    <div class="featured-program-controls">
                        <button type="button" data-featured-prev aria-label="Previous featured program">&#8592;</button>
                        <div class="flex gap-2">
                            @foreach ($featuredEvents as $index => $featured)
                                <button type="button" data-featured-dot="{{ $index }}" aria-label="Show featured program {{ $index + 1 }}" class="{{ $index === 0 ? 'is-active' : '' }}"></button>
                            @endforeach
                        </div>
                        <button type="button" data-featured-next aria-label="Next featured program">&#8594;</button>
                    </div>
                @endif
            </div>
        </section>
    @endif

    <div id="programs" class="section-shell py-16">
        <div class="mb-10 flex items-end justify-between gap-4">
            <div>
                <p class="text-sm uppercase tracking-[0.3em] text-plum/70">Stellar Surge</p>
                <h1 class="mt-4 text-5xl text-plum md:text-6xl">Events</h1>
            </div>
            <a href="{{ $mainSiteUrl }}" class="text-sm font-semibold uppercase tracking-[0.2em] text-plum">Back home</a>
        </div>

        <p class="mb-10 max-w-2xl text-lg text-charcoal/80">Curated experiences for creators, communities and growth-minded people.</p>

        <div class="grid gap-6 md:grid-cols-3">
            @if ($regularEvents->isNotEmpty())
                @foreach ($regularEvents as $event)
                <article class="overflow-hidden rounded-[2rem] border border-[#eadfcf] bg-white shadow-brand">
                    <div class="h-52 overflow-hidden bg-[#eadfcf]">
                        <img src="{{ $event->bannerImageUrl() ?: 'https://images.unsplash.com/photo-1511578314322-379afb476865?auto=format&fit=crop&w=1200&q=80' }}" alt="{{ $event->title }} flyer" class="h-full w-full object-cover" />
                    </div>
                    <div class="p-6">
                        <div class="mb-4 inline-flex rounded-full bg-gold/15 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-plum">{{ $event->start_at->format('M d') }}</div>
                        @if ($event->featured)
                            <div class="mb-4 ml-2 inline-flex rounded-full bg-[#e27f7f]/15 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-[#d36d6d]">Featured</div>
                        @endif
                        <h2 class="text-2xl text-plum">{{ $event->title }}</h2>
                        <p class="mt-3 text-sm text-charcoal/75">{{ $event->summary }}</p>
                        <div class="mt-5 space-y-2 text-sm text-charcoal/80">
                            <p><strong>Date:</strong> {{ $event->start_at->format('d M Y, h:i A') }}</p>
                            <p><strong>Location:</strong> {{ $event->location }}</p>
                            <p><strong>Price:</strong> {{ number_format($event->price) }} {{ $event->currency }}</p>
                        </div>
                        <div class="mt-6 flex items-center justify-between gap-4">
                            <a href="{{ route($eventShowRoute, ['slug' => $event->slug]) }}" class="inline-flex rounded-full bg-plum px-5 py-2.5 text-sm font-semibold text-ivory transition hover:bg-charcoal">View details</a>
                            <a href="{{ route($eventCheckoutRoute, ['slug' => $event->slug]) }}" class="text-sm font-semibold text-gold">Get ticket</a>
                        </div>
                    </div>
                </article>
                @endforeach
            @else
                <div class="rounded-[2rem] border border-dashed border-plum/20 bg-[#f8f0e7] p-8 text-charcoal/70 md:col-span-3">
                    No programs are published yet. Please check back soon.
                </div>
            @endif
        </div>
    </div>
@endsection
