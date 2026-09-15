<?php

namespace App\Http\Controllers\Events;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Payment;
use App\Models\Ticket;
use App\Models\EventGalleryComment;
use App\Mail\TicketIssued;
use App\Services\TicketDeliveryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Unicodeveloper\Paystack\Facades\Paystack;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\TicketSecurityService;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::query()
            ->where('is_published', true)
            ->orderByDesc('featured')
            ->orderBy('start_at', 'asc')
            ->get();

        $featuredEvents = $events->where('featured', true)->values();
        $featuredEvent = $featuredEvents->first();
        $regularEvents = $events->where('featured', false)->values();

        return view('events.index', compact('events', 'featuredEvents', 'featuredEvent', 'regularEvents'));
    }

    public function show(string $slug)
    {
        $event = Event::query()
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        $event->load(['galleryItems' => fn ($query) => $query->where('is_published', true)->with(['comments' => fn ($comments) => $comments->where('is_approved', true)->latest()])]);

        return view('events.show', compact('event'));
    }

    public function gallery(string $slug)
    {
        $event = Event::query()->where('slug', $slug)->where('is_published', true)->with(['galleryItems' => fn ($query) => $query->where('is_published', true)->with(['comments' => fn ($comments) => $comments->where('is_approved', true)->latest()])])->firstOrFail();

        return view('events.gallery', compact('event'));
    }

    public function galleryIndex()
    {
        $events = Event::query()->where('is_published', true)->whereHas('galleryItems', fn ($query) => $query->where('is_published', true))->with(['galleryItems' => fn ($query) => $query->where('is_published', true)])->orderBy('start_at')->get();

        return view('events.gallery-index', compact('events'));
    }

    public function likeGalleryItem(Request $request, string $slug, int $galleryItem)
    {
        abort_unless(! $request->session()->has('gallery-liked-' . $galleryItem), 409, 'Already liked');
        $event = Event::query()->where('slug', $slug)->where('is_published', true)->firstOrFail();
        $item = $event->galleryItems()->where('is_published', true)->findOrFail($galleryItem);
        $item->increment('likes_count');
        $request->session()->put('gallery-liked-' . $galleryItem, true);

        return back();
    }

    public function commentGalleryItem(Request $request, string $slug, int $galleryItem)
    {
        $validated = $request->validate(['name' => ['required', 'string', 'max:100'], 'email' => ['nullable', 'email', 'max:255'], 'body' => ['required', 'string', 'min:2', 'max:1000']]);
        $event = Event::query()->where('slug', $slug)->where('is_published', true)->firstOrFail();
        $item = $event->galleryItems()->where('is_published', true)->findOrFail($galleryItem);
        EventGalleryComment::create($validated + ['event_gallery_item_id' => $item->id]);

        return back()->with('gallery_status', 'Comment submitted for review.');
    }

    public function checkout(string $slug)
    {
        $event = Event::query()
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        return view('events.checkout', compact('event'));
    }

    public function ticketScanner()
    {
        abort_unless(\App\Models\SiteSetting::current()->ticket_scanner_enabled, 404);

        return view('events.ticket-scanner');
    }

    public function purchase(Request $request, string $slug)
    {
        $event = Event::query()
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'phone' => ['required', 'string', 'max:50'],
            'whatsapp_confirmed' => ['accepted'],
            'quantity' => ['required', 'integer', 'min:1', 'max:10'],
            'ticket_type' => ['required', 'string'],
        ]);

        $quantity = (int) $validated['quantity'];
        $ticketOption = collect($event->ticketOptions())->firstWhere('slug', $validated['ticket_type']);

        if (! $ticketOption) {
            return back()->withErrors(['ticket_type' => 'Please select a valid ticket category.'])->withInput();
        }

        $ticketPrice = (int) $ticketOption['price'];
        $tickets = collect();
        $ticketReferences = [];

        DB::transaction(function () use (&$tickets, &$ticketReferences, $event, $request, $validated, $quantity, $ticketOption, $ticketPrice): void {
            for ($index = 0; $index < $quantity; $index++) {
                $ticketReference = 'TCK-' . strtoupper(Str::random(12));
                $ticketReferences[] = $ticketReference;
                $tickets->push(Ticket::create([
                    'event_id' => $event->id,
                    'user_id' => $request->user()?->id,
                    'reference' => $ticketReference,
                    'email' => $validated['email'],
                    'name' => $validated['name'],
                    'phone' => $validated['phone'],
                    'whatsapp_confirmed' => true,
                    'ticket_type' => $ticketOption['slug'],
                    'amount' => $ticketPrice,
                    'currency' => $event->currency,
                    'status' => 'pending',
                ]));
            }
        });

        $paymentReference = 'SS-' . strtoupper(Str::random(12));
        $payment = Payment::create([
            'event_id' => $event->id,
            'ticket_id' => $tickets->first()->id,
            'user_id' => $request->user()?->id,
            'reference' => $paymentReference,
            'amount' => $ticketPrice * $quantity,
            'currency' => $event->currency,
            'status' => 'pending',
            'gateway' => config('services.paystack.mode') === 'demo' && ! app()->environment('production') ? 'demo' : 'paystack',
            'metadata' => [
                'event_slug' => $event->slug,
                'ticket_references' => $ticketReferences,
                'customer_email' => $validated['email'],
                'quantity' => $quantity,
                'ticket_type' => $ticketOption['slug'],
                'ticket_type_name' => $ticketOption['name'],
            ],
        ]);

        if ($ticketPrice === 0) {
            $this->settlePayment($payment, 'success', $request);

            return redirect()->route($this->successRouteName($request), [
                'slug' => $event->slug,
                'reference' => $paymentReference,
            ]);
        }

        $data = [
            'amount' => $ticketPrice * $quantity * 100,
            'email' => $validated['email'],
            'reference' => $paymentReference,
            'currency' => $event->currency,
            'callback_url' => $request->getSchemeAndHttpHost() . ($request->getHost() === 'events.thestellarsurge.com'
                ? route('events.payment.callback', absolute: false)
                : (str_starts_with($request->getRequestUri(), '/thestellarsurge/public') ? route('events.payment.callback.path', absolute: false) : route('events.payment.callback.local', absolute: false))),
            'metadata' => [
                'event_id' => $event->id,
                'ticket_ids' => $tickets->pluck('id')->all(),
                'ticket_references' => $ticketReferences,
                'quantity' => $quantity,
            ],
        ];

        if (config('services.paystack.mode') === 'demo' && ! app()->environment('production')) {
            $this->settlePayment($payment, 'success', $request);

            return redirect()->route($this->successRouteName($request), [
                'slug' => $event->slug,
                'reference' => $paymentReference,
            ]);
        }

        return Paystack::getAuthorizationUrl($data)->redirectNow();
    }

    public function callback(Request $request)
    {
        $reference = $request->query('reference');

        if (! $reference) {
            $indexRoute = request()->getHost() === 'events.thestellarsurge.com'
                ? 'events.index'
                : (str_starts_with(request()->getRequestUri(), '/thestellarsurge/public') ? 'events.index.path' : 'events.index.local');

            return redirect()->route($indexRoute)->with('error', 'Payment verification failed.');
        }

        $payment = Payment::query()->where('reference', $reference)->firstOrFail();
        $paymentData = Paystack::getPaymentData();

        $status = data_get($paymentData, 'data.status', 'failed');
        $this->settlePayment($payment, $status === 'success' ? 'success' : 'failed', $request);

        return redirect()->route($this->successRouteName($request), ['slug' => $payment->event?->slug ?? 'event', 'reference' => $reference]);
    }

    public function success(string $slug, Request $request)
    {
        $event = Event::query()->where('slug', $slug)->where('is_published', true)->firstOrFail();
        $reference = $request->query('reference');
        $payment = $reference ? Payment::query()->where('reference', $reference)->first() : null;

        $tickets = $payment
            ? Ticket::query()->whereIn('id', data_get($payment->metadata, 'ticket_ids', [$payment->ticket_id]))->get()
            : collect();

        return view('events.success', compact('event', 'payment', 'tickets'));
    }

    public function downloadTicket(string $slug, string $reference)
    {
        $event = Event::query()->where('slug', $slug)->where('is_published', true)->firstOrFail();
        $ticket = Ticket::query()->where('reference', $reference)->where('event_id', $event->id)->where('status', 'paid')->with('event')->firstOrFail();
        $security = app(TicketSecurityService::class);
        $payload = $security->payloadFor($ticket);
        $ticket->update([
            'qr_code' => $security->qrSvgFor($security->verificationUrlFor($payload, request()), 260),
        ]);

        return Pdf::loadView('events.ticket-pdf', ['tickets' => collect([$ticket])])
            ->download('stellar-surge-' . Str::lower($ticket->reference) . '.pdf');
    }

    public function verifyTicket(Request $request)
    {
        $token = (string) $request->query('token');
        $claims = $token ? app(TicketSecurityService::class)->verify($token) : null;
        $ticket = null;

        if ($claims && is_numeric($claims['ticket_id'] ?? null)) {
            $ticket = Ticket::query()->with('event')->find($claims['ticket_id']);
            if (! $ticket || $ticket->reference !== ($claims['reference'] ?? null) || $ticket->event_id !== ($claims['event_id'] ?? null)) {
                $ticket = null;
                $claims = null;
            }
        }

        return view('events.verify-ticket', compact('ticket', 'claims', 'token'));
    }

    public function confirmTicket(Request $request)
    {
        $token = (string) $request->input('token');
        $claims = $token ? app(TicketSecurityService::class)->verify($token) : null;
        $ticket = $claims && is_numeric($claims['ticket_id'] ?? null)
            ? Ticket::query()->with('event')->find($claims['ticket_id'])
            : null;

        if (! $ticket || $ticket->reference !== ($claims['reference'] ?? null) || $ticket->event_id !== ($claims['event_id'] ?? null) || $ticket->status !== 'paid') {
            return back()->with('verification_error', 'This ticket could not be verified.');
        }

        if (! $ticket->verified) {
            $ticket->update(['verified' => true]);
        }

        return redirect()->route($this->verificationRouteName($request), ['token' => $token]);
    }

    private function settlePayment(Payment $payment, string $status, Request $request): void
    {
        $wasSuccessful = $payment->status === 'success';
        $payment->update([
            'status' => $status,
            'paid_at' => $status === 'success' ? ($payment->paid_at ?: now()) : null,
        ]);

        $ticketIds = data_get($payment->metadata, 'ticket_ids', []);
        if ($ticketIds) {
            Ticket::query()->whereIn('id', $ticketIds)->update(['status' => $status === 'success' ? 'paid' : 'failed']);
        } elseif ($payment->ticket) {
            $payment->ticket()->update(['status' => $status === 'success' ? 'paid' : 'failed']);
        }

        if ($status !== 'success' || $wasSuccessful) {
            return;
        }

        $tickets = Ticket::query()
            ->whereIn('id', $ticketIds ?: [$payment->ticket_id])
            ->with('event')
            ->get();

        foreach ($tickets as $ticket) {
            $security = app(TicketSecurityService::class);
            $payload = $security->payloadFor($ticket);
            $ticket->update(['qr_code' => $security->qrSvgFor($security->verificationUrlFor($payload, $request), 260)]);
        }

        if ($tickets->isNotEmpty()) {
            Mail::to($tickets->first()->email)->send(new TicketIssued($tickets));

            foreach ($tickets as $ticket) {
                app(TicketDeliveryService::class)->sendWhatsApp($ticket);
            }
        }
    }

    private function successRouteName(Request $request): string
    {
        return $request->getHost() === 'events.thestellarsurge.com'
            ? 'events.success'
            : (str_starts_with($request->getRequestUri(), '/thestellarsurge/public') ? 'events.success.path' : 'events.success.local');
    }

    private function verificationRouteName(Request $request): string
    {
        return $request->getHost() === 'events.thestellarsurge.com'
            ? 'events.ticket.verify'
            : (str_starts_with($request->getRequestUri(), '/thestellarsurge/public') ? 'events.ticket.verify.path' : 'events.ticket.verify.local');
    }
}
