@extends('layouts.events')

@push('styles')
    <link rel="manifest" href="{{ asset('ticket-scanner-manifest.json') }}">
    <style>
        .scanner-shell { min-height: calc(100vh - 9rem); }
        .scanner-video-frame { aspect-ratio: 1 / 1; overflow: hidden; background: #1f1b1f; }
        .scanner-video-frame video { width: 100%; height: 100%; object-fit: cover; }
        .scanner-target { position: absolute; inset: 18%; border: 3px solid #e17b7c; border-radius: 1.25rem; box-shadow: 0 0 0 999px rgba(31, 27, 31, .3); }
    </style>
@endpush

@section('events-content')
    <main class="scanner-shell bg-[#f7f2e9] py-8 md:py-12">
        <div class="mx-auto w-full max-w-xl px-4 sm:px-6">
            <div class="mb-6 flex items-center justify-between gap-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.28em] text-plum/60">Stellar Surge Events</p>
                    <h1 class="mt-2 text-3xl text-plum md:text-4xl">Ticket scanner</h1>
                </div>
                <span class="rounded-full bg-green-100 px-3 py-2 text-xs font-semibold uppercase tracking-[0.16em] text-green-800">Ready</span>
            </div>

            <section class="overflow-hidden rounded-[1.5rem] border border-[#eadfcf] bg-white shadow-brand">
                <div class="scanner-video-frame relative">
                    <video data-scanner-video autoplay muted playsinline></video>
                    <div class="scanner-target" aria-hidden="true"></div>
                    <div data-scanner-placeholder class="absolute inset-0 flex items-center justify-center px-8 text-center text-sm text-white/80">
                        Tap start camera to scan a ticket QR code.
                    </div>
                </div>
                <div class="space-y-4 p-5 md:p-6">
                    <p data-scanner-status class="text-sm text-charcoal/70" role="status">Camera permission is required to scan tickets.</p>
                    <button type="button" data-scanner-start class="inline-flex w-full items-center justify-center rounded-full bg-plum px-5 py-3 text-sm font-semibold text-ivory transition hover:bg-charcoal">Start camera</button>
                    <button type="button" data-scanner-stop hidden class="inline-flex w-full items-center justify-center rounded-full border border-plum px-5 py-3 text-sm font-semibold text-plum transition hover:bg-plum hover:text-ivory">Stop camera</button>

                    <div class="border-t border-plum/10 pt-4">
                        <label for="scanner-token" class="mb-2 block text-xs font-semibold uppercase tracking-[0.2em] text-plum/70">Open a scanned link manually</label>
                        <div class="flex flex-col gap-2 sm:flex-row">
                            <input id="scanner-token" data-scanner-token type="url" placeholder="Paste the ticket verification link" class="min-w-0 flex-1 rounded-2xl border border-[#dccbb1] bg-[#fffaf4] px-4 py-3 text-sm outline-none focus:border-plum">
                            <button type="button" data-scanner-open class="rounded-full bg-[#e17b7c] px-5 py-3 text-sm font-semibold text-white transition hover:bg-plum">Open</button>
                        </div>
                    </div>
                </div>
            </section>

            <p class="mt-5 text-center text-xs text-charcoal/60">Use this page on the event entrance phone. A successful scan opens the secure verification page.</p>
        </div>
    </main>

    @push('scripts')
        <script>
            const scannerVideo = document.querySelector('[data-scanner-video]');
            const scannerStatus = document.querySelector('[data-scanner-status]');
            const scannerPlaceholder = document.querySelector('[data-scanner-placeholder]');
            const scannerStart = document.querySelector('[data-scanner-start]');
            const scannerStop = document.querySelector('[data-scanner-stop]');
            const scannerToken = document.querySelector('[data-scanner-token]');
            let scannerStream;
            let scannerFrame;

            const stopScanner = () => {
                if (scannerFrame) cancelAnimationFrame(scannerFrame);
                scannerStream?.getTracks().forEach((track) => track.stop());
                scannerStream = null;
                scannerStop.hidden = true;
                scannerStart.hidden = false;
                scannerPlaceholder.hidden = false;
            };

            const openVerification = (value) => {
                try {
                    const url = new URL(value, window.location.origin);
                    if (url.pathname.includes('/tickets/verify')) {
                        stopScanner();
                        window.location.href = url.href;
                        return;
                    }
                } catch (error) {
                    // Fall through to the visible scanner status.
                }
                scannerStatus.textContent = 'That code is not a Stellar Surge verification link.';
            };

            const scanFrame = async (detector) => {
                if (!scannerStream) return;
                try {
                    const results = await detector.detect(scannerVideo);
                    if (results.length) {
                        openVerification(results[0].rawValue);
                        return;
                    }
                } catch (error) {
                    scannerStatus.textContent = 'Keep the QR code inside the frame.';
                }
                scannerFrame = requestAnimationFrame(() => scanFrame(detector));
            };

            scannerStart?.addEventListener('click', async () => {
                if (!('BarcodeDetector' in window)) {
                    scannerStatus.textContent = 'This browser does not support camera QR scanning. Paste the ticket link below.';
                    return;
                }
                try {
                    scannerStream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: { ideal: 'environment' } }, audio: false });
                    scannerVideo.srcObject = scannerStream;
                    scannerPlaceholder.hidden = true;
                    scannerStart.hidden = true;
                    scannerStop.hidden = false;
                    scannerStatus.textContent = 'Point the camera at the ticket QR code.';
                    const detector = new BarcodeDetector({ formats: ['qr_code'] });
                    scanFrame(detector);
                } catch (error) {
                    scannerStatus.textContent = 'Camera access was blocked. Allow camera access or paste the ticket link below.';
                }
            });

            scannerStop?.addEventListener('click', stopScanner);
            document.querySelector('[data-scanner-open]')?.addEventListener('click', () => openVerification(scannerToken.value.trim()));
        </script>
    @endpush
@endsection
