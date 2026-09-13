<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use App\Models\Testimonial;
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
}
