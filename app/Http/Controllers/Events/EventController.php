<?php

namespace App\Http\Controllers\Events;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Payment;
use App\Models\Ticket;
use App\Mail\TicketIssued;
use App\Services\TicketDeliveryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Unicodeveloper\Paystack\Facades\Paystack;
use Barryvdh\DomPDF\Facade\Pdf;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::query()
            ->where('is_published', true)
            ->orderBy('start_at', 'asc')
            ->get();

        $featuredEvents = $events->where('featured', true)->values();
        $featuredEvent = $featuredEvents->first();
        $regularEvents = $events;

        return view('events.index', compact('events', 'featuredEvents', 'featuredEvent', 'regularEvents'));
    }

    public function show(string $slug)
    {
        $event = Event::query()
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        return view('events.show', compact('event'));
    }

    public function checkout(string $slug)
    {
        $event = Event::query()
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        return view('events.checkout', compact('event'));
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
            'phone' => ['nullable', 'string', 'max:50'],
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
                    'phone' => $validated['phone'] ?? null,
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
            'gateway' => 'paystack',
            'metadata' => [
                'event_slug' => $event->slug,
                'ticket_references' => $ticketReferences,
                'customer_email' => $validated['email'],
                'quantity' => $quantity,
                'ticket_type' => $ticketOption['slug'],
                'ticket_type_name' => $ticketOption['name'],
            ],
        ]);

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
        $payment->update([
            'status' => $status === 'success' ? 'success' : 'failed',
            'paid_at' => $status === 'success' ? now() : null,
        ]);

        $ticketIds = data_get($payment->metadata, 'ticket_ids', []);
        if ($ticketIds) {
            Ticket::query()->whereIn('id', $ticketIds)->update([
                'status' => $status === 'success' ? 'paid' : 'failed',
            ]);
        } elseif ($payment->ticket) {
            $payment->ticket()->update(['status' => $status === 'success' ? 'paid' : 'failed']);
        }

        if ($status === 'success') {
            $tickets = Ticket::query()
                ->whereIn('id', $ticketIds ?: [$payment->ticket_id])
                ->with('event')
                ->get();

            foreach ($tickets as $ticket) {
                $ticket->update([
                    'qr_code' => base64_encode(QrCode::format('svg')->size(260)->generate($ticket->reference)),
                ]);
            }

            if ($tickets->isNotEmpty()) {
                Mail::to($tickets->first()->email)->send(new TicketIssued($tickets));

                foreach ($tickets as $ticket) {
                    app(TicketDeliveryService::class)->sendWhatsApp($ticket);
                }
            }
        }

        $successRoute = request()->getHost() === 'events.thestellarsurge.com'
            ? 'events.success'
            : (str_starts_with(request()->getRequestUri(), '/thestellarsurge/public') ? 'events.success.path' : 'events.success.local');

        return redirect()->route($successRoute, ['slug' => $payment->event?->slug ?? 'event', 'reference' => $reference]);
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

        return Pdf::loadView('events.ticket-pdf', ['tickets' => collect([$ticket])])
            ->download('stellar-surge-' . Str::lower($ticket->reference) . '.pdf');
    }
}
