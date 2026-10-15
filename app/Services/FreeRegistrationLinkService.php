<?php

namespace App\Services;

use App\Models\Event;
use App\Models\FreeRegistrationLink;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FreeRegistrationLinkService
{
    /**
     * @return array{link: FreeRegistrationLink, token: string}
     */
    public function create(Event $event, string $groupName, int $registrationLimit, int $expiryDays): array
    {
        return $this->createLink($event, $groupName, $registrationLimit, $expiryDays);
    }

    /**
     * @return array{link: FreeRegistrationLink, token: string}
     */
    public function createNextGeneration(FreeRegistrationLink $source, int $registrationLimit, int $expiryDays): array
    {
        return DB::transaction(function () use ($source, $registrationLimit, $expiryDays): array {
            $rootId = $source->root_link_id ?? $source->id;
            $root = FreeRegistrationLink::query()->whereKey($rootId)->lockForUpdate()->firstOrFail();
            $generation = FreeRegistrationLink::query()
                ->where(fn ($query) => $query->whereKey($rootId)->orWhere('root_link_id', $rootId))
                ->max('generation') + 1;

            return $this->createLink(
                $root->event,
                $root->group_name,
                $registrationLimit,
                $expiryDays,
                $rootId,
                $generation,
            );
        });
    }

    /**
     * @return array{link: FreeRegistrationLink, token: string}
     */
    private function createLink(
        Event $event,
        string $groupName,
        int $registrationLimit,
        int $expiryDays,
        ?int $rootLinkId = null,
        int $generation = 1,
    ): array {
        $token = Str::random(64);
        $link = FreeRegistrationLink::create([
            'event_id' => $event->id,
            'created_by' => auth()->id(),
            'group_name' => $groupName,
            'root_link_id' => $rootLinkId,
            'generation' => $generation,
            'token_hash' => hash('sha256', $token),
            'encrypted_token' => Crypt::encryptString($token),
            'registration_limit' => $registrationLimit,
            'expires_at' => now()->addDays($expiryDays),
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
            'free_access' => $token,
        ]);
    }

    public function checkoutUrlForLink(FreeRegistrationLink $link): ?string
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
