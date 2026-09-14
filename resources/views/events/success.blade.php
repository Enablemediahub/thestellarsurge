@extends('layouts.events')

@section('events-content')
    <div class="section-shell flex min-h-[60vh] items-center justify-center py-16">
        <div class="max-w-xl rounded-[2rem] border border-[#eadfcf] bg-white p-10 text-center shadow-brand">
            <div class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-full bg-green-100 text-3xl text-green-700">✓</div>
            <p class="text-sm uppercase tracking-[0.28em] text-plum/70">Payment status</p>
            <h1 class="mt-4 text-4xl text-plum">Your ticket is confirmed.</h1>
            <p class="mt-4 text-charcoal/80">
                Thanks for securing your spot at {{ $event->title }}.
                @if ($payment)
                    Reference: {{ $payment->reference }}
                @endif
            </p>
            @if ($tickets->isNotEmpty())
                <div class="mt-6 rounded-2xl bg-[#fdfaf5] p-4 text-left text-sm text-charcoal/80">
                    <p class="font-semibold text-plum">{{ $tickets->count() }} ticket(s) issued</p>
                    <p class="mt-2">Your PDF ticket has been sent to {{ $tickets->first()->email }}.</p>
                    <div class="mt-3 space-y-1 text-xs">
                        @foreach ($tickets as $ticket)
                            <p class="flex items-center justify-between gap-3"><span>{{ $ticket->reference }}</span><a href="{{ request()->getHost() === 'events.thestellarsurge.com' ? route('events.ticket.pdf', ['slug' => $event->slug, 'reference' => $ticket->reference]) : (str_starts_with(request()->getRequestUri(), '/thestellarsurge/public') ? route('events.ticket.pdf.path', ['slug' => $event->slug, 'reference' => $ticket->reference]) : route('events.ticket.pdf.local', ['slug' => $event->slug, 'reference' => $ticket->reference])) }}" class="font-semibold text-plum underline">Download PDF</a></p>
                        @endforeach
                    </div>
                </div>
            @endif
            <div class="mt-8 flex flex-wrap justify-center gap-4">
                <a href="{{ request()->getHost() === 'events.thestellarsurge.com' ? route('events.index') : (str_starts_with(request()->getRequestUri(), '/thestellarsurge/public') ? route('events.index.path') : route('events.index.local')) }}" class="inline-flex rounded-full bg-plum px-5 py-3 text-sm font-semibold text-ivory transition hover:bg-charcoal">View all events</a>
                <a href="{{ str_starts_with(request()->getRequestUri(), '/thestellarsurge/public') ? route('home.path') : route('home') }}" class="inline-flex rounded-full border border-plum px-5 py-3 text-sm font-semibold text-plum transition hover:bg-plum hover:text-ivory">Back home</a>
            </div>
        </div>
    </div>
@endsection
