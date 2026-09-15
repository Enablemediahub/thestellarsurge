@extends('layouts.app')

@section('content')
    @php
        $isLocalPath = str_starts_with(request()->getRequestUri(), '/thestellarsurge/public');
        $publicBaseUrl = request()->getSchemeAndHttpHost() . '/thestellarsurge/public';
        $consultationAction = $isLocalPath ? $publicBaseUrl . '/consultation' : route('consultation.store');
        $blogUrl = $isLocalPath ? $publicBaseUrl . '/blogsurge' : route('blogsurge');
    @endphp
    <header class="bg-plum text-ivory">
        <nav class="section-shell flex items-center justify-between py-5">
            <a href="{{ url('/') }}"><img src="{{ $siteSettings->mediaUrl($siteSettings->logo_path, asset('logos/Main logo.png')) }}" alt="{{ $siteSettings->site_name }}" class="h-12 w-auto"></a>
            <div class="flex items-center gap-5 text-sm text-ivory/80">
                <a href="{{ url('/') }}" class="hover:text-gold">Home</a>
                <a href="{{ $blogUrl }}" class="hover:text-gold">BlogSurge</a>
            </div>
        </nav>
    </header>

    <main class="bg-ivory py-16 md:py-24">
        <div class="section-shell grid gap-12 lg:grid-cols-[.8fr_1.2fr]">
            <div>
                <p class="text-sm uppercase tracking-[0.3em] text-plum/70">Bring it to life</p>
                <h1 class="mt-5 text-5xl leading-tight text-plum md:text-6xl">Let’s plan something unforgettable.</h1>
                <p class="mt-6 max-w-lg text-lg leading-relaxed text-charcoal/75">Tell us what you are imagining. From weddings and seminars to intimate celebrations and large-scale experiences, our team will help you shape the details.</p>
                <div class="mt-10 border-l-2 border-gold pl-5 text-sm leading-relaxed text-charcoal/70">
                    <p>Share the essentials and we will come back with the right next step for your event.</p>
                </div>
            </div>

            <div class="rounded-3xl border border-[#e7d9c7] bg-white p-6 shadow-brand md:p-10">
                @if (session('consultation_status'))
                    <div class="mb-6 rounded-2xl border border-[#c8a46a]/40 bg-[#f5ecd9] px-4 py-4 text-sm text-plum">{{ session('consultation_status') }}</div>
                @endif
                @if ($errors->any())
                    <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-4 py-4 text-sm text-red-800">Please check the highlighted details and try again.</div>
                @endif
                <form method="POST" action="{{ $consultationAction }}" class="grid gap-5 md:grid-cols-2">
                    @csrf
                    <div>
                        <label for="name" class="text-sm font-semibold text-plum">Your name</label>
                        <input id="name" name="name" value="{{ old('name') }}" required class="mt-2 w-full rounded-2xl border border-plum/15 bg-ivory px-4 py-3 outline-none focus:border-plum" />
                        @error('name')<p class="mt-1 text-xs text-red-700">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="email" class="text-sm font-semibold text-plum">Email address</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required class="mt-2 w-full rounded-2xl border border-plum/15 bg-ivory px-4 py-3 outline-none focus:border-plum" />
                        @error('email')<p class="mt-1 text-xs text-red-700">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="phone" class="text-sm font-semibold text-plum">Phone number</label>
                        <input id="phone" name="phone" value="{{ old('phone') }}" class="mt-2 w-full rounded-2xl border border-plum/15 bg-ivory px-4 py-3 outline-none focus:border-plum" />
                    </div>
                    <div>
                        <label for="event_type" class="text-sm font-semibold text-plum">Event type</label>
                        <select id="event_type" name="event_type" required class="mt-2 w-full rounded-2xl border border-plum/15 bg-ivory px-4 py-3 outline-none focus:border-plum">
                            <option value="">Choose one</option>
                            @foreach (['Wedding', 'Seminar or conference', 'Birthday or celebration', 'Corporate event', 'Other'] as $type)
                                <option value="{{ $type }}" @selected(old('event_type') === $type)>{{ $type }}</option>
                            @endforeach
                        </select>
                        @error('event_type')<p class="mt-1 text-xs text-red-700">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="consultation_preference" class="text-sm font-semibold text-plum">Consultation preference</label>
                        <select id="consultation_preference" name="consultation_preference" required class="mt-2 w-full rounded-2xl border border-plum/15 bg-ivory px-4 py-3 outline-none focus:border-plum">
                            <option value="">Choose one</option>
                            <option value="in_person" @selected(old('consultation_preference') === 'in_person')>In-person</option>
                            <option value="online" @selected(old('consultation_preference') === 'online')>Online</option>
                        </select>
                        @error('consultation_preference')<p class="mt-1 text-xs text-red-700">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="event_date" class="text-sm font-semibold text-plum">Preferred date</label>
                        <input id="event_date" type="date" name="event_date" value="{{ old('event_date') }}" class="mt-2 w-full rounded-2xl border border-plum/15 bg-ivory px-4 py-3 outline-none focus:border-plum" />
                    </div>
                    <div>
                        <label for="guest_count" class="text-sm font-semibold text-plum">Expected guests</label>
                        <input id="guest_count" type="number" min="1" name="guest_count" value="{{ old('guest_count') }}" class="mt-2 w-full rounded-2xl border border-plum/15 bg-ivory px-4 py-3 outline-none focus:border-plum" />
                    </div>
                    <div class="md:col-span-2">
                        <label for="message" class="text-sm font-semibold text-plum">Tell us about your plans</label>
                        <textarea id="message" name="message" required rows="6" placeholder="What would you like us to help you plan?" class="mt-2 w-full rounded-2xl border border-plum/15 bg-ivory px-4 py-3 outline-none focus:border-plum">{{ old('message') }}</textarea>
                        @error('message')<p class="mt-1 text-xs text-red-700">{{ $message }}</p>@enderror
                    </div>
                    <button type="submit" class="rounded-full bg-plum px-6 py-3 text-sm font-semibold text-ivory transition hover:bg-charcoal md:col-span-2">Request consultation</button>
                </form>
            </div>
        </div>
    </main>
@endsection
