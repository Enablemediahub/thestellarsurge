@extends('layouts.app')

@section('content')
    @php
    $siteSettings = \App\Models\SiteSetting::current();
        $isLocalHost = request()->getHost() === 'localhost';
        $publicBaseUrl = request()->getSchemeAndHttpHost() . '/thestellarsurge/public';
        $mainSiteUrl = $isLocalHost
            ? $publicBaseUrl
            : (request()->getHost() === 'events.thestellarsurge.com'
            ? 'https://thestellarsurge.com/'
            : (str_starts_with(request()->getRequestUri(), '/thestellarsurge/public') ? $publicBaseUrl : route('home')));
        $eventsHome = $isLocalHost
            ? $publicBaseUrl . '/events'
            : (request()->getHost() === 'events.thestellarsurge.com'
            ? route('events.index')
            : (str_starts_with(request()->getRequestUri(), '/thestellarsurge/public') ? $publicBaseUrl . '/events' : route('events.index.local')));
    @endphp
    <div class="events-portal min-h-screen bg-[#f7f2e9]" style="--portal-color: {{ $siteSettings->events_color ?: '#e27f7f' }};">
        <nav class="border-b border-white/20 bg-[#e27f7f] text-ivory">
            <div class="section-shell relative z-30 flex items-center justify-between gap-6 py-4">
                <a href="{{ $eventsHome }}" class="flex items-center gap-3">
                    <img src="{{ asset('logos/Main logo.png') }}" alt="Stellar Surge" class="h-10 w-auto brightness-0 invert" />
                    <span class="hidden border-l border-white/20 pl-3 text-xs font-semibold uppercase tracking-[0.24em] text-gold sm:inline">Events</span>
                </a>
                <div class="hidden items-center gap-4 text-xs font-semibold uppercase tracking-[0.16em] sm:flex">
                    <a href="{{ $eventsHome }}" class="text-ivory/75 transition hover:text-gold">Programs</a>
                    <a href="{{ $eventsHome }}/gallery" class="text-ivory/75 transition hover:text-gold">Gallery</a>
                    <a href="{{ $eventsHome }}#about" class="text-ivory/75 transition hover:text-gold">About</a>
                    <a href="{{ $eventsHome }}#contact" class="text-ivory/75 transition hover:text-gold">Contact</a>
                    <a href="{{ $mainSiteUrl }}" class="rounded-full border border-white/60 px-3 py-2 text-white transition hover:bg-white hover:text-[#e27f7f]">Main site</a>
                </div>
                <button type="button" data-mobile-drawer-open="events-mobile-nav" class="flex items-center gap-2 rounded-full border border-white/50 px-3 py-2 text-xs font-semibold uppercase tracking-[0.12em] text-white sm:hidden">Menu <span aria-hidden="true">☰</span></button>
                <aside id="events-mobile-nav" data-mobile-drawer hidden class="mobile-nav-drawer sm:hidden" aria-label="Events mobile navigation">
                    <div class="mobile-nav-drawer__panel">
                        <button type="button" data-mobile-drawer-close class="mobile-nav-drawer__close" aria-label="Close navigation">&times;</button>
                        <p class="mb-4 text-xs font-semibold uppercase tracking-[0.25em] text-gold">Events portal</p>
                        <a href="{{ $eventsHome }}" class="block rounded-xl px-3 py-3 text-white/85 hover:bg-white/10 hover:text-gold">Programs</a>
                        <a href="{{ $eventsHome }}/gallery" class="block rounded-xl px-3 py-3 text-white/85 hover:bg-white/10 hover:text-gold">Gallery</a>
                        <a href="{{ $eventsHome }}#about" class="block rounded-xl px-3 py-3 text-white/85 hover:bg-white/10 hover:text-gold">About</a>
                        <a href="{{ $eventsHome }}#contact" class="block rounded-xl px-3 py-3 text-white/85 hover:bg-white/10 hover:text-gold">Contact</a>
                        <a href="{{ $mainSiteUrl }}" class="mt-1 block rounded-xl bg-white px-3 py-3 font-semibold text-plum">Main site</a>
                    </div>
                </aside>
            </div>
        </nav>

        @yield('events-content')

        <footer id="contact" class="border-t border-plum/10 bg-[#efe3d5] py-8">
            <div class="section-shell flex flex-col justify-between gap-3 text-sm text-plum/70 md:flex-row md:items-center">
                <p>Stellar Surge Events. Create. Experience. Impact.</p>
                <div class="flex flex-col gap-2 text-right">
                    <a href="mailto:{{ $siteSettings->contact_email ?: 'hello@thestellarsurge.com' }}" class="font-semibold text-plum">{{ $siteSettings->contact_email ?: 'hello@thestellarsurge.com' }}</a>
                    <p class="text-xs uppercase tracking-[0.2em] text-plum/60">{{ $siteSettings->footer_credit ?: 'Developed and Designed by DALE QUIST [Enable Technologies]' }}</p>
                </div>
            </div>
        </footer>
    </div>
@endsection
