@extends('layouts.app')

@section('content')
    @php($siteSettings = \App\Models\SiteSetting::current())
    <div class="section-shell py-20">
        <h1 class="text-5xl text-plum">Contact Stellar Surge</h1>
        <p class="mt-6 max-w-3xl text-lg text-charcoal/80">We would love to hear from you. Reach out at <a href="mailto:{{ $siteSettings->contact_email ?: 'hello@thestellarsurge.com' }}" class="font-semibold text-plum underline">{{ $siteSettings->contact_email ?: 'hello@thestellarsurge.com' }}</a> to collaborate, partner, or explore opportunities.</p>
    </div>
@endsection
