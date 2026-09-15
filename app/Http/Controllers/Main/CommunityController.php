<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use App\Models\Testimonial;
use App\Models\ConsultationRequest;
use App\Services\LeadNotificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CommunityController extends Controller
{
    public function testimonial(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'quote' => ['required', 'string', 'min:10', 'max:1000'],
            'author' => ['required', 'string', 'max:255'],
            'role' => ['nullable', 'string', 'max:255'],
        ]);

        Testimonial::create($validated + ['is_approved' => false]);

        return back()->with('testimonial_status', 'Thank you. Your testimonial is awaiting approval.');
    }

    public function subscribe(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'name' => ['nullable', 'string', 'max:255'],
        ]);

        Subscriber::updateOrCreate(
            ['email' => $validated['email']],
            ['name' => $validated['name'] ?? null, 'is_subscribed' => true, 'subscribed_at' => now()],
        );

        return back()->with('subscription_status', 'You are subscribed to Stellar Surge updates.');
    }

    public function consultation(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'event_type' => ['required', 'string', 'max:100'],
            'consultation_preference' => ['required', 'in:in_person,online'],
            'event_date' => ['nullable', 'date'],
            'guest_count' => ['nullable', 'integer', 'min:1', 'max:100000'],
            'message' => ['required', 'string', 'min:10', 'max:3000'],
        ]);

        ConsultationRequest::create($validated);
        app(LeadNotificationService::class)->notify('consultation request', [
            'Name' => $validated['name'],
            'Email' => $validated['email'],
            'Phone' => $validated['phone'] ?? null,
            'Event type' => $validated['event_type'],
            'Meeting preference' => $validated['consultation_preference'] === 'in_person' ? 'In-person' : 'Online',
            'Preferred date' => $validated['event_date'] ?? null,
            'Expected guests' => $validated['guest_count'] ?? null,
            'Message' => $validated['message'],
        ]);

        $redirectUrl = str_starts_with($request->getRequestUri(), '/thestellarsurge/public')
            ? url('/thestellarsurge/public/consultation')
            : route('consultation');

        return redirect($redirectUrl)->with('consultation_status', 'Thank you. Our team will be in touch about your consultation shortly.');
    }
}
