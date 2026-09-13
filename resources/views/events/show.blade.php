@extends('layouts.events')

@section('events-content')
    @php
        $eventImage = $event->bannerImageUrl() ?? 'https://images.unsplash.com/photo-1511578314322-379afb476865?auto=format&fit=crop&w=1200&q=80';
    @endphp
    <div class="section-shell py-16">
        <a href="{{ request()->getHost() === 'events.thestellarsurge.com' ? route('events.index') : route('events.index.local') }}" class="inline-flex items-center gap-2 text-sm font-semibold uppercase tracking-[0.2em] text-plum">← Back to events</a>

        <div class="mt-8 overflow-hidden rounded-[2rem] border border-[#eadfcf] bg-white shadow-brand">
            <div class="h-72 bg-cover bg-center" style="background-image: url('{{ $eventImage }}');"></div>
            <div class="grid gap-8 p-6 md:grid-cols-[1.5fr_0.8fr] md:p-10">
                <div>
                    <div class="mb-4 inline-flex rounded-full bg-gold/15 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-plum">{{ $event->start_at->format('d M Y') }}</div>
                    <h1 class="text-4xl text-plum md:text-6xl">{{ $event->title }}</h1>
                    <p class="mt-5 text-lg text-charcoal/80">{{ $event->summary }}</p>
                    <div class="mt-8 prose max-w-none text-charcoal/80">
                        {!! nl2br(e($event->description)) !!}
                    </div>
                </div>

                <aside class="rounded-[1.5rem] border border-[#f0e3d0] bg-[#fdfaf5] p-6">
                    <p class="text-sm uppercase tracking-[0.25em] text-plum/70">Ticket</p>
                    <div class="mt-4 flex items-baseline gap-3">
                        <span class="text-4xl font-bold text-plum">{{ number_format($event->price) }}</span>
                        <span class="text-sm uppercase tracking-[0.2em] text-charcoal/60">{{ $event->currency }}</span>
                    </div>

                    <ul class="mt-6 space-y-3 text-sm text-charcoal/80">
                        <li><strong>Date:</strong> {{ $event->start_at->format('d M Y, h:i A') }}</li>
                        <li><strong>End:</strong> {{ $event->end_at ? $event->end_at->format('d M Y, h:i A') : 'TBA' }}</li>
                        <li><strong>Location:</strong> {{ $event->location }}</li>
                        <li><strong>Venue:</strong> {{ $event->venue ?? 'To be announced' }}</li>
                    </ul>

                    <a href="{{ request()->getHost() === 'events.thestellarsurge.com' ? route('events.checkout', ['slug' => $event->slug]) : route('events.checkout.local', ['slug' => $event->slug]) }}" class="mt-8 inline-flex w-full items-center justify-center rounded-full bg-plum px-5 py-3 text-sm font-semibold text-ivory transition hover:bg-charcoal">Reserve ticket</a>
                </aside>
            </div>
        </div>
    </div>
@endsection
