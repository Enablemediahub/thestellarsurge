@extends('layouts.app')

@section('content')
    @php
        $isLocalHost = request()->getHost() === 'localhost';
        $eventsPortalUrl = $isLocalHost ? route('events.index.path') : route('events.index');
        $entrepreneurshipPortalUrl = $isLocalHost ? route('entrepreneurship.index.path') : route('entrepreneurship.index');
        $trainingPortalUrl = $isLocalHost ? route('training.index.path') : route('training.index');
    @endphp
    <header class="hero-wallpaper text-ivory">
        @foreach ($siteSettings->heroSlides as $index => $heroSlide)
            <div class="hero-slide hero-slide--{{ $index + 1 }}" style="background-image: url('{{ $heroSlide }}');"></div>
        @endforeach
        <div class="hero-overlay"></div>

        <nav class="section-shell relative z-10 flex items-center justify-between py-6">
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
                <a href="{{ $eventsPortalUrl }}" class="portal-badge" aria-label="Event & Project Management">
                    <div class="portal-badge__thumb">
                        <img src="{{ asset('logos/Events.png') }}" alt="Event & Project Management" />
                    </div>
                    <span class="portal-badge__text">Event &amp; Project<br>Management</span>
                </a>

                <a href="{{ $entrepreneurshipPortalUrl }}" class="portal-badge" aria-label="Entrepreneurial & Empowerment">
                    <div class="portal-badge__thumb">
                        <img src="{{ asset('logos/Entrepreneirship.png') }}" alt="Entrepreneurial & Empowerment" />
                    </div>
                    <span class="portal-badge__text">Entrepreneurial &amp;<br>Empowerment</span>
                </a>

                <a href="{{ $trainingPortalUrl }}" class="portal-badge" aria-label="Skill Training with MasterClasses">
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
                    <a href="{{ $eventsPortalUrl }}" class="portal-card">
                        <div class="portal-color-thumb portal-color-thumb--events mb-6" style="--portal-events-color: {{ $siteSettings->events_color ?: '#E17B7C' }}" aria-hidden="true">
                            <img src="{{ $siteSettings->mediaUrl($siteSettings->events_logo_path, asset('logos/Events.png')) }}" alt="" />
                        </div>
                        <p class="text-sm uppercase tracking-[0.24em] text-plum/60">Events</p>
                        <h3 class="mt-4 text-3xl text-plum">Event &amp; Project Management</h3>
                        <p class="mt-4 text-base text-charcoal/80">Discover experiences, manage tickets, and shape unforgettable creative moments.</p>
                        <div class="mt-6 inline-flex items-center gap-2 font-semibold text-plum">Explore <span aria-hidden="true">→</span></div>
                    </a>

                    <a href="{{ $entrepreneurshipPortalUrl }}" class="portal-card">
                        <div class="portal-color-thumb portal-color-thumb--growth mb-6" style="--portal-growth-color: {{ $siteSettings->growth_color ?: '#F9AD2D' }}" aria-hidden="true">
                            <img src="{{ $siteSettings->mediaUrl($siteSettings->growth_logo_path, asset('logos/Entrepreneirship.png')) }}" alt="" />
                        </div>
                        <p class="text-sm uppercase tracking-[0.24em] text-plum/60">Growth</p>
                        <h3 class="mt-4 text-3xl text-plum">Entrepreneurial &amp; Empowerment</h3>
                        <p class="mt-4 text-base text-charcoal/80">Programs, communities, and support systems that turn ambition into momentum.</p>
                        <div class="mt-6 inline-flex items-center gap-2 font-semibold text-plum">Explore <span aria-hidden="true">→</span></div>
                    </a>

                    <a href="{{ $trainingPortalUrl }}" class="portal-card">
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
                                    src="{{ $event->banner_image ?? 'https://images.unsplash.com/photo-1511578314322-379afb476865?auto=format&fit=crop&w=1200&q=80' }}"
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
                                @if (! empty($socialLink['logo_path']))
                                    <img src="{{ $siteSettings->mediaUrl($socialLink['logo_path']) }}" alt="" class="h-5 w-5 object-contain" />
                                @endif
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
