@extends('layouts.events')

@section('events-content')
    <div class="section-shell py-12 md:py-16">
        <p class="text-sm uppercase tracking-[0.3em] text-plum/70">Events gallery</p>
        <h1 class="mt-3 text-5xl text-plum">Moments from our programs</h1>
        @forelse ($events as $event)
            <section class="mt-12">
                <div class="flex items-end justify-between gap-4">
                    <div><p class="text-xs uppercase tracking-[0.2em] text-plum/60">{{ $event->start_at->format('d M Y') }}</p><h2 class="mt-2 text-3xl text-plum">{{ $event->title }}</h2></div>
                    <a href="{{ request()->getHost() === 'events.thestellarsurge.com' ? route('events.gallery', $event->slug) : (str_starts_with(request()->getRequestUri(), '/thestellarsurge/public') ? route('events.gallery.path', $event->slug) : route('events.gallery.local', $event->slug)) }}" class="text-sm font-semibold text-plum">View all</a>
                </div>
                <div class="mt-5 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($event->galleryItems->take(4) as $item)
                        <a href="{{ request()->getHost() === 'events.thestellarsurge.com' ? route('events.gallery', $event->slug) : (str_starts_with(request()->getRequestUri(), '/thestellarsurge/public') ? route('events.gallery.path', $event->slug) : route('events.gallery.local', $event->slug)) }}" class="overflow-hidden rounded-2xl border border-[#eadfcf] bg-white shadow-brand"><img src="{{ $item->thumbnailUrl() }}" alt="{{ $item->caption ?: $event->title }}" class="aspect-[4/3] w-full object-cover"><p class="p-3 text-sm font-semibold text-plum">{{ $item->category }}</p></a>
                    @endforeach
                </div>
            </section>
        @empty
            <p class="mt-10 rounded-2xl border border-dashed border-plum/20 p-8 text-charcoal/70">Published event galleries will appear here.</p>
        @endforelse
    </div>
@endsection