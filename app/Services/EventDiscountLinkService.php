<?php

namespace App\Services;

use App\Models\Event;
use App\Models\EventDiscountLink;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class EventDiscountLinkService
{
    /**
     * @return array{link: EventDiscountLink, token: string}
     */
    public function create(Event $event, string $label, ?int $usageLimit, ?string $expiresAt): array
    {
        $token = Str::random(64);
        $link = EventDiscountLink::create([
            'event_id' => $event->id,
            'created_by' => auth()->id(),
            'label' => $label,
            'token_hash' => hash('sha256', $token),
            'encrypted_token' => Crypt::encryptString($token),
            'usage_limit' => $usageLimit,
            'usage_count' => 0,
            'expires_at' => $expiresAt,
        ]);

        return ['link' => $link, 'token' => $token];
    }

    public function checkoutUrl(Event $event, string $token): string
    {
        $routeName = app()->environment(['local', 'testing'])
            ? 'events.checkout.local'
            : 'events.checkout';

        return route($routeName, [
            'slug' => $event->slug,
            'discount_access' => $token,
        ]);
    }

    public function checkoutUrlForLink(EventDiscountLink $link): ?string
    {
        $encryptedToken = $link->getRawOriginal('encrypted_token');

        if (! $encryptedToken) {
            return null;
        }

        try {
            $token = Crypt::decryptString($encryptedToken);
        } catch (DecryptException) {
            return null;
        }

        return $this->checkoutUrl($link->event, $token);
    }
}
