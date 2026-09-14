@extends('layouts.app')

@section('content')
    @php($siteSettings = \App\Models\SiteSetting::current())
    @php($heroImage = $siteSettings->mediaUrl($siteSettings->growth_hero_image) ?? 'https://images.unsplash.com/photo-1556761175-b413da4baf72?auto=format&fit=crop&w=1800&q=85')
    <div class="portal-page min-h-screen" style="--portal-color: {{ $siteSettings->growth_color ?: '#f9ad2d' }};">
        <section class="portal-hero" style="background-image: linear-gradient(color-mix(in srgb, var(--portal-color) 78%, transparent), color-mix(in srgb, var(--portal-color) 58%, transparent)), url('{{ $heroImage }}');">
            <div class="section-shell">
                <img src="{{ $siteSettings->mediaUrl($siteSettings->growth_logo_path, asset('logos/Entrepreneirship.png')) }}" alt="Event Planning & Coordination" class="mb-6 h-16 w-auto object-contain object-left">
                <p class="text-sm uppercase tracking-[0.3em] text-white/80">Event Planning &amp; Coordination</p>
                <h1 class="mt-5 text-5xl text-white md:text-7xl">Event Planning &amp; Coordination</h1>
                <p class="mt-4 max-w-2xl text-lg text-white/90">Book Stellar Surge to organize your event, from the first idea and planning details to seamless on-the-day coordination.</p>
            </div>
        </section>
        <div class="section-shell py-16">
            <p class="max-w-2xl text-lg text-charcoal/80">From concept and logistics to guest experience and on-the-day coordination, we make every detail feel intentional.</p>
        </div>
    </div>
@endsection
