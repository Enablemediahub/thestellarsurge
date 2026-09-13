<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\SiteSetting;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function index()
    {
        $featuredEvents = Event::query()
            ->where('is_published', true)
            ->where('featured', true)
            ->orderBy('start_at', 'asc')
            ->limit(3)
            ->get();

        $siteSettings = SiteSetting::current();
        $testimonial = Testimonial::query()
            ->where('is_approved', true)
            ->orderBy('sort_order')
            ->latest()
            ->first();

        return view('main.home', compact('featuredEvents', 'siteSettings', 'testimonial'));
    }
}
