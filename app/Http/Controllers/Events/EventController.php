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

        return view('events.index', compact('events'));
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
        ]);

        $quantity = (int) $validated['quantity'];
        $tickets = collect();
        $ticketReferences = [];

        DB::transaction(function () use (&$tickets, &$ticketReferences, $event, $request, $validated, $quantity): void {
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
                    'ticket_type' => 'standard',
                    'amount' => $event->price,
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
            'amount' => $event->price * $quantity,
            'currency' => $event->currency,
            'status' => 'pending',
            'gateway' => 'paystack',
            'metadata' => [
                'event_slug' => $event->slug,
                'ticket_references' => $ticketReferences,
                'customer_email' => $validated['email'],
                'quantity' => $quantity,
            ],
        ]);

        $data = [
            'amount' => $event->price * $quantity * 100,
            'email' => $validated['email'],
            'reference' => $paymentReference,
            'currency' => $event->currency,
            'callback_url' => $request->getSchemeAndHttpHost() . ($request->getHost() === 'events.thestellarsurge.com' ? route('events.payment.callback', absolute: false) : route('events.payment.callback.local', absolute: false)),
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
            return redirect()->route('events.index.local')->with('error', 'Payment verification failed.');
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

        return redirect()->route('events.success.local', ['slug' => $payment->event?->slug ?? 'event', 'reference' => $reference]);
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
