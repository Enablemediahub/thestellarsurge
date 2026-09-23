<!DOCTYPE html>
@php
    $siteSettings = \App\Models\SiteSetting::current();
    $whatsappNumber = $siteSettings->whatsapp_number ?: env('WHATSAPP_NUMBER', '233240000000');
    $whatsappMessage = urlencode('Hello Stellar Surge, I would like to speak with your team.');
    $whatsappHref = 'https://wa.me/' . preg_replace('/\D+/', '', $whatsappNumber) . '?text=' . $whatsappMessage;
@endphp
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="theme-color" content="{{ $siteSettings->plum_color ?: '#32152F' }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" type="image/png" href="{{ $siteSettings->mediaUrl($siteSettings->favicon_path ?: $siteSettings->logo_path, asset('logos/Main logo.png')) }}">
        <link rel="manifest" href="{{ asset('manifest.json') }}">
        <style>
            :root {
                --color-deep-plum: {{ $siteSettings->plum_color ?: '#32152F' }};
                --color-champagne-gold: {{ $siteSettings->gold_color ?: '#C8A46A' }};
                --color-warm-ivory: {{ $siteSettings->ivory_color ?: '#F7F2E9' }};
            }
        </style>
        @stack('meta')
        <title>{{ $siteSettings->site_name ?: config('app.name', 'Stellar Surge') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('styles')
    </head>
    <body class="min-h-screen bg-ivory text-charcoal antialiased">
        @yield('content')

        <div data-portal-loader hidden class="portal-loader" aria-live="polite" aria-label="Opening portal">
            <div class="portal-loader__ring">
                <img data-portal-loader-logo src="{{ asset('logos/Events.png') }}" alt="" />
            </div>
            <p data-portal-loader-label class="mt-5 text-xs font-semibold uppercase tracking-[0.28em] text-white">Opening portal</p>
        </div>

        <a
            href="{{ $whatsappHref }}"
            target="_blank"
            rel="noopener noreferrer"
            aria-label="Chat on WhatsApp"
            class="fixed bottom-5 right-5 z-50 inline-flex h-16 w-16 items-center justify-center rounded-full bg-[#25D366] text-white shadow-[0_20px_45px_rgba(37,211,102,0.35)] transition duration-300 hover:-translate-y-1 hover:scale-105 hover:shadow-[0_25px_55px_rgba(37,211,102,0.45)]"
        >
            <svg viewBox="0 0 24 24" class="h-8 w-8 fill-current" aria-hidden="true">
                <path d="M19.05 4.95A9.9 9.9 0 0 0 12.1 2c-5.52 0-10 4.48-10 10 0 1.77.46 3.5 1.33 5.02L2 22l5.12-1.32A9.98 9.98 0 0 0 12.1 22c5.52 0 10-4.48 10-10a9.94 9.94 0 0 0-3.05-7.05ZM12.1 18.2c-1.52 0-3.02-.4-4.32-1.16l-.31-.18-3.04.79.82-2.96-.2-.31a8.18 8.18 0 0 1-1.25-4.34c0-4.52 3.68-8.2 8.2-8.2a8.17 8.17 0 0 1 8.2 8.2c0 4.52-3.68 8.2-8.2 8.2Zm4.49-6.12c-.25-.12-1.46-.71-1.69-.79-.23-.08-.4-.12-.57.12-.17.25-.65.79-.8.95-.15.17-.3.19-.55.06-.25-.12-1.06-.39-2.02-1.24-.75-.67-1.25-1.5-1.4-1.75-.15-.25-.02-.39.11-.5.11-.11.25-.29.37-.43.12-.15.16-.25.25-.42.08-.17.04-.31-.02-.43-.06-.12-.57-1.38-.78-1.89-.2-.5-.42-.43-.57-.44h-.49c-.17 0-.43.06-.66.31-.23.25-.88.86-.88 2.1s.9 2.43.99 2.6c.09.17 1.72 2.63 4.16 3.68.58.25 1.04.4 1.4.51.59.19 1.13.16 1.55.1.47-.07 1.46-.6 1.67-1.18.21-.58.21-1.08.15-1.18-.06-.11-.23-.17-.48-.29Z"/>
            </svg>
        </a>

        <aside data-cookie-banner hidden class="site-consent-banner" role="dialog" aria-label="Cookie consent">
            <div>
                <p class="text-sm font-semibold text-plum">Your privacy matters</p>
                <p class="mt-1 max-w-xl text-xs leading-relaxed text-charcoal/70">We use essential cookies to keep Stellar Surge secure and remember your preferences.</p>
            </div>
            <div class="flex shrink-0 items-center gap-2">
                <button data-cookie-dismiss type="button" class="rounded-full px-3 py-2 text-xs font-semibold text-plum/70 transition hover:bg-plum/5">Later</button>
                <button data-cookie-accept type="button" class="rounded-full bg-plum px-4 py-2 text-xs font-semibold text-ivory transition hover:bg-charcoal">Accept all</button>
            </div>
        </aside>

        <aside data-install-prompt hidden class="app-install-prompt" role="dialog" aria-label="Install Stellar Surge app">
            <div class="flex items-start gap-3">
                <img src="{{ $siteSettings->mediaUrl($siteSettings->logo_path, asset('logos/Main logo.png')) }}" alt="" class="h-11 w-11 rounded-xl object-contain bg-white p-1" />
                <div>
                    <p class="font-semibold text-plum">Install Stellar Surge</p>
                    <p class="mt-1 text-xs leading-relaxed text-charcoal/70">Keep the experience close with a faster app launch.</p>
                </div>
            </div>
            <div class="mt-4 flex justify-end gap-2">
                <button data-install-dismiss type="button" class="rounded-full px-3 py-2 text-xs font-semibold text-plum/70 transition hover:bg-plum/5">Not now</button>
                <button data-install-app type="button" class="rounded-full bg-gold px-4 py-2 text-xs font-semibold text-plum transition hover:bg-[#b18f58]">Install app</button>
            </div>
        </aside>

        @stack('scripts')
    </body>
</html>
