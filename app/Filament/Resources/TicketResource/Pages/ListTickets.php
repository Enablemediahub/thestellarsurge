<?php

namespace App\Filament\Resources\TicketResource\Pages;

use App\Filament\Resources\TicketResource;
use App\Filament\Widgets\TicketMetrics;
use App\Models\SiteSetting;
use Filament\Actions;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListTickets extends ListRecords
{
    protected static string $resource = TicketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('ticketScannerSettings')
                ->label('Ticket scanner portal')
                ->icon('heroicon-o-qr-code')
                ->modalHeading('Ticket scanner portal settings')
                ->form([
                    Forms\Components\Toggle::make('ticket_scanner_enabled')
                        ->label('Enable ticket scanner portal')
                        ->helperText('Allows ushers to open the phone camera scanner at /events/tickets/.'),
                    Forms\Components\TextInput::make('ticket_scanner_url')
                        ->label('Ticket scanner portal URL')
                        ->readOnly()
                        ->extraInputAttributes(['onclick' => 'this.select()'])
                        ->dehydrated(false)
                        ->helperText('Copy this URL into WhatsApp or send it directly to the ushers.'),
                ])
                ->fillForm(fn (): array => [
                    'ticket_scanner_enabled' => SiteSetting::current()->ticket_scanner_enabled,
                    'ticket_scanner_url' => request()->getHost() === 'thestellarsurge.com'
                        ? 'https://events.thestellarsurge.com/tickets/'
                        : route('events.ticket.scanner.local'),
                ])
                ->action(function (array $data): void {
                    $settings = SiteSetting::query()->first() ?? new SiteSetting;
                    $settings->ticket_scanner_enabled = (bool) ($data['ticket_scanner_enabled'] ?? false);
                    $settings->save();

                    Notification::make()
                        ->title('Ticket scanner settings saved')
                        ->success()
                        ->send();
                }),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [TicketMetrics::class];
    }
}
