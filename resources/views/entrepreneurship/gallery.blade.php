@extends('layouts.app')

@section('content')
    @php
        $isLocalPath = str_starts_with(request()->getRequestUri(), '/thestellarsurge/public');
        $publicBaseUrl = request()->getSchemeAndHttpHost() . '/thestellarsurge/public';
        $isLocalHost = in_array(request()->getHost(), ['localhost', '127.0.0.1']);
        $planningUrl = $isLocalPath ? $publicBaseUrl . '/event_planning' : route('event_planning.index.local');
        $mainSiteUrl = $isLocalPath || $isLocalHost ? $publicBaseUrl : 'https://thestellarsurge.com/';
    @endphp
    <div class="min-h-screen bg-ivory" style="--portal-color: {{ $siteSettings->events_color ?: '#e27f7f' }};">
        <nav class="text-white" style="background-color: var(--portal-color);">
            <div class="section-shell flex items-center justify-between py-4">
                <a href="{{ $planningUrl }}" class="flex items-center gap-3"><img src="{{ asset('logos/Main logo.png') }}" alt="Stellar Surge" class="h-10 w-auto brightness-0 invert"><span class="hidden border-l border-white/30 pl-3 text-xs font-semibold uppercase tracking-[0.2em] sm:inline">Event Planning</span></a>
                <div class="flex items-center gap-3">
                    <a href="{{ $planningUrl }}#book" class="rounded-full border border-white/70 px-4 py-2 text-xs font-semibold uppercase tracking-[0.12em] transition hover:bg-white hover:text-plum">Book us</a>
                    <a href="{{ $mainSiteUrl }}" class="rounded-full bg-white px-4 py-2 text-xs font-semibold uppercase tracking-[0.12em] text-plum transition hover:bg-plum hover:text-white">Main site</a>
                </div>
            </div>
        </nav>
        <main class="section-shell py-14 md:py-20">
            <p class="text-sm uppercase tracking-[0.3em] text-plum/70">Our portfolio</p>
            <h1 class="mt-4 text-5xl text-plum md:text-7xl">Programs we have brought to life.</h1>
            <p class="mt-5 max-w-2xl text-lg text-charcoal/75">Explore moments from Stellar Surge programs and the experiences we have created for our communities.</p>
            @forelse ($events as $event)
                <section class="mt-14">
                    <p class="text-xs uppercase tracking-[0.2em] text-plum/60">{{ $event->start_at?->format('d M Y') }}</p>
                    <h2 class="mt-2 text-3xl text-plum">{{ $event->title }}</h2>
                    <div class="mt-6 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                        @foreach ($event->galleryItems as $item)
                            <figure class="overflow-hidden rounded-2xl border border-[#eadfcf] bg-white shadow-brand">
                                @if ($item->thumbnailUrl())<img src="{{ $item->thumbnailUrl() }}" alt="{{ $item->caption ?: $event->title }}" class="aspect-[4/3] w-full object-cover">@endif
                                <figcaption class="p-4 text-sm text-plum">{{ $item->caption ?: $item->category }}</figcaption>
                            </figure>
                        @endforeach
                    </div>
                </section>
            @empty
                <p class="mt-12 rounded-2xl border border-dashed border-plum/20 p-8 text-charcoal/70">Published portfolio images will appear here.</p>
            @endforelse
        </main>
    </div>
@endsection