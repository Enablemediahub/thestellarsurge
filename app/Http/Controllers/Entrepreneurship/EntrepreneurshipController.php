<?php

namespace App\Http\Controllers\Entrepreneurship;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventPlanningRequest;
use App\Models\SiteSetting;
use App\Services\LeadNotificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EntrepreneurshipController extends Controller
{
    public function index()
    {
        return view('entrepreneurship.index', ['siteSettings' => SiteSetting::current()]);
    }

    public function gallery()
    {
        $events = Event::query()
            ->where('is_published', true)
            ->whereHas('galleryItems', fn ($query) => $query->where('is_published', true))
            ->with(['galleryItems' => fn ($query) => $query->where('is_published', true)->orderBy('sort_order')])
            ->orderByDesc('start_at')
            ->get();

        return view('entrepreneurship.gallery', ['events' => $events, 'siteSettings' => SiteSetting::current()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'event_type' => ['required', 'string', 'max:100'],
            'consultation_preference' => ['required', 'in:in_person,online'],
            'event_date' => ['nullable', 'date'],
            'guest_count' => ['nullable', 'integer', 'min:1', 'max:100000'],
            'budget' => ['nullable', 'string', 'max:100'],
            'message' => ['required', 'string', 'min:10', 'max:3000'],
        ]);

        EventPlanningRequest::create($validated);
        app(LeadNotificationService::class)->notify('event planning request', [
            'Name' => $validated['name'],
            'Email' => $validated['email'],
            'Phone' => $validated['phone'] ?? null,
            'Event type' => $validated['event_type'],
            'Meeting preference' => $validated['consultation_preference'] === 'in_person' ? 'In-person' : 'Online',
            'Preferred date' => $validated['event_date'] ?? null,
            'Expected guests' => $validated['guest_count'] ?? null,
            'Estimated budget' => $validated['budget'] ?? null,
            'Message' => $validated['message'],
        ]);

        $redirectUrl = str_starts_with($request->getRequestUri(), '/thestellarsurge/public')
            ? url('/thestellarsurge/public/event_planning')
            : route('event_planning.index.local');

        return redirect($redirectUrl)->with('event_planning_status', 'Thank you. Our event planning team will be in touch shortly.');
    }
}
