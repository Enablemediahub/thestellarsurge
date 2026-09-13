@extends('layouts.events')

@section('events-content')
    @php
        $eventImage = $event->bannerImageUrl() ?? 'https://images.unsplash.com/photo-1511578314322-379afb476865?auto=format&fit=crop&w=1200&q=80';
    @endphp
    <div class="section-shell py-16">
        <a href="{{ request()->getHost() === 'events.thestellarsurge.com' ? route('events.index') : (str_starts_with(request()->getRequestUri(), '/thestellarsurge/public') ? route('events.index.path') : route('events.index.local')) }}" class="inline-flex items-center gap-2 text-sm font-semibold uppercase tracking-[0.2em] text-plum">← Back to events</a>

        <div class="mt-8 overflow-hidden rounded-[2rem] border border-[#eadfcf] bg-white shadow-brand">
            <div class="relative h-72 bg-cover bg-center" style="background-image: url('{{ $eventImage }}');">
                <button type="button" data-flyer-open class="absolute bottom-4 right-4 rounded-full bg-plum px-4 py-2 text-xs font-semibold uppercase tracking-[0.16em] text-ivory shadow-lg transition hover:bg-charcoal">View poster full screen</button>
            </div>
            <div class="grid gap-8 p-6 md:grid-cols-[1.5fr_0.8fr] md:p-10">
                <div>
                    <div class="mb-4 inline-flex rounded-full bg-gold/15 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-plum">{{ $event->start_at->format('d M Y') }}</div>
                    <h1 class="text-4xl text-plum md:text-6xl">{{ $event->title }}</h1>
                    <p class="mt-5 text-lg text-charcoal/80">{{ $event->summary }}</p>
                    <div class="mt-8 prose max-w-none text-charcoal/80">
                        {!! nl2br(e($event->description)) !!}
                    </div>
                    <div class="share-tools mt-8">
                        <span class="text-xs font-semibold uppercase tracking-[0.2em] text-plum/60">Share program</span>
                        <button type="button" data-share-url="{{ request()->fullUrl() }}" data-share-title="{{ $event->title }}" class="rounded-full border border-[#e27f7f] px-4 py-2 text-xs font-semibold text-[#e27f7f] transition hover:bg-[#e27f7f] hover:text-white">Share / copy link</button>
                    </div>
                </div>

                <aside class="rounded-[1.5rem] border border-[#f0e3d0] bg-[#fdfaf5] p-6">
                    <p class="text-sm uppercase tracking-[0.25em] text-plum/70">Ticket</p>
                    <div class="mt-4 flex items-baseline gap-3">
                        <span class="text-sm uppercase tracking-[0.2em] text-charcoal/60">Ticket categories</span>
                    </div>

                    <div class="mt-4 space-y-3">
                        @foreach ($event->ticketOptions() as $ticketOption)
                            <div class="flex items-center justify-between gap-4 rounded-xl border border-[#eadfcf] bg-white px-4 py-3">
                                <span class="font-semibold text-plum">{{ $ticketOption['name'] }}</span>
                                <span class="text-sm font-semibold text-charcoal">{{ number_format($ticketOption['price']) }} {{ $event->currency }}</span>
                            </div>
                        @endforeach
                    </div>

                    <ul class="mt-6 space-y-3 text-sm text-charcoal/80">
                        <li><strong>Date:</strong> {{ $event->start_at->format('d M Y, h:i A') }}</li>
                        <li><strong>End:</strong> {{ $event->end_at ? $event->end_at->format('d M Y, h:i A') : 'TBA' }}</li>
                        <li><strong>Location:</strong> {{ $event->location }}</li>
                        <li><strong>Venue:</strong> {{ $event->venue ?? 'To be announced' }}</li>
                        @if ($event->location_url)
                            <li><a href="{{ $event->location_url }}" target="_blank" rel="noopener noreferrer" class="font-semibold text-[#e27f7f] underline">Open location in Google Maps</a></li>
                        @endif
                    </ul>

                    <a href="{{ request()->getHost() === 'events.thestellarsurge.com' ? route('events.checkout', ['slug' => $event->slug]) : (str_starts_with(request()->getRequestUri(), '/thestellarsurge/public') ? route('events.checkout.path', ['slug' => $event->slug]) : route('events.checkout.local', ['slug' => $event->slug])) }}" class="mt-8 inline-flex w-full items-center justify-center rounded-full bg-plum px-5 py-3 text-sm font-semibold text-ivory transition hover:bg-charcoal">Reserve ticket</a>
                </aside>
            </div>
        </div>
    </div>

    <dialog data-flyer-dialog class="m-auto max-h-[92vh] max-w-[96vw] rounded-2xl bg-[#1f1b1f] p-3 shadow-2xl backdrop:bg-charcoal/80">
        <div class="relative flex max-h-[88vh] items-center justify-center">
            <img src="{{ $eventImage }}" alt="{{ $event->title }} flyer full screen" class="max-h-[85vh] max-w-[92vw] object-contain" />
            <button type="button" data-flyer-close class="absolute right-2 top-2 h-10 w-10 rounded-full bg-white/90 text-xl text-charcoal" aria-label="Close full-screen poster">&times;</button>
        </div>
    </dialog>

    @push('scripts')
        <script>
            const flyerDialog = document.querySelector('[data-flyer-dialog]');
            document.querySelector('[data-flyer-open]')?.addEventListener('click', () => flyerDialog?.showModal());
            document.querySelector('[data-flyer-close]')?.addEventListener('click', () => flyerDialog?.close());
            flyerDialog?.addEventListener('click', (event) => {
                if (event.target === flyerDialog) flyerDialog.close();
            });
        </script>
    @endpush
@endsection
