@extends('layouts.app')

@section('content')
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
            <div class="mt-8 flex flex-wrap justify-center gap-4">
                <a href="{{ route('events.index.local') }}" class="inline-flex rounded-full bg-plum px-5 py-3 text-sm font-semibold text-ivory transition hover:bg-charcoal">View all events</a>
                <a href="/" class="inline-flex rounded-full border border-plum px-5 py-3 text-sm font-semibold text-plum transition hover:bg-plum hover:text-ivory">Back home</a>
            </div>
        </div>
    </div>
@endsection
