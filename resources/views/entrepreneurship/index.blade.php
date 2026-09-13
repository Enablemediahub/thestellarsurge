@extends('layouts.app')

@section('content')
    @php($siteSettings = \App\Models\SiteSetting::current())
    @php($heroImage = $siteSettings->mediaUrl($siteSettings->growth_hero_image) ?? 'https://images.unsplash.com/photo-1556761175-b413da4baf72?auto=format&fit=crop&w=1800&q=85')
    <div class="portal-page min-h-screen" style="--portal-color: {{ $siteSettings->growth_color ?: '#f9ad2d' }};">
        <section class="portal-hero" style="background-image: linear-gradient(color-mix(in srgb, var(--portal-color) 78%, transparent), color-mix(in srgb, var(--portal-color) 58%, transparent)), url('{{ $heroImage }}');">
            <div class="section-shell">
                <p class="text-sm uppercase tracking-[0.3em] text-white/80">Stellar Surge Growth</p>
                <h1 class="mt-5 text-5xl text-white md:text-7xl">Entrepreneurship</h1>
                <p class="mt-4 max-w-2xl text-lg text-white/90">Empowerment experiences, programs and community growth for ambitious founders.</p>
            </div>
        </section>
        <div class="section-shell py-16">
            <p class="max-w-2xl text-lg text-charcoal/80">Build with clarity, community and practical support for the next stage of your work.</p>
        </div>
    </div>
@endsection
