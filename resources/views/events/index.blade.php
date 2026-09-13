@extends('layouts.events')

@section('events-content')
    @php
        $billboardImage = $featuredEvent?->bannerImageUrl() ?? 'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?auto=format&fit=crop&w=1800&q=80';
        $eventsHost = request()->getHost();
        $isPathPortal = str_starts_with(request()->getRequestUri(), '/thestellarsurge/public');
        $mainSiteUrl = $eventsHost === 'events.thestellarsurge.com'
            ? 'https://thestellarsurge.com/'
            : ($isPathPortal ? url('/thestellarsurge/public/') : url('/'));
        $eventShowRoute = $eventsHost === 'events.thestellarsurge.com' ? 'events.show' : ($isPathPortal ? 'events.show.path' : 'events.show.local');
        $eventCheckoutRoute = $eventsHost === 'events.thestellarsurge.com' ? 'events.checkout' : ($isPathPortal ? 'events.checkout.path' : 'events.checkout.local');
    @endphp
    <section class="events-billboard relative overflow-hidden bg-plum text-ivory">
        <div class="absolute inset-0 bg-cover bg-center opacity-35" style="background-image: url('{{ $billboardImage }}');"></div>
        <div class="relative section-shell py-20 md:py-28">
            <p class="text-sm uppercase tracking-[0.35em] text-gold">Stellar Surge Events</p>
            @if ($featuredEvent)
                <div class="mt-6 max-w-3xl">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-white/75">Featured program</p>
                    <h1 class="mt-3 text-5xl leading-none md:text-7xl">{{ $featuredEvent->title }}</h1>
                    <p class="mt-5 max-w-xl text-lg text-ivory/80">{{ $featuredEvent->summary ?: 'Discover the next room, story, and moment being created by Stellar Surge.' }}</p>
                    <div class="mt-6 flex flex-wrap gap-3 text-sm text-white/80">
                        <span>{{ $featuredEvent->start_at->format('d M Y, h:i A') }}</span>
                        <span class="text-white/40">|</span>
                        <span>{{ $featuredEvent->location }}</span>
                    </div>
                    <div class="mt-8 flex flex-wrap gap-3">
                        <a href="{{ route($eventCheckoutRoute, ['slug' => $featuredEvent->slug]) }}" class="inline-flex rounded-full bg-white px-6 py-3 text-sm font-semibold text-[#e27f7f] transition hover:bg-gold hover:text-plum">Get tickets</a>
                        <a href="#programs" class="inline-flex rounded-full border border-white/50 px-6 py-3 text-sm font-semibold text-white transition hover:bg-white hover:text-[#e27f7f]">View all programs</a>
                    </div>
                </div>
            @else
                <h1 class="mt-5 max-w-3xl text-5xl leading-none md:text-7xl">Experiences that move people.</h1>
                <p class="mt-6 max-w-xl text-lg text-ivory/80">Discover the next room, story, and moment being created by Stellar Surge.</p>
            @endif
        </div>
    </section>

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
            @if ($events->reject(fn ($event) => $featuredEvent && $event->is($featuredEvent))->isNotEmpty())
                @foreach ($events->reject(fn ($event) => $featuredEvent && $event->is($featuredEvent)) as $event)
                @php
                    $eventImage = $event->bannerImageUrl() ?? 'https://images.unsplash.com/photo-1511578314322-379afb476865?auto=format&fit=crop&w=1200&q=80';
                @endphp
                <article class="overflow-hidden rounded-[2rem] border border-[#eadfcf] bg-white shadow-brand">
                    <div class="h-52 bg-cover bg-center" style="background-image: url('{{ $eventImage }}');"></div>
                    <div class="p-6">
                        <div class="mb-4 inline-flex rounded-full bg-gold/15 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-plum">{{ $event->start_at->format('M d') }}</div>
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
                    No additional programs are published yet. Please check back soon.
                </div>
            @endif
        </div>
    </div>
@endsection
