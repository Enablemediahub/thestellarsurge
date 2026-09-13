@extends('layouts.events')

@section('events-content')
    @php($eventImage = $event->bannerImageUrl() ?? 'https://images.unsplash.com/photo-1511578314322-379afb476865?auto=format&fit=crop&w=1200&q=80')
    <div class="section-shell py-16">
        <a href="{{ request()->getHost() === 'events.thestellarsurge.com' ? route('events.show', ['slug' => $event->slug]) : (str_starts_with(request()->getRequestUri(), '/thestellarsurge/public') ? route('events.show.path', ['slug' => $event->slug]) : route('events.show.local', ['slug' => $event->slug])) }}" class="inline-flex items-center gap-2 text-sm font-semibold uppercase tracking-[0.2em] text-plum">← Back to event</a>

        <div class="mt-8 grid gap-8 md:grid-cols-[1.1fr_0.9fr]">
            <div class="rounded-[2rem] border border-[#eadfcf] bg-white p-8 shadow-brand">
                <div class="mb-8 flex min-h-[18rem] items-center justify-center overflow-hidden rounded-2xl bg-[#eadfcf] p-4 md:min-h-[28rem]">
                    <img src="{{ $eventImage }}" alt="{{ $event->title }} flyer" class="max-h-[32rem] w-full object-contain" />
                </div>
                <p class="text-sm uppercase tracking-[0.28em] text-plum/70">Checkout</p>
                <h1 class="mt-4 text-4xl text-plum">{{ $event->title }}</h1>
                <p class="mt-3 text-charcoal/75">{{ $event->summary }}</p>
                @if (config('services.paystack.mode') === 'demo')
                    <div class="mt-5 rounded-2xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-900">
                        Demo payment mode is active. No real money will be charged.
                    </div>
                @endif
                <div class="share-tools mt-5">
                    <span class="text-xs font-semibold uppercase tracking-[0.2em] text-plum/60">Share checkout</span>
                    <button type="button" data-share-url="{{ request()->fullUrl() }}" data-share-title="Buy tickets for {{ $event->title }}" class="rounded-full border border-[#e27f7f] px-4 py-2 text-xs font-semibold text-[#e27f7f] transition hover:bg-[#e27f7f] hover:text-white">Share / copy payment link</button>
                </div>

                <form method="POST" action="{{ request()->getHost() === 'events.thestellarsurge.com' ? route('events.purchase', ['slug' => $event->slug]) : (str_starts_with(request()->getRequestUri(), '/thestellarsurge/public') ? route('events.purchase.path', ['slug' => $event->slug]) : route('events.purchase.local', ['slug' => $event->slug])) }}" class="mt-8 space-y-5">
                    @csrf

                    <div>
                        <label for="name" class="mb-2 block text-sm font-medium text-plum">Full name</label>
                        <input id="name" name="name" type="text" required class="w-full rounded-2xl border border-[#dccbb1] bg-[#fffaf4] px-4 py-3 outline-none ring-0 transition focus:border-plum" placeholder="Your full name" />
                    </div>

                    <div>
                        <label for="ticket_type" class="mb-2 block text-sm font-medium text-plum">Ticket category</label>
                        <select id="ticket_type" name="ticket_type" required class="w-full rounded-2xl border border-[#dccbb1] bg-[#fffaf4] px-4 py-3 outline-none transition focus:border-plum">
                            @foreach ($event->ticketOptions() as $ticketOption)
                                <option value="{{ $ticketOption['slug'] }}" data-price="{{ $ticketOption['price'] }}">{{ $ticketOption['name'] }} — {{ number_format($ticketOption['price']) }} {{ $event->currency }}</option>
                            @endforeach
                        </select>
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
                        <input id="phone" name="phone" type="tel" required value="{{ old('phone') }}" class="w-full rounded-2xl border border-[#dccbb1] bg-[#fffaf4] px-4 py-3 outline-none ring-0 transition focus:border-plum" placeholder="+233 24 000 0000" />
                        <label class="mt-3 flex items-start gap-3 text-sm text-charcoal/75">
                            <input name="whatsapp_confirmed" type="checkbox" value="1" required class="mt-1 h-4 w-4 rounded border-[#dccbb1] text-plum focus:ring-plum" {{ old('whatsapp_confirmed') ? 'checked' : '' }} />
                            <span>I confirm this phone number is also my WhatsApp number and can receive ticket messages.</span>
                        </label>
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
                        <span data-order-total>{{ number_format($event->ticketOptions()[0]['price']) }} {{ $event->currency }}</span>
                    </div>
                </div>
            </aside>
        </div>
    </div>

    @push('scripts')
        <script>
            const ticketType = document.querySelector('#ticket_type');
            const quantity = document.querySelector('#quantity');
            const orderTotal = document.querySelector('[data-order-total]');
            const currency = '{{ $event->currency }}';
            const updateTotal = () => {
                const price = Number(ticketType?.selectedOptions[0]?.dataset.price || 0);
                const count = Number(quantity?.value || 1);
                orderTotal.textContent = `${(price * count).toLocaleString()} ${currency}`;
            };
            ticketType?.addEventListener('change', updateTotal);
            quantity?.addEventListener('input', updateTotal);
        </script>
    @endpush
@endsection
