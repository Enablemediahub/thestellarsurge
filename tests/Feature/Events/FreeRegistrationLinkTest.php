<?php

namespace Tests\Feature\Events;

use App\Filament\Resources\EventResource\Pages\EditEvent;
use App\Filament\Resources\EventResource\Pages\ListEvents;
use App\Mail\TicketIssued;
use App\Models\Event;
use App\Models\FreeRegistrationLink;
use App\Models\Payment;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Mail\PendingMail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Symfony\Component\Mailer\Exception\TransportException;
use Tests\TestCase;

class FreeRegistrationLinkTest extends TestCase
{
    use RefreshDatabase;

    public function test_active_link_registers_complimentary_tickets_and_uses_its_limit(): void
    {
        Mail::fake();
        [$event, $link, $token] = $this->makeEventAndLink(registrationLimit: 2);

        $this->get('/events/'.$event->slug.'/checkout?free_access='.$token)
            ->assertOk()
            ->assertSee('Complimentary registration link')
            ->assertSee('name="free_access"', false)
            ->assertSee('Complimentary')
            ->assertSee('<meta property="og:title" content="'.$event->title.'">', false)
            ->assertSee('<meta property="og:image" content="https://example.com/test-event-flyer.jpg">', false)
            ->assertSee('<meta name="twitter:image" content="https://example.com/test-event-flyer.jpg">', false);

        $response = $this->post('/events/'.$event->slug.'/checkout', [
            'name' => 'Special Guest',
            'email' => 'guest@example.com',
            'phone' => '+233240000000',
            'whatsapp_confirmed' => '1',
            'quantity' => 2,
            'ticket_type' => 'standard',
            'free_access' => $token,
        ]);

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
        $this->assertSame(2, $link->fresh()->registrations_used);
        $this->assertSame(2, Ticket::query()->where('free_registration_link_id', $link->id)->where('status', 'paid')->count());
        $payment = Payment::query()->firstOrFail();
        $this->assertSame(0, $payment->amount);
        $this->assertSame('success', $payment->status);
        $this->assertSame('complimentary', $payment->gateway);
        Mail::assertSent(TicketIssued::class, fn (TicketIssued $mail): bool => $mail->hasTo('guest@example.com')
            && $mail->tickets->count() === 2);
    }

    public function test_paid_purchase_emails_the_ticket_bundle_to_the_customer(): void
    {
        Mail::fake();
        config()->set('services.paystack.mode', 'demo');
        $event = $this->makeEvent();

        $response = $this->post('/events/'.$event->slug.'/checkout', [
            'name' => 'Ticket Buyer',
            'email' => 'buyer@example.com',
            'phone' => '+233240000000',
            'whatsapp_confirmed' => '1',
            'quantity' => 2,
            'ticket_type' => 'standard',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
        $this->assertSame(2, Ticket::query()->where('status', 'paid')->count());
        Mail::assertSent(TicketIssued::class, fn (TicketIssued $mail): bool => $mail->hasTo('buyer@example.com')
            && $mail->tickets->count() === 2);
    }

    public function test_failed_ticket_email_does_not_undo_a_confirmed_free_registration(): void
    {
        Log::shouldReceive('error')
            ->once()
            ->with('Ticket confirmation email delivery failed.', \Mockery::type('array'));
        $pendingMail = \Mockery::mock(PendingMail::class);
        $pendingMail->shouldReceive('send')
            ->once()
            ->with(\Mockery::type(TicketIssued::class))
            ->andThrow(new TransportException('SMTP unavailable.'));
        Mail::shouldReceive('to')->once()->with('guest@example.com')->andReturn($pendingMail);
        [$event, , $token] = $this->makeEventAndLink(registrationLimit: 1);

        $response = $this->post('/events/'.$event->slug.'/checkout', [
            'name' => 'Special Guest',
            'email' => 'guest@example.com',
            'phone' => '+233240000000',
            'whatsapp_confirmed' => '1',
            'quantity' => 1,
            'ticket_type' => 'standard',
            'free_access' => $token,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('ticket_email_failed', true);
        $this->assertDatabaseHas('tickets', [
            'email' => 'guest@example.com',
            'status' => 'paid',
        ]);

        $this->get($response->headers->get('Location'))
            ->assertOk()
            ->assertSee('we could not deliver the ticket email');
    }

    public function test_link_cannot_issue_more_tickets_than_its_remaining_limit(): void
    {
        Mail::fake();
        [$event, $link, $token] = $this->makeEventAndLink(registrationLimit: 1);

        $response = $this->from('/events/'.$event->slug.'/checkout?free_access='.$token)
            ->post('/events/'.$event->slug.'/checkout', [
                'name' => 'Special Guest',
                'email' => 'guest@example.com',
                'phone' => '+233240000000',
                'whatsapp_confirmed' => '1',
                'quantity' => 2,
                'ticket_type' => 'standard',
                'free_access' => $token,
            ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors('quantity');
        $this->assertSame(0, $link->fresh()->registrations_used);
        $this->assertDatabaseCount('tickets', 0);
        $this->assertDatabaseCount('payments', 0);
        Mail::assertNothingSent();
    }

    public function test_expired_and_exhausted_links_are_rejected(): void
    {
        [$event, , $expiredToken] = $this->makeEventAndLink(
            registrationLimit: 1,
            expiresAt: now()->subSecond(),
        );
        $this->get('/events/'.$event->slug.'/checkout?free_access='.$expiredToken)
            ->assertGone();

        [$event, , $exhaustedToken] = $this->makeEventAndLink(
            registrationLimit: 1,
            registrationsUsed: 1,
        );
        $this->get('/events/'.$event->slug.'/checkout?free_access='.$exhaustedToken)
            ->assertGone();
    }

    public function test_invalid_link_tokens_are_rejected(): void
    {
        $event = $this->makeEvent();

        $this->get('/events/'.$event->slug.'/checkout?free_access=invalid-token')
            ->assertGone();
    }

    public function test_admin_can_generate_a_link_with_a_custom_limit_and_one_day_expiry(): void
    {
        $admin = User::factory()->create();
        $event = $this->makeEvent();

        $this->actingAs($admin);

        Livewire::test(EditEvent::class, [
            'record' => $event->getRouteKey(),
        ])
            ->assertActionExists('generateFreeRegistrationLink')
            ->callAction('generateFreeRegistrationLink', data: [
                'group_name' => 'Speakers',
                'registration_limit' => 3,
                'expiry_days' => 5,
            ])
            ->assertNotified('Complimentary link created for Speakers');

        $link = FreeRegistrationLink::query()->where('event_id', $event->id)->firstOrFail();
        $this->assertSame('Speakers', $link->group_name);
        $this->assertSame(3, $link->registration_limit);
        $this->assertSame($admin->id, $link->created_by);
        $this->assertTrue($link->expires_at->between(now()->addDays(5)->subMinute(), now()->addDays(5)->addMinute()));
        $encryptedToken = DB::table('free_registration_links')->where('id', $link->id)->value('encrypted_token');
        $token = Crypt::decryptString($encryptedToken);
        $this->assertSame(hash('sha256', $token), $link->token_hash);

        $url = route('events.checkout.local', [
            'slug' => $event->slug,
            'free_access' => $token,
        ]);

        Livewire::test(ListEvents::class)
            ->assertSee($url);

        $this->get($url)->assertOk();
    }

    private function makeEventAndLink(
        int $registrationLimit,
        int $registrationsUsed = 0,
        mixed $expiresAt = null,
    ): array {
        $event = $this->makeEvent();
        $token = Str::random(64);
        $link = FreeRegistrationLink::create([
            'event_id' => $event->id,
            'token_hash' => hash('sha256', $token),
            'registration_limit' => $registrationLimit,
            'registrations_used' => $registrationsUsed,
            'expires_at' => $expiresAt ?? now()->addDay(),
        ]);

        return [$event, $link, $token];
    }

    private function makeEvent(): Event
    {
        return Event::create([
            'title' => 'Test Event',
            'slug' => 'test-event-'.Str::lower(Str::random(6)),
            'start_at' => now()->addWeek(),
            'location' => 'Accra',
            'price' => 100,
            'currency' => 'GHS',
            'banner_image' => 'https://example.com/test-event-flyer.jpg',
            'ticket_options' => [
                ['name' => 'Standard', 'slug' => 'standard', 'price' => 100],
            ],
            'is_published' => true,
        ]);
    }
}
