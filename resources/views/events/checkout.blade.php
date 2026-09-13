@extends('layouts.events')

@section('events-content')
    <div class="section-shell py-16">
        <a href="{{ request()->getHost() === 'events.thestellarsurge.com' ? route('events.show', ['slug' => $event->slug]) : route('events.show.local', ['slug' => $event->slug]) }}" class="inline-flex items-center gap-2 text-sm font-semibold uppercase tracking-[0.2em] text-plum">← Back to event</a>

        <div class="mt-8 grid gap-8 md:grid-cols-[1.1fr_0.9fr]">
            <div class="rounded-[2rem] border border-[#eadfcf] bg-white p-8 shadow-brand">
                <p class="text-sm uppercase tracking-[0.28em] text-plum/70">Checkout</p>
                <h1 class="mt-4 text-4xl text-plum">{{ $event->title }}</h1>
                <p class="mt-3 text-charcoal/75">{{ $event->summary }}</p>

                <form method="POST" action="{{ request()->getHost() === 'events.thestellarsurge.com' ? route('events.purchase', ['slug' => $event->slug]) : route('events.purchase.local', ['slug' => $event->slug]) }}" class="mt-8 space-y-5">
                    @csrf

                    <div>
                        <label for="name" class="mb-2 block text-sm font-medium text-plum">Full name</label>
                        <input id="name" name="name" type="text" required class="w-full rounded-2xl border border-[#dccbb1] bg-[#fffaf4] px-4 py-3 outline-none ring-0 transition focus:border-plum" placeholder="Your full name" />
                    </div>

                    <div>
                        <label for="quantity" class="mb-2 block text-sm font-medium text-plum">Number of tickets</label>
                        <input id="quantity" name="quantity" type="number" min="1" max="10" value="1" required class="w-full rounded-2xl border border-[#dccbb1] bg-[#fffaf4] px-4 py-3 outline-none transition focus:border-plum" />
                        <p class="mt-2 text-xs text-charcoal/60">You can purchase up to 10 tickets in one order.</p>
                    </div>

                    <div>
                        <label for="email" class="mb-2 block text-sm font-medium text-plum">Email</label>
                        <input id="email" name="email" type="email" required class="w-full rounded-2xl border border-[#dccbb1] bg-[#fffaf4] px-4 py-3 outline-none ring-0 transition focus:border-plum" placeholder="you@example.com" />
                    </div>

                    <div>
                        <label for="phone" class="mb-2 block text-sm font-medium text-plum">Phone number</label>
                        <input id="phone" name="phone" type="tel" class="w-full rounded-2xl border border-[#dccbb1] bg-[#fffaf4] px-4 py-3 outline-none ring-0 transition focus:border-plum" placeholder="+233 24 000 0000" />
                    </div>

                    <button type="submit" class="inline-flex w-full items-center justify-center rounded-full bg-plum px-5 py-3 text-sm font-semibold text-ivory transition hover:bg-charcoal">Continue to secure payment</button>
                </form>
            </div>

            <aside class="rounded-[2rem] border border-[#eadfcf] bg-[#fdfaf5] p-8 shadow-brand">
                <p class="text-sm uppercase tracking-[0.28em] text-plum/70">Order summary</p>
                <div class="mt-6 space-y-4 text-sm text-charcoal/80">
                    <div class="flex items-center justify-between gap-4">
                        <span>Ticket</span>
                        <span>{{ $event->title }}</span>
                    </div>
                    <div class="flex items-center justify-between gap-4">
                        <span>Date</span>
                        <span>{{ $event->start_at->format('d M Y') }}</span>
                    </div>
                    <div class="flex items-center justify-between gap-4">
                        <span>Location</span>
                        <span>{{ $event->location }}</span>
                    </div>
                    <div class="flex items-center justify-between gap-4 border-t border-plum/10 pt-4 text-base font-semibold text-plum">
                        <span>Total</span>
                        <span>{{ number_format($event->price) }} {{ $event->currency }}</span>
                    </div>
                </div>
            </aside>
        </div>
    </div>
@endsection
