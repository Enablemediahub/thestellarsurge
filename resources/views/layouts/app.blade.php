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
        <style>
            :root {
                --color-deep-plum: {{ $siteSettings->plum_color ?: '#32152F' }};
                --color-champagne-gold: {{ $siteSettings->gold_color ?: '#C8A46A' }};
                --color-warm-ivory: {{ $siteSettings->ivory_color ?: '#F7F2E9' }};
            }
        </style>
        <title>{{ $siteSettings->site_name ?: config('app.name', 'Stellar Surge') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('styles')
    </head>
    <body class="min-h-screen bg-ivory text-charcoal antialiased">
        @yield('content')

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

        @stack('scripts')
    </body>
</html>
