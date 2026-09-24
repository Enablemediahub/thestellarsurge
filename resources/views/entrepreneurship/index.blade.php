@extends('layouts.app')

@section('content')
    @php
        $heroImage = $siteSettings->mediaUrl($siteSettings->growth_hero_image) ?? 'https://images.unsplash.com/photo-1556761175-b413da4baf72?auto=format&fit=crop&w=1800&q=85';
        $isLocalPath = str_starts_with(request()->getRequestUri(), '/thestellarsurge/public');
        $publicBaseUrl = request()->getSchemeAndHttpHost() . '/thestellarsurge/public';
        $isLocalHost = in_array(request()->getHost(), ['localhost', '127.0.0.1']);
        $mainSiteUrl = $isLocalPath || $isLocalHost ? $publicBaseUrl : 'https://thestellarsurge.com/';
        $galleryUrl = $isLocalPath ? $publicBaseUrl . '/event_planning/gallery' : route('event_planning.gallery.local');
        $formAction = $isLocalPath ? $publicBaseUrl . '/event_planning' : route('event_planning.store.local');
    @endphp
    <div class="portal-page min-h-screen" style="--portal-color: {{ $siteSettings->events_color ?: '#e27f7f' }};">
        <nav class="event-planning-nav border-b border-white/10 text-ivory" style="background-color: var(--portal-color);">
            <div class="section-shell flex items-center justify-between gap-6 py-4">
                <a href="{{ $isLocalPath ? $publicBaseUrl : url('/') }}" class="flex items-center gap-3">
                    <img src="{{ asset('logos/Main logo.png') }}" alt="Stellar Surge" class="h-10 w-auto brightness-0 invert">
                    <span class="hidden border-l border-white/30 pl-3 text-xs font-semibold uppercase tracking-[0.2em] text-white sm:inline">Event Planning</span>
                </a>
                <div class="flex items-center gap-4 text-xs font-semibold uppercase tracking-[0.14em]">
                    <a href="#services" class="hidden text-ivory/85 transition hover:text-white sm:inline">Services</a>
                    <a href="#book" class="hidden text-ivory/85 transition hover:text-white sm:inline">Book us</a>
                    <a href="{{ $galleryUrl }}" class="rounded-full border border-white px-4 py-2 text-white transition hover:bg-white hover:text-plum">Gallery</a>
                    <a href="{{ $mainSiteUrl }}" class="rounded-full bg-white px-4 py-2 text-plum transition hover:bg-plum hover:text-white">Main site</a>
                </div>
            </div>
        </nav>
        <section class="portal-hero" style="background-image: linear-gradient(color-mix(in srgb, var(--portal-color) 78%, transparent), color-mix(in srgb, var(--portal-color) 58%, transparent)), url('{{ $heroImage }}');">
            <div class="section-shell">
                <img src="{{ asset('logos/Event Planning.png') }}" alt="Event Planning & Coordination" class="mb-6 h-16 w-auto object-contain object-left">
                <p class="text-sm uppercase tracking-[0.3em] text-white/80">Event Planning &amp; Coordination</p>
                <h1 class="mt-5 text-5xl text-white md:text-7xl">Event Planning &amp; Coordination</h1>
                <p class="mt-4 max-w-2xl text-lg text-white/90">Book Stellar Surge to organize your event, from the first idea and planning details to seamless on-the-day coordination.</p>
            </div>
        </section>
        <div id="services" class="section-shell py-16 md:py-20">
            <p class="text-sm uppercase tracking-[0.3em] text-plum/70">What we do</p>
            <h2 class="mt-4 max-w-3xl text-4xl text-plum md:text-5xl">The calm behind a memorable event.</h2>
            <div class="mt-10 grid gap-5 md:grid-cols-3">
                @foreach ([['01', 'Concept & planning', 'Shape the vision, run sheets, timelines, budgets, vendors, and the details that make the day yours.'], ['02', 'Coordination', 'Keep every moving part aligned before and during the event so you can be present with your guests.'], ['03', 'Guest experience', 'Create thoughtful arrival moments, room flow, styling direction, and an experience people remember.']] as [$number, $title, $description])
                    <article class="event-planning-service-card rounded-3xl border border-[#e7d9c7] bg-white p-7 shadow-brand">
                        <span class="event-planning-service-icon" aria-hidden="true">{{ $number }}</span>
                        <h3 class="mt-6 text-2xl text-plum">{{ $title }}</h3>
                        <p class="mt-4 text-sm leading-relaxed text-charcoal/75">{{ $description }}</p>
                    </article>
                @endforeach
            </div>
        </div>

        <div id="book" class="bg-[#efe3d5] py-16 md:py-20">
            <div class="section-shell grid gap-10 lg:grid-cols-[.75fr_1.25fr]">
                <div>
                    <p class="text-sm uppercase tracking-[0.3em] text-plum/70">Start the conversation</p>
                    <h2 class="mt-4 text-4xl text-plum md:text-5xl">Let’s organize your next event.</h2>
                    <p class="mt-5 text-lg leading-relaxed text-charcoal/75">Tell us what you are planning and our team will come back with the best way to help.</p>
                </div>
                <div class="rounded-3xl border border-[#e7d9c7] bg-white p-6 shadow-brand md:p-9">
                    @if (session('event_planning_status'))
                        <p class="mb-6 rounded-2xl bg-[#f5ecd9] px-4 py-3 text-sm text-plum">{{ session('event_planning_status') }}</p>
                    @endif
                    <form method="POST" action="{{ $formAction }}" class="grid gap-5 md:grid-cols-2">
                        @csrf
                        <div><label for="planning_name" class="text-sm font-semibold text-plum">Your name</label><input id="planning_name" name="name" value="{{ old('name') }}" required class="mt-2 w-full rounded-2xl border border-plum/15 bg-ivory px-4 py-3 outline-none focus:border-plum"></div>
                        <div><label for="planning_email" class="text-sm font-semibold text-plum">Email address</label><input id="planning_email" type="email" name="email" value="{{ old('email') }}" required class="mt-2 w-full rounded-2xl border border-plum/15 bg-ivory px-4 py-3 outline-none focus:border-plum"></div>
                        <div><label for="planning_phone" class="text-sm font-semibold text-plum">Phone number</label><input id="planning_phone" name="phone" value="{{ old('phone') }}" class="mt-2 w-full rounded-2xl border border-plum/15 bg-ivory px-4 py-3 outline-none focus:border-plum"></div>
                        <div><label for="planning_type" class="text-sm font-semibold text-plum">Event type</label><select id="planning_type" name="event_type" required class="mt-2 w-full rounded-2xl border border-plum/15 bg-ivory px-4 py-3 outline-none focus:border-plum"><option value="">Choose one</option>@foreach (['Wedding', 'Seminar or conference', 'Birthday or celebration', 'Corporate event', 'Other'] as $type)<option value="{{ $type }}" @selected(old('event_type') === $type)>{{ $type }}</option>@endforeach</select></div>
                        <div><label for="planning_preference" class="text-sm font-semibold text-plum">How should we meet?</label><select id="planning_preference" name="consultation_preference" required class="mt-2 w-full rounded-2xl border border-plum/15 bg-ivory px-4 py-3 outline-none focus:border-plum"><option value="">Choose one</option><option value="in_person" @selected(old('consultation_preference') === 'in_person')>In-person</option><option value="online" @selected(old('consultation_preference') === 'online')>Online</option></select></div>
                        <div><label for="planning_date" class="text-sm font-semibold text-plum">Preferred event date</label><input id="planning_date" type="date" name="event_date" value="{{ old('event_date') }}" class="mt-2 w-full rounded-2xl border border-plum/15 bg-ivory px-4 py-3 outline-none focus:border-plum"></div>
                        <div><label for="planning_guests" class="text-sm font-semibold text-plum">Expected guests</label><input id="planning_guests" type="number" min="1" name="guest_count" value="{{ old('guest_count') }}" class="mt-2 w-full rounded-2xl border border-plum/15 bg-ivory px-4 py-3 outline-none focus:border-plum"></div>
                        <div><label for="planning_budget" class="text-sm font-semibold text-plum">Estimated budget</label><input id="planning_budget" name="budget" value="{{ old('budget') }}" placeholder="Optional" class="mt-2 w-full rounded-2xl border border-plum/15 bg-ivory px-4 py-3 outline-none focus:border-plum"></div>
                        <div class="md:col-span-2"><label for="planning_message" class="text-sm font-semibold text-plum">Tell us about the event</label><textarea id="planning_message" name="message" required rows="5" class="mt-2 w-full rounded-2xl border border-plum/15 bg-ivory px-4 py-3 outline-none focus:border-plum">{{ old('message') }}</textarea></div>
                        <button type="submit" class="rounded-full bg-plum px-6 py-3 text-sm font-semibold text-ivory transition hover:bg-charcoal md:col-span-2">Book Stellar Surge</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
