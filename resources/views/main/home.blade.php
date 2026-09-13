@extends('layouts.app')

@section('content')
    @php
        $isPublicPathPortal = str_starts_with(request()->getRequestUri(), '/thestellarsurge/public');
        $isLocalHost = request()->getHost() === 'localhost' || $isPublicPathPortal;
        $publicBaseUrl = request()->getSchemeAndHttpHost() . '/thestellarsurge/public';
        $eventsPortalUrl = $isLocalHost ? $publicBaseUrl . '/events' : route('events.index');
        $entrepreneurshipPortalUrl = $isLocalHost ? $publicBaseUrl . '/entrepreneurship' : route('entrepreneurship.index');
        $trainingPortalUrl = $isLocalHost ? $publicBaseUrl . '/training' : route('training.index');
        $testimonialRoute = $isLocalHost ? $publicBaseUrl . '/testimonials' : route('testimonials.store.production');
        $subscriberRoute = $isLocalHost ? $publicBaseUrl . '/subscribe' : route('subscribers.store.production');
    @endphp
    <header class="hero-wallpaper text-ivory">
        @foreach ($siteSettings->heroSlidesForDisplay() as $index => $heroSlide)
            <div class="hero-slide hero-slide--{{ $index + 1 }}" style="background-image: url('{{ $heroSlide }}');"></div>
        @endforeach
        <div class="hero-overlay"></div>

        <nav class="section-shell relative z-30 flex items-center justify-between py-6">
            <div class="flex items-center gap-3">
                        <img src="{{ $siteSettings->mediaUrl($siteSettings->logo_path, asset('logos/Main logo.png')) }}" alt="{{ $siteSettings->site_name }}" class="h-14 w-auto" />
            </div>

            <div class="hidden items-center gap-6 text-sm md:flex">
                <a href="#about" class="text-ivory/80 transition hover:text-gold">About</a>
                <a href="#portals" class="text-ivory/80 transition hover:text-gold">Portals</a>
                <a href="#events" class="text-ivory/80 transition hover:text-gold">Events</a>
                <a href="#contact" class="text-ivory/80 transition hover:text-gold">Contact</a>
            </div>

            <div class="hidden md:block">
                <a href="{{ $eventsPortalUrl }}" class="rounded-full border border-gold px-5 py-2 text-sm font-medium text-gold transition hover:bg-gold hover:text-plum">Enter the Surge</a>
            </div>

            <button type="button" data-mobile-drawer-open="main-mobile-nav" class="flex items-center gap-2 rounded-full border border-white/30 px-4 py-2 text-sm font-semibold text-ivory md:hidden">Menu <span aria-hidden="true">☰</span></button>
            <aside id="main-mobile-nav" data-mobile-drawer hidden class="mobile-nav-drawer md:hidden" aria-label="Mobile navigation">
                <div class="mobile-nav-drawer__panel">
                    <button type="button" data-mobile-drawer-close class="mobile-nav-drawer__close" aria-label="Close navigation">&times;</button>
                    <p class="mb-4 text-xs font-semibold uppercase tracking-[0.25em] text-gold">Stellar Surge</p>
                    <a href="#about" class="block rounded-xl px-3 py-3 text-ivory/85 hover:bg-white/10 hover:text-gold">About</a>
                    <a href="#portals" class="block rounded-xl px-3 py-3 text-ivory/85 hover:bg-white/10 hover:text-gold">Portals</a>
                    <a href="#events" class="block rounded-xl px-3 py-3 text-ivory/85 hover:bg-white/10 hover:text-gold">Events</a>
                    <a href="#contact" class="block rounded-xl px-3 py-3 text-ivory/85 hover:bg-white/10 hover:text-gold">Contact</a>
                    <a href="{{ $eventsPortalUrl }}" class="mt-2 block rounded-xl bg-gold px-3 py-3 font-semibold text-plum">Enter the Surge</a>
                </div>
            </aside>
        </nav>

        <div class="section-shell relative z-10 pb-16 pt-10 md:pb-24 md:pt-16">
            <div class="max-w-3xl fade-in">
                <p class="mb-5 text-sm uppercase tracking-[0.35em] text-gold">Create. Experience. Impact.</p>
                <h1 class="max-w-2xl text-5xl leading-none md:text-7xl">Stellar Surge</h1>
                <p class="mt-6 max-w-xl text-lg text-ivory/80">More than just events. We create experiences, stories, spaces and opportunities that move people.</p>
                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="#portals" class="rounded-full bg-gold px-6 py-3 text-sm font-semibold text-plum shadow-lg shadow-gold/20 transition hover:scale-[1.02]">Explore the portals</a>
                    <a href="#events" class="rounded-full border border-white/20 bg-white/5 px-6 py-3 text-sm font-semibold text-ivory transition hover:border-gold hover:text-gold">Featured events</a>
                </div>
            </div>

            <div class="mt-14 grid gap-6 md:grid-cols-3">
                <a href="{{ $eventsPortalUrl }}" data-portal-loading data-portal-color="#e27f7f" data-portal-logo="{{ asset('logos/Events.png') }}" class="portal-badge" aria-label="Event & Project Management">
                    <div class="portal-badge__thumb">
                        <img src="{{ asset('logos/Events.png') }}" alt="Event & Project Management" />
                    </div>
                    <span class="portal-badge__text">Event &amp; Project<br>Management</span>
                </a>

                <a href="{{ $entrepreneurshipPortalUrl }}" data-portal-loading data-portal-color="#f9ad2d" data-portal-logo="{{ asset('logos/Entrepreneirship.png') }}" class="portal-badge" aria-label="Entrepreneurial & Empowerment">
                    <div class="portal-badge__thumb">
                        <img src="{{ asset('logos/Entrepreneirship.png') }}" alt="Entrepreneurial & Empowerment" />
                    </div>
                    <span class="portal-badge__text">Entrepreneurial &amp;<br>Empowerment</span>
                </a>

                <a href="{{ $trainingPortalUrl }}" data-portal-loading data-portal-color="#159d99" data-portal-logo="{{ asset('logos/Training.png') }}" class="portal-badge" aria-label="Skill Training with MasterClasses">
                    <div class="portal-badge__thumb">
                        <img src="{{ asset('logos/Training.png') }}" alt="Skill Training with MasterClasses" />
                    </div>
                    <span class="portal-badge__text">Skill Training<br>with MasterClasses</span>
                </a>
            </div>
        </div>
    </header>

    <main>
        <section id="about" class="py-20">
            <div class="section-shell text-center">
                <p class="text-sm uppercase tracking-[0.35em] text-plum/70">Stellar statement</p>
                <h2 class="mx-auto mt-6 max-w-4xl text-4xl text-plum md:text-6xl">More than just events. We create experiences, stories, spaces and opportunities that move people.</h2>
                <div class="mx-auto mt-8 h-1 w-24 rounded-full bg-gold"></div>
            </div>
        </section>

        <section id="portals" class="bg-[#efe3d5] py-20">
            <div class="section-shell">
                <div class="mb-10 text-center">
                    <p class="text-sm uppercase tracking-[0.3em] text-plum/70">Choose your path</p>
                    <h2 class="mt-4 text-4xl text-plum md:text-5xl">Three portals. One movement.</h2>
                </div>

                <div class="grid gap-6 md:grid-cols-3">
                    <a href="{{ $eventsPortalUrl }}" data-portal-loading data-portal-color="#e27f7f" data-portal-logo="{{ asset('logos/Events.png') }}" class="portal-card">
                        <div class="portal-color-thumb portal-color-thumb--events mb-6" style="--portal-events-color: {{ $siteSettings->events_color ?: '#E17B7C' }}" aria-hidden="true">
                            <img src="{{ $siteSettings->mediaUrl($siteSettings->events_logo_path, asset('logos/Events.png')) }}" alt="" />
                        </div>
                        <p class="text-sm uppercase tracking-[0.24em] text-plum/60">Events</p>
                        <h3 class="mt-4 text-3xl text-plum">Event &amp; Project Management</h3>
                        <p class="mt-4 text-base text-charcoal/80">Discover experiences, manage tickets, and shape unforgettable creative moments.</p>
                        <div class="mt-6 inline-flex items-center gap-2 font-semibold text-plum">Explore <span aria-hidden="true">→</span></div>
                    </a>

                    <a href="{{ $entrepreneurshipPortalUrl }}" data-portal-loading data-portal-color="#f9ad2d" data-portal-logo="{{ asset('logos/Entrepreneirship.png') }}" class="portal-card">
                        <div class="portal-color-thumb portal-color-thumb--growth mb-6" style="--portal-growth-color: {{ $siteSettings->growth_color ?: '#F9AD2D' }}" aria-hidden="true">
                            <img src="{{ $siteSettings->mediaUrl($siteSettings->growth_logo_path, asset('logos/Entrepreneirship.png')) }}" alt="" />
                        </div>
                        <p class="text-sm uppercase tracking-[0.24em] text-plum/60">Growth</p>
                        <h3 class="mt-4 text-3xl text-plum">Entrepreneurial &amp; Empowerment</h3>
                        <p class="mt-4 text-base text-charcoal/80">Programs, communities, and support systems that turn ambition into momentum.</p>
                        <div class="mt-6 inline-flex items-center gap-2 font-semibold text-plum">Explore <span aria-hidden="true">→</span></div>
                    </a>

                    <a href="{{ $trainingPortalUrl }}" data-portal-loading data-portal-color="#159d99" data-portal-logo="{{ asset('logos/Training.png') }}" class="portal-card">
                        <div class="portal-color-thumb portal-color-thumb--learning mb-6" style="--portal-learning-color: {{ $siteSettings->training_color ?: '#159D99' }}" aria-hidden="true">
                            <img src="{{ $siteSettings->mediaUrl($siteSettings->training_logo_path, asset('logos/Training.png')) }}" alt="" />
                        </div>
                        <p class="text-sm uppercase tracking-[0.24em] text-plum/60">Learning</p>
                        <h3 class="mt-4 text-3xl text-plum">Skill Training with Masterclasses</h3>
                        <p class="mt-4 text-base text-charcoal/80">Build practical expertise through premium training experiences and guided learning.</p>
                        <div class="mt-6 inline-flex items-center gap-2 font-semibold text-plum">Explore <span aria-hidden="true">→</span></div>
                    </a>
                </div>
            </div>
        </section>

        <section id="events" class="py-20">
            <div class="section-shell">
                <div class="mb-10 flex items-end justify-between gap-4">
                    <div>
                        <p class="text-sm uppercase tracking-[0.3em] text-plum/70">Featured</p>
                        <h2 class="mt-4 text-4xl text-plum md:text-5xl">Upcoming experiences</h2>
                    </div>
                    <a href="{{ $eventsPortalUrl }}" class="hidden text-sm font-semibold uppercase tracking-[0.2em] text-plum md:inline-block">View all</a>
                </div>

                <div class="grid gap-6 md:grid-cols-3">
                    @foreach ($featuredEvents as $event)
                        <article class="overflow-hidden rounded-3xl border border-[#e7d9c7] bg-white shadow-brand">
                            <div class="h-64 overflow-hidden bg-[#f3ece1]">
                                <img
                                    src="{{ $event->bannerImageUrl() ?? 'https://images.unsplash.com/photo-1511578314322-379afb476865?auto=format&fit=crop&w=1200&q=80' }}"
                                    alt="{{ $event->title }} flyer"
                                    class="h-full w-full object-cover transition duration-500 hover:scale-105"
                                >
                            </div>

                            <div class="p-6">
                                <div class="mb-4 inline-flex rounded-full bg-gold/20 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-plum">Event</div>
                                <h3 class="text-2xl text-plum">{{ $event->title }}</h3>
                                <p class="mt-4 text-sm text-charcoal/75">{{ $event->summary ?: Str::limit(strip_tags($event->description ?? ''), 120) }}</p>
                                <div class="mt-6 space-y-2 text-sm text-charcoal/80">
                                    <p><strong>Date:</strong> {{ $event->start_at?->format('d M Y') ?? 'TBA' }}</p>
                                    <p><strong>Location:</strong> {{ $event->location }}</p>
                                </div>
                                <a href="{{ route('events.show.local', ['slug' => $event->slug]) }}" class="mt-6 inline-flex rounded-full bg-plum px-5 py-2.5 text-sm font-semibold text-ivory transition hover:bg-charcoal">Get ticket</a>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="bg-plum py-20 text-ivory">
            <div class="section-shell text-center">
                <p class="text-sm uppercase tracking-[0.35em] text-gold">Testimonial</p>
                @if ($testimonial)
                    <blockquote class="mx-auto mt-6 max-w-4xl text-3xl leading-relaxed md:text-5xl">“{{ $testimonial->quote }}”</blockquote>
                    <p class="mt-8 text-sm uppercase tracking-[0.28em] text-ivory/70">— {{ $testimonial->author }}{{ $testimonial->role ? ', ' . $testimonial->role : '' }}</p>
                @endif
                @if (session('testimonial_status'))
                    <p class="mx-auto mt-6 max-w-lg rounded-2xl border border-gold/30 bg-white/10 px-4 py-3 text-sm text-gold">{{ session('testimonial_status') }}</p>
                @endif
                <div class="mx-auto mt-8 max-w-2xl" x-data="{ open: {{ $errors->any() ? 'true' : 'false' }} }">
                    <button type="button" @click="open = !open" class="rounded-full bg-gold px-5 py-3 text-sm font-semibold text-plum transition hover:bg-white" x-text="open ? 'Close testimonial form' : 'Share your testimonial'"></button>
                    <form x-show="open" x-cloak method="POST" action="{{ $testimonialRoute }}" class="mt-5 grid gap-3 text-left md:grid-cols-2">
                        @csrf
                        <textarea name="quote" required rows="3" placeholder="Share your Stellar Surge experience" class="rounded-2xl border-0 bg-white/10 px-4 py-3 text-sm text-ivory placeholder:text-ivory/60 outline-none ring-1 ring-white/15 focus:ring-gold md:col-span-2">{{ old('quote') }}</textarea>
                        <input name="author" required value="{{ old('author') }}" placeholder="Your name" class="rounded-full border-0 bg-white/10 px-4 py-3 text-sm text-ivory placeholder:text-ivory/60 outline-none ring-1 ring-white/15 focus:ring-gold" />
                        <input name="role" value="{{ old('role') }}" placeholder="Role or community" class="rounded-full border-0 bg-white/10 px-4 py-3 text-sm text-ivory placeholder:text-ivory/60 outline-none ring-1 ring-white/15 focus:ring-gold" />
                        <button type="submit" class="rounded-full bg-gold px-5 py-3 text-sm font-semibold text-plum transition hover:bg-white md:col-span-2">Submit testimonial</button>
                    </form>
                </div>
            </div>
        </section>

        <section class="bg-[#efe3d5] py-16">
            <div class="section-shell mx-auto max-w-3xl text-center">
                <p class="text-sm uppercase tracking-[0.3em] text-plum/70">Stay in the movement</p>
                <h2 class="mt-4 text-4xl text-plum md:text-5xl">Get first word on what is next.</h2>
                @if (session('subscription_status'))
                    <p class="mx-auto mt-5 max-w-lg rounded-2xl bg-white px-4 py-3 text-sm text-plum shadow-brand">{{ session('subscription_status') }}</p>
                @endif
                <form method="POST" action="{{ $subscriberRoute }}" class="mx-auto mt-8 flex max-w-xl flex-col gap-3 sm:flex-row">
                    @csrf
                    <input name="name" placeholder="Your name" class="min-w-0 flex-1 rounded-full border border-plum/15 bg-white px-5 py-3 text-sm outline-none focus:border-plum" />
                    <input name="email" type="email" required placeholder="Email address" class="min-w-0 flex-1 rounded-full border border-plum/15 bg-white px-5 py-3 text-sm outline-none focus:border-plum" />
                    <button type="submit" class="rounded-full bg-plum px-5 py-3 text-sm font-semibold text-ivory transition hover:bg-charcoal">Subscribe</button>
                </form>
            </div>
        </section>
    </main>

    <footer id="contact" class="bg-[#f1e7dc] py-14">
        <div class="section-shell grid gap-6 md:grid-cols-4">
            <div>
                <div class="flex items-center gap-3">
                    <img src="{{ $siteSettings->mediaUrl($siteSettings->logo_path, asset('logos/Main logo.png')) }}" alt="{{ $siteSettings->site_name }}" class="h-12 w-auto" />
                </div>
            </div>
            <div>
                <p class="text-sm uppercase tracking-[0.24em] text-plum/70">Socials</p>
                <ul class="mt-4 space-y-2 text-sm text-plum/80">
                    @foreach ($siteSettings->social_links ?: [] as $socialLink)
                        <li>
                            <a href="{{ $socialLink['url'] ?? '#' }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 transition hover:text-plum">
                                <span class="social-icon social-icon--{{ $socialLink['platform'] ?? 'link' }}" aria-hidden="true">
                                    @switch($socialLink['platform'] ?? '')
                                        @case('instagram')
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r=".8" fill="currentColor" stroke="none"/></svg>
                                            @break
                                        @case('facebook')
                                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M14 8h3V4h-3c-3.3 0-5 1.9-5 5v3H6v4h3v4h4v-4h3.2l.8-4H13V9c0-.7.3-1 1-1Z"/></svg>
                                            @break
                                        @case('linkedin')
                                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M5 8H2V21H5V8ZM3.5 3A1.8 1.8 0 1 0 3.5 6.6 1.8 1.8 0 0 0 3.5 3ZM22 13.6c0-3.9-2.1-5.7-4.9-5.7-2.3 0-3.3 1.3-3.9 2.2V8H10V21h3.2v-6.4c0-1.7.3-3.4 2.5-3.4 2.2 0 2.2 2 2.2 3.5V21H22v-7.4Z"/></svg>
                                            @break
                                        @case('youtube')
                                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M23 12s0-3.3-.4-4.8a2.5 2.5 0 0 0-1.8-1.8C19.3 5 12 5 12 5s-7.3 0-8.8.4a2.5 2.5 0 0 0-1.8 1.8C1 8.7 1 12 1 12s0 3.3.4 4.8a2.5 2.5 0 0 0 1.8 1.8C4.7 19 12 19 12 19s7.3 0 8.8-.4a2.5 2.5 0 0 0 1.8-1.8C23 15.3 23 12 23 12ZM10 15.5v-7l6 3.5-6 3.5Z"/></svg>
                                            @break
                                        @case('tiktok')
                                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M15 3h3.1c.3 1.7 1.3 3 2.9 3.6V10a8.6 8.6 0 0 1-2.9-1V15a6 6 0 1 1-6-6c.4 0 .8 0 1.2.1v3.5a2.7 2.7 0 1 0 1.7 2.5V3Z"/></svg>
                                            @break
                                        @case('x')
                                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M18.9 2H22l-6.8 7.8L23.2 22h-6.3l-4.9-6.4L6.4 22H3.3l7.2-8.2L2.8 2h6.4l4.4 5.8L18.9 2Zm-1.1 17.5h1.7L8.3 4.4H6.5l11.3 15.1Z"/></svg>
                                            @break
                                        @case('whatsapp')
                                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M19.1 4.9A9.9 9.9 0 0 0 12.1 2C6.6 2 2.1 6.5 2.1 12c0 1.8.5 3.5 1.3 5L2 22l5.1-1.3a10 10 0 0 0 5 1.3c5.5 0 10-4.5 10-10a9.9 9.9 0 0 0-3-7.1Zm-7 15.4c-1.5 0-3-.4-4.3-1.2l-.3-.2-3 .8.8-2.9-.2-.3A8.2 8.2 0 1 1 12.1 20.3Zm4.5-6.1c-.2-.1-1.4-.7-1.6-.8-.2-.1-.4-.1-.6.1l-.8 1c-.1.2-.3.2-.5.1-1.8-.9-3-1.6-4.1-3.6-.2-.3 0-.4.1-.5l.4-.5c.1-.1.2-.3.2-.4.1-.1 0-.3 0-.4l-.7-1.8c-.2-.5-.4-.4-.6-.4h-.5c-.2 0-.4.1-.6.3-.2.2-.8.8-.8 2s.8 2.3.9 2.5c.1.2 1.6 2.5 3.9 3.5 1.5.7 2.1.7 2.9.6.5-.1 1.4-.6 1.6-1.2.2-.6.2-1.1.1-1.2-.1-.1-.3-.2-.5-.3Z"/></svg>
                                            @break
                                        @default
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M10 13a5 5 0 0 0 7.1.1l2-2a5 5 0 0 0-7.1-7.1L11 5"/><path d="M14 11a5 5 0 0 0-7.1-.1l-2 2A5 5 0 0 0 12 20l1-1"/></svg>
                                    @endswitch
                                </span>
                                <span>{{ $socialLink['label'] ?? $socialLink['url'] }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div>
                <p class="text-sm uppercase tracking-[0.24em] text-plum/70">Email</p>
                <p class="mt-4 text-sm text-plum/80">{{ $siteSettings->contact_email ?: 'hello@thestellarsurge.com' }}</p>
            </div>
            <div>
                <p class="text-sm uppercase tracking-[0.24em] text-plum/70">Subdomains</p>
                <ul class="mt-4 space-y-2 text-sm text-plum/80">
                    <li><a href="{{ $eventsPortalUrl }}">Events</a></li>
                    <li><a href="{{ $entrepreneurshipPortalUrl }}">Entrepreneurship</a></li>
                    <li><a href="{{ $trainingPortalUrl }}">Training</a></li>
                </ul>
            </div>
        </div>
        <div class="section-shell mt-10 flex flex-col gap-3 border-t border-plum/10 pt-6 text-sm text-plum/70 md:flex-row md:items-center md:justify-between">
            <div class="space-y-1">
                <p>© {{ date('Y') }} {{ $siteSettings->site_name }}. All rights reserved.</p>
                <p class="text-xs uppercase tracking-[0.2em] text-plum/60">{{ $siteSettings->footer_credit ?: 'Developed and Designed by DALE QUIST [Enable Technologies]' }}</p>
            </div>
            <button data-pwa-install type="button" hidden class="inline-flex rounded-full border border-plum px-4 py-2 font-medium text-plum hover:bg-plum hover:text-ivory">Install app</button>
        </div>
    </footer>
@endsection
