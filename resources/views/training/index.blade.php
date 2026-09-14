@extends('layouts.app')

@section('content')
    @php($siteSettings = \App\Models\SiteSetting::current())
    @php($heroImage = $siteSettings->mediaUrl($siteSettings->training_hero_image) ?? 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=1800&q=85')
    <div class="portal-page min-h-screen" style="--portal-color: {{ $siteSettings->training_color ?: '#159d99' }};">
        <section class="portal-hero" style="background-image: linear-gradient(color-mix(in srgb, var(--portal-color) 78%, transparent), color-mix(in srgb, var(--portal-color) 58%, transparent)), url('{{ $heroImage }}');">
            <div class="section-shell">
                <img src="{{ $siteSettings->mediaUrl($siteSettings->training_logo_path, asset('logos/Training.png')) }}" alt="Trainings & Masterclasses" class="mb-6 h-16 w-auto object-contain object-left">
                <p class="text-sm uppercase tracking-[0.3em] text-white/80">Trainings &amp; Masterclasses</p>
                <h1 class="mt-5 text-5xl text-white md:text-7xl">Trainings &amp; Masterclasses</h1>
                <p class="mt-4 max-w-2xl text-lg text-white/90">The Art of Coordination Masterclass, Event Planning Masterclass &amp; Mentorship Program, and The Founders Retreat.</p>
            </div>
        </section>
        <div class="section-shell py-16">
            <p class="max-w-2xl text-lg text-charcoal/80">Learn through practical sessions, useful frameworks and experiences designed to move you forward.</p>
        </div>
    </div>
@endsection
