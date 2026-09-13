<?php

namespace App\Http\Controllers\Events;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Payment;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Unicodeveloper\Paystack\Facades\Paystack;

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
        ]);

        $ticketReference = 'TCK-' . strtoupper(Str::random(12));
        $ticket = Ticket::create([
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
        ]);

        $paymentReference = 'SS-' . strtoupper(Str::random(12));
        $payment = Payment::create([
            'event_id' => $event->id,
            'ticket_id' => $ticket->id,
            'user_id' => $request->user()?->id,
            'reference' => $paymentReference,
            'amount' => $event->price,
            'currency' => $event->currency,
            'status' => 'pending',
            'gateway' => 'paystack',
            'metadata' => [
                'event_slug' => $event->slug,
                'ticket_reference' => $ticketReference,
                'customer_email' => $validated['email'],
            ],
        ]);

        $data = [
            'amount' => $event->price * 100,
            'email' => $validated['email'],
            'reference' => $paymentReference,
            'currency' => $event->currency,
            'callback_url' => route('events.payment.callback.local', absolute: false),
            'metadata' => [
                'event_id' => $event->id,
                'ticket_id' => $ticket->id,
                'ticket_reference' => $ticketReference,
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

        if ($payment->ticket) {
            $payment->ticket()->update([
                'status' => $status === 'success' ? 'paid' : 'failed',
            ]);
        }

        return redirect()->route('events.success.local', ['slug' => $payment->event?->slug ?? 'event', 'reference' => $reference]);
    }

    public function success(string $slug, Request $request)
    {
        $event = Event::query()->where('slug', $slug)->where('is_published', true)->firstOrFail();
        $reference = $request->query('reference');
        $payment = $reference ? Payment::query()->where('reference', $reference)->first() : null;

        return view('events.success', compact('event', 'payment'));
    }
}
