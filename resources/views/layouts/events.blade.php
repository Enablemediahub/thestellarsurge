@extends('layouts.app')

@section('content')
    @php
        $eventsHome = request()->getHost() === 'events.thestellarsurge.com'
            ? route('events.index')
            : (str_starts_with(request()->getRequestUri(), '/thestellarsurge/public') ? route('events.index.path') : route('events.index.local'));
    @endphp
    <div class="min-h-screen bg-[#f7f2e9]">
        <nav class="border-b border-plum/10 bg-plum text-ivory">
            <div class="section-shell flex items-center justify-between gap-6 py-4">
                <a href="{{ $eventsHome }}" class="flex items-center gap-3">
                    <img src="{{ asset('logos/Main logo.png') }}" alt="Stellar Surge" class="h-10 w-auto brightness-0 invert" />
                    <span class="hidden border-l border-white/20 pl-3 text-xs font-semibold uppercase tracking-[0.24em] text-gold sm:inline">Events</span>
                </a>
                <div class="flex items-center gap-4 text-xs font-semibold uppercase tracking-[0.16em]">
                    <a href="{{ $eventsHome }}" class="text-ivory/75 transition hover:text-gold">Programs</a>
                    <a href="{{ $eventsHome }}#about" class="hidden text-ivory/75 transition hover:text-gold sm:inline">About</a>
                    <a href="{{ $eventsHome }}#contact" class="hidden text-ivory/75 transition hover:text-gold sm:inline">Contact</a>
                    <a href="/" class="rounded-full border border-gold px-3 py-2 text-gold transition hover:bg-gold hover:text-plum">Main site</a>
                </div>
            </div>
        </nav>

        @yield('events-content')

        <footer id="contact" class="border-t border-plum/10 bg-[#efe3d5] py-8">
            <div class="section-shell flex flex-col justify-between gap-3 text-sm text-plum/70 md:flex-row md:items-center">
                <p>Stellar Surge Events. Create. Experience. Impact.</p>
                <a href="mailto:hello@thestellarsurge.com" class="font-semibold text-plum">hello@thestellarsurge.com</a>
            </div>
        </footer>
    </div>
@endsection
