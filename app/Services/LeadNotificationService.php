<?php

namespace App\Services;

use App\Mail\LeadReceived;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;
use Twilio\Rest\Client;

class LeadNotificationService
{
    public function notify(string $leadType, array $details): void
    {
        $settings = SiteSetting::current();
        $email = config('services.lead_notifications.email') ?: $settings->contact_email;
        $whatsapp = config('services.lead_notifications.whatsapp') ?: $settings->whatsapp_number;

        if ($email) {
            try {
                Mail::to($email)->send(new LeadReceived($leadType, $details));
            } catch (Throwable $exception) {
                Log::error('Lead email notification failed.', [
                    'lead_type' => $leadType,
                    'recipient' => $email,
                    'error' => $exception->getMessage(),
                ]);
            }
        }

        $sid = config('services.twilio.sid');
        $token = config('services.twilio.token');
        $from = config('services.twilio.whatsapp_from');

        if (! $sid || ! $token || ! $from || ! $whatsapp) {
            return;
        }

        try {
            $message = collect($details)
                ->map(fn ($value, $label): string => $label . ': ' . ($value ?: 'Not provided'))
                ->prepend('New Stellar Surge ' . $leadType)
                ->implode("\n");

            $to = str_starts_with($whatsapp, 'whatsapp:') ? $whatsapp : 'whatsapp:' . $whatsapp;
            (new Client($sid, $token))->messages->create($to, [
                'from' => $from,
                'body' => $message,
            ]);
        } catch (Throwable $exception) {
            Log::error('Lead WhatsApp notification failed.', [
                'lead_type' => $leadType,
                'recipient' => $whatsapp,
                'error' => $exception->getMessage(),
            ]);
        }
    }
}