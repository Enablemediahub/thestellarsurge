<?php

namespace Tests\Feature\Events;

use App\Models\Event;
use App\Models\EventDiscountLink;
use App\Models\Payment;
use App\Models\Ticket;
use App\Services\EventDiscountLinkService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class EventDiscountLinkTest extends TestCase
{
    use RefreshDatabase;

    public function test_private_discount_is_hidden_from_public_and_applied_only_with_a_valid_link(): void
    {
        config(['services.paystack.mode' => 'demo']);
        Mail::fake();

        $event = Event::create([
            'title' => 'Private Discount Event',
            'slug' => 'private-discount-event',
            'start_at' => '2026-11-20 18:00:00',
            'location' => 'Accra',
            'is_published' => true,
            'discount_mode' => 'link',
            'price' => 600,
            'discount_price' => 500,
            'link_discount_price' => 450,
            'ticket_options' => [
                ['name' => 'Regular', 'price' => 500, 'discount_price' => 400, 'link_discount_price' => 350],
                ['name' => 'VIP', 'price' => 900, 'discount_price' => 800, 'link_discount_price' => 700],
            ],
            'currency' => 'GHS',
        ]);
        ['link' => $link, 'token' => $token] = app(EventDiscountLinkService::class)->create(
            $event,
            'Invited guests',
            2,
            null,
        );

        $this->get('/events')
            ->assertOk()
            ->assertSee('Regular')
            ->assertSee('500 GHS')
            ->assertDontSee('350 GHS')
            ->assertDontSee('Was 500 GHS');

        $this->get('/events/'.$event->slug.'/checkout')
            ->assertOk()
            ->assertSee('data-price="500"', false)
            ->assertDontSee('discount_access');

        $this->get('/events/'.$event->slug.'/checkout?discount_access='.$token)
            ->assertOk()
            ->assertSee('Private discount applied.')
            ->assertSee('Was 500 GHS, now 350 GHS')
            ->assertSee('name="discount_access"', false)
            ->assertSee('data-price="350"', false);

        $this->post('/events/'.$event->slug.'/checkout', [
            'name' => 'Public Buyer',
            'email' => 'public@example.com',
            'phone' => '+233240000000',
            'whatsapp_confirmed' => 1,
            'quantity' => 1,
            'ticket_type' => 'regular',
        ]);
        $this->assertDatabaseHas('tickets', [
            'email' => 'public@example.com',
            'amount' => 500,
        ]);

        $response = $this->post('/events/'.$event->slug.'/checkout', [
            'name' => 'Invited Buyer',
            'email' => 'invited@example.com',
            'phone' => '+233240000000',
            'whatsapp_confirmed' => 1,
            'quantity' => 1,
            'ticket_type' => 'regular',
            'discount_access' => $token,
        ]);

        $payment = Payment::query()->where('event_id', $event->id)->latest('id')->firstOrFail();
        $ticket = Ticket::query()->where('event_id', $event->id)->latest('id')->firstOrFail();

        $this->assertSame(350, $payment->amount);
        $this->assertSame(350, $ticket->amount);
        $this->assertSame(1, $link->fresh()->usage_count);
        $response->assertRedirect(route('events.success.local', ['slug' => $event->slug, 'reference' => $payment->reference]));

        $this->post('/events/'.$event->slug.'/checkout', [
            'name' => 'Second Buyer',
            'email' => 'second@example.com',
            'phone' => '+233240000000',
            'whatsapp_confirmed' => 1,
            'quantity' => 2,
            'ticket_type' => 'regular',
            'discount_access' => $token,
        ])->assertSessionHasErrors('quantity');

        $this->assertSame(1, $link->fresh()->usage_count);
        $this->get('/events/'.$event->slug.'/checkout?discount_access=invalid-token')->assertGone();
    }

    public function test_general_discount_mode_is_public_and_no_discount_mode_uses_full_price(): void
    {
        $event = Event::create([
            'title' => 'Discount Mode Event',
            'slug' => 'discount-mode-event',
            'start_at' => '2026-11-20 18:00:00',
            'location' => 'Accra',
            'is_published' => true,
            'discount_mode' => 'general',
            'price' => 300,
            'discount_price' => 250,
            'link_discount_price' => 200,
            'currency' => 'GHS',
        ]);

        $this->get('/events/'.$event->slug)
            ->assertOk()
            ->assertSee('<del class="block text-charcoal/50">300 GHS</del>', false)
            ->assertSee('<strong class="text-[#d36d6d]">250 GHS</strong>', false)
            ->assertDontSee('200 GHS');

        $event->update(['discount_mode' => 'none']);

        $this->get('/events/'.$event->slug)
            ->assertOk()
            ->assertSee('300 GHS')
            ->assertDontSee('250 GHS')
            ->assertDontSee('200 GHS');
    }
}
