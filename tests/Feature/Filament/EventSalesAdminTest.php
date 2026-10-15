<?php

namespace Tests\Feature\Filament;

use App\Filament\Resources\EventResource\Pages\ListEvents;
use App\Filament\Resources\FreeRegistrationLinkResource\Pages\EditFreeRegistrationLink;
use App\Filament\Resources\FreeRegistrationLinkResource\Pages\ListFreeRegistrationLinks;
use App\Filament\Resources\PaymentResource\Pages\ListPayments;
use App\Filament\Resources\TicketResource;
use App\Filament\Resources\TicketResource\Pages\ListTickets;
use App\Models\Event;
use App\Models\FreeRegistrationLink;
use App\Models\Payment;
use App\Models\Ticket;
use App\Models\User;
use App\Services\FreeRegistrationLinkService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Tests\TestCase;

class EventSalesAdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_sales_tables_show_customer_and_ticket_category(): void
    {
        $admin = User::factory()->create();
        $event = $this->makeEvent();
        $ticket = Ticket::create([
            'event_id' => $event->id,
            'reference' => 'TCK-'.strtoupper(Str::random(12)),
            'email' => 'couple@example.com',
            'name' => 'Guest Couple',
            'ticket_type' => 'couple',
            'amount' => 150,
            'currency' => 'GHS',
            'status' => 'paid',
        ]);
        Payment::create([
            'event_id' => $event->id,
            'ticket_id' => $ticket->id,
            'reference' => 'SS-'.strtoupper(Str::random(12)),
            'amount' => 150,
            'currency' => 'GHS',
            'status' => 'success',
            'gateway' => 'paystack',
            'metadata' => [
                'customer_email' => $ticket->email,
                'ticket_type_name' => 'Couple',
                'quantity' => 1,
            ],
        ]);

        $this->actingAs($admin);

        Livewire::test(ListTickets::class)
            ->assertSee('Guest Couple')
            ->assertSee('Couple');

        Livewire::test(ListPayments::class)
            ->assertSee('Guest Couple')
            ->assertSee('couple@example.com')
            ->assertSee('Couple')
            ->assertSee('1');
    }

    public function test_ticket_rows_have_individual_whatsapp_and_delete_actions_with_bulk_delete(): void
    {
        $admin = User::factory()->create();
        $event = $this->makeEvent();
        $ticket = Ticket::create([
            'event_id' => $event->id,
            'reference' => 'TCK-'.strtoupper(Str::random(12)),
            'email' => 'whatsapp@example.com',
            'name' => 'WhatsApp Guest',
            'phone' => '+233240000000',
            'whatsapp_confirmed' => true,
            'ticket_type' => 'single',
            'amount' => 100,
            'currency' => 'GHS',
            'status' => 'paid',
        ]);
        $this->actingAs($admin);

        $expectedUrl = 'https://wa.me/233240000000?text='.rawurlencode(
            'Hello WhatsApp Guest, your ticket for Ticket Categories is confirmed. Reference: '
            .$ticket->reference
            .'. Please keep your PDF ticket and QR code ready for the event.',
        );

        $this->assertSame($expectedUrl, TicketResource::whatsappUrl($ticket->load('event')));

        Livewire::test(ListTickets::class)
            ->assertTableActionExists('sendWhatsApp', record: $ticket)
            ->assertTableActionExists('delete', record: $ticket)
            ->assertTableBulkActionExists('delete')
            ->assertTableBulkActionDoesNotExist('sendWhatsApp');
    }

    public function test_event_list_handles_a_link_encrypted_with_an_unavailable_key(): void
    {
        $admin = User::factory()->create();
        $event = $this->makeEvent();
        $link = FreeRegistrationLink::create([
            'event_id' => $event->id,
            'token_hash' => hash('sha256', Str::random(64)),
            'encrypted_token' => Str::random(64),
            'registration_limit' => 1,
            'expires_at' => now()->addDay(),
        ]);
        DB::table('free_registration_links')
            ->where('id', $link->id)
            ->update(['encrypted_token' => 'ciphertext-from-an-unavailable-key']);

        $this->actingAs($admin);

        Livewire::test(ListEvents::class)
            ->assertDontSee('Active complimentary link');

        Livewire::test(ListFreeRegistrationLinks::class)
            ->assertSee('Link unavailable; generate a new one');

        Livewire::test(EditFreeRegistrationLink::class, ['record' => $link->getRouteKey()])
            ->assertFormSet([
                'group_name' => 'General',
                'registration_limit' => 1,
            ]);
    }

    public function test_admin_can_create_and_manage_named_complimentary_links(): void
    {
        $admin = User::factory()->create();
        $event = $this->makeEvent();
        $this->actingAs($admin);

        Livewire::test(ListFreeRegistrationLinks::class)
            ->assertActionExists('createLink')
            ->callAction('createLink', data: [
                'event_id' => $event->id,
                'group_name' => 'Partner organizations',
                'registration_limit' => 12,
                'expiry_days' => 14,
            ])
            ->assertNotified('Complimentary link created for Partner organizations');

        $link = FreeRegistrationLink::query()->where('event_id', $event->id)->firstOrFail();
        $this->assertSame('Partner organizations', $link->group_name);
        $this->assertSame(12, $link->registration_limit);
        $this->assertSame($admin->id, $link->created_by);
        $this->assertTrue($link->expires_at->between(now()->addDays(14)->subMinute(), now()->addDays(14)->addMinute()));
        URL::forceRootUrl('http://127.0.0.1:8000');
        $token = Crypt::decryptString(DB::table('free_registration_links')->where('id', $link->id)->value('encrypted_token'));
        $url = app(FreeRegistrationLinkService::class)->checkoutUrl($event, $token);
        $this->assertSame('127.0.0.1', parse_url($url, PHP_URL_HOST));
        $this->assertSame('/events/'.$event->slug.'/checkout', parse_url($url, PHP_URL_PATH));

        Livewire::test(ListFreeRegistrationLinks::class)
            ->assertSee('Partner organizations')
            ->assertSee($url)
            ->assertSee('14')
            ->assertTableActionExists('generateNextGeneration', record: $link);

        $this->get($url)->assertOk()->assertSee('Complimentary registration link');

        Livewire::test(ListFreeRegistrationLinks::class)
            ->callTableAction('generateNextGeneration', $link, data: [
                'registration_limit' => 5,
                'expiry_days' => 7,
            ])
            ->assertNotified('Generation 2 created for Partner organizations');

        $generation = FreeRegistrationLink::query()->where('root_link_id', $link->id)->firstOrFail();
        $this->assertSame(2, $generation->generation);
        $this->assertSame($link->event_id, $generation->event_id);
        $this->assertSame($link->group_name, $generation->group_name);
        $this->assertSame(5, $generation->registration_limit);
        $this->assertSame($admin->id, $generation->created_by);
        $this->assertTrue($generation->expires_at->between(now()->addDays(7)->subMinute(), now()->addDays(7)->addMinute()));

        Livewire::test(ListFreeRegistrationLinks::class)
            ->assertSee('Generation 1')
            ->assertSee('Generation 2')
            ->assertSee('Partner organizations');
    }

    private function makeEvent(): Event
    {
        return Event::create([
            'title' => 'Ticket Categories',
            'slug' => 'ticket-categories-'.Str::lower(Str::random(6)),
            'start_at' => now()->addWeek(),
            'location' => 'Accra',
            'price' => 150,
            'currency' => 'GHS',
            'ticket_options' => [
                ['name' => 'Single', 'slug' => 'single', 'price' => 100],
                ['name' => 'Couple', 'slug' => 'couple', 'price' => 150],
            ],
            'is_published' => true,
        ]);
    }
}
