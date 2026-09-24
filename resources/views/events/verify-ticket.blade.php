@extends('layouts.events')

@section('events-content')
    <div class="section-shell flex min-h-[65vh] items-center justify-center py-16">
        <div class="w-full max-w-xl rounded-[2rem] border border-[#eadfcf] bg-white p-8 text-center shadow-brand md:p-10">
            @if (session('verification_error'))
                <div class="rounded-2xl bg-red-50 px-4 py-3 text-sm text-red-800">{{ session('verification_error') }}</div>
            @endif

            @if ($scannerRequired ?? false)
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-amber-100 text-3xl text-amber-700">!</div>
                <p class="mt-5 text-sm uppercase tracking-[0.28em] text-amber-700">Scanner portal required</p>
                <h1 class="mt-3 text-4xl text-plum">Open the ticket scanner first.</h1>
                <p class="mt-4 text-charcoal/75">Ticket verification is only available through the official Stellar Surge ticket scanner portal.</p>
                <a href="{{ $scannerUrl }}" class="mt-6 inline-flex w-full items-center justify-center rounded-full bg-plum px-5 py-3 text-sm font-semibold text-ivory transition hover:bg-charcoal">Open ticket scanner</a>
            @elseif (! $ticket)
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-red-100 text-3xl text-red-700">!</div>
                <p class="mt-5 text-sm uppercase tracking-[0.28em] text-red-700">Invalid ticket</p>
                <h1 class="mt-3 text-4xl text-plum">This QR code is not authentic.</h1>
                <p class="mt-4 text-charcoal/75">The code may be damaged, edited, or not issued by Stellar Surge.</p>
            @elseif ($ticket->status !== 'paid')
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-amber-100 text-3xl text-amber-700">!</div>
                <p class="mt-5 text-sm uppercase tracking-[0.28em] text-amber-700">Payment incomplete</p>
                <h1 class="mt-3 text-4xl text-plum">This ticket is not valid for entry.</h1>
                <p class="mt-4 text-charcoal/75">Ticket {{ $ticket->reference }} has not been marked as paid.</p>
            @else
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full {{ $ticket->verified ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700' }} text-3xl">✓</div>
                <p class="mt-5 text-sm uppercase tracking-[0.28em] {{ ($autoVerified ?? false) ? 'text-green-700' : ($ticket->verified ? 'text-blue-700' : 'text-green-700') }}">{{ ($autoVerified ?? false) ? 'Ticket verified successfully' : ($ticket->verified ? 'Already verified' : 'Authentic paid ticket') }}</p>
                <h1 class="mt-3 text-4xl text-plum">{{ $ticket->event->title }}</h1>
                <div class="mt-6 rounded-2xl bg-[#fdfaf5] p-5 text-left text-sm text-charcoal/80">
                    <p><strong>Guest:</strong> {{ $ticket->name }}</p>
                    <p class="mt-2"><strong>Ticket:</strong> {{ $ticket->reference }}</p>
                    <p class="mt-2"><strong>Type:</strong> {{ str($ticket->ticket_type)->replace('-', ' ')->title() }}</p>
                    @if ($ticket->verified_at)
                        <p class="mt-2"><strong>Verified at:</strong> {{ $ticket->verified_at->format('d M Y, h:i A') }}</p>
                    @endif
                </div>
                @if (! $ticket->verified || ($autoVerified ?? false))
                    @if (! ($autoVerified ?? false))
                    <form method="POST" action="{{ request()->getHost() === 'events.thestellarsurge.com' ? route('events.ticket.verify.confirm') : (str_starts_with(request()->getRequestUri(), '/thestellarsurge/public') ? route('events.ticket.verify.confirm.path') : route('events.ticket.verify.confirm.local')) }}" class="mt-6">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <button type="submit" class="inline-flex w-full items-center justify-center rounded-full bg-plum px-5 py-3 text-sm font-semibold text-ivory transition hover:bg-charcoal">Verify ticket for entry</button>
                    </form>
                    @endif
                @else
                    <p class="mt-6 rounded-full bg-blue-50 px-4 py-3 text-sm font-semibold text-blue-800">Entry already verified. Do not admit a second use.</p>
                @endif
            @endif

            @if (! ($scannerRequired ?? false))
                <a href="{{ $scannerUrl }}" class="mt-6 inline-flex w-full items-center justify-center rounded-full border border-plum px-5 py-3 text-sm font-semibold text-plum transition hover:bg-plum hover:text-ivory">Scan next ticket</a>
            @endif
        </div>
    </div>
@endsection
