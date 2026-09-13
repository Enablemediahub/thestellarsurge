@extends('layouts.app')

@section('content')
    <div class="section-shell py-16">
        <div class="mb-10 flex items-end justify-between gap-4">
            <div>
                <p class="text-sm uppercase tracking-[0.3em] text-plum/70">Stellar Surge</p>
                <h1 class="mt-4 text-5xl text-plum md:text-6xl">Events</h1>
            </div>
            <a href="/" class="text-sm font-semibold uppercase tracking-[0.2em] text-plum">Back home</a>
        </div>

        <p class="mb-10 max-w-2xl text-lg text-charcoal/80">Curated experiences for creators, communities and growth-minded people.</p>

        <div class="grid gap-6 md:grid-cols-3">
            @forelse ($events as $event)
                <article class="overflow-hidden rounded-[2rem] border border-[#eadfcf] bg-white shadow-brand">
                    <div class="h-52 bg-cover bg-center" style="background-image: url('{{ $event->banner_image ?? 'https://images.unsplash.com/photo-1511578314322-379afb476865?auto=format&fit=crop&w=1200&q=80' }}');"></div>
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
                            <a href="{{ route('events.show.local', ['slug' => $event->slug]) }}" class="inline-flex rounded-full bg-plum px-5 py-2.5 text-sm font-semibold text-ivory transition hover:bg-charcoal">View details</a>
                            <a href="{{ route('events.checkout.local', ['slug' => $event->slug]) }}" class="text-sm font-semibold text-gold">Get ticket</a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="rounded-[2rem] border border-dashed border-plum/20 bg-[#f8f0e7] p-8 text-charcoal/70 md:col-span-3">
                    No events are published yet. Please check back soon.
                </div>
            @endforelse
        </div>
    </div>
@endsection
