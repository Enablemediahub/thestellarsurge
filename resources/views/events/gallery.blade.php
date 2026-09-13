@extends('layouts.events')

@section('events-content')
    <div class="section-shell py-12 md:py-16">
        <a href="{{ request()->getHost() === 'events.thestellarsurge.com' ? route('events.show', $event->slug) : (str_starts_with(request()->getRequestUri(), '/thestellarsurge/public') ? route('events.show.path', $event->slug) : route('events.show.local', $event->slug)) }}" class="text-sm font-semibold uppercase tracking-[0.2em] text-plum">Back to event</a>
        <p class="mt-8 text-sm uppercase tracking-[0.3em] text-plum/70">Event gallery</p>
        <h1 class="mt-3 text-5xl text-plum">{{ $event->title }}</h1>
        @if (session('gallery_status'))
            <p class="mt-5 rounded-2xl bg-green-50 px-4 py-3 text-sm text-green-800">{{ session('gallery_status') }}</p>
        @endif

        @forelse ($event->galleryItems->groupBy('category') as $category => $items)
            <section class="mt-12">
                <h2 class="text-3xl text-plum">{{ $category }}</h2>
                <div class="mt-5 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($items as $item)
                        <article class="overflow-hidden rounded-2xl border border-[#eadfcf] bg-white shadow-brand">
                            <img src="{{ $item->thumbnailUrl() }}" alt="{{ $item->caption ?: $category }}" class="aspect-[4/3] w-full object-cover">
                            <div class="p-5">
                                @if ($item->caption)<p class="text-sm text-charcoal/75">{{ $item->caption }}</p>@endif
                                @if ($item->youtube_url)<a href="{{ $item->youtube_url }}" target="_blank" rel="noopener noreferrer" class="mt-3 inline-flex text-sm font-semibold text-plum underline">Watch on YouTube</a>@endif
                                <div class="mt-4 flex items-center justify-between gap-3">
                                    <form method="POST" action="{{ request()->getHost() === 'events.thestellarsurge.com' ? route('events.gallery.like', [$event->slug, $item->id]) : (str_starts_with(request()->getRequestUri(), '/thestellarsurge/public') ? route('events.gallery.like.path', [$event->slug, $item->id]) : route('events.gallery.like.local', [$event->slug, $item->id])) }}">@csrf<button class="text-sm font-semibold text-plum">♥ {{ $item->likes_count }}</button></form>
                                    <button type="button" data-share-url="{{ request()->fullUrl() }}#gallery-{{ $item->id }}" data-share-title="{{ $event->title }} gallery" class="text-sm font-semibold text-plum">Share</button>
                                </div>
                                <div class="mt-5 border-t border-plum/10 pt-4">
                                    <p class="text-xs font-semibold uppercase tracking-[0.16em] text-plum/60">Comments</p>
                                    @foreach ($item->comments as $comment)<p class="mt-2 text-sm text-charcoal/75"><strong>{{ $comment->name }}:</strong> {{ $comment->body }}</p>@endforeach
                                    <form method="POST" action="{{ request()->getHost() === 'events.thestellarsurge.com' ? route('events.gallery.comment', [$event->slug, $item->id]) : (str_starts_with(request()->getRequestUri(), '/thestellarsurge/public') ? route('events.gallery.comment.path', [$event->slug, $item->id]) : route('events.gallery.comment.local', [$event->slug, $item->id])) }}" class="mt-3 space-y-2">@csrf<input name="name" required placeholder="Your name" class="w-full rounded-xl border border-[#dccbb1] px-3 py-2 text-sm"><textarea name="body" required rows="2" placeholder="Leave a comment" class="w-full rounded-xl border border-[#dccbb1] px-3 py-2 text-sm"></textarea><button class="rounded-full bg-plum px-4 py-2 text-xs font-semibold text-ivory">Comment</button></form>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        @empty
            <p class="mt-10 rounded-2xl border border-dashed border-plum/20 p-8 text-charcoal/70">Gallery images will appear here after the event team publishes them.</p>
        @endforelse
    </div>
@endsection
