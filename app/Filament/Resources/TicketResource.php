<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketResource\Pages;
use App\Models\Event;
use App\Models\Ticket;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    protected static ?string $navigationGroup = 'Events';

    protected static ?string $navigationLabel = 'Tickets';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('reference')->disabled(),
            Forms\Components\Toggle::make('whatsapp_confirmed')->label('WhatsApp number confirmed'),
            Forms\Components\Toggle::make('verified')->label('Verified for entry'),
            Forms\Components\Select::make('status')->options([
                'pending' => 'Pending',
                'paid' => 'Paid',
                'failed' => 'Failed',
            ])->required(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query->with('event'))
            ->columns([
                Tables\Columns\TextColumn::make('reference')->searchable()->copyable(),
                Tables\Columns\TextColumn::make('event.title')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('email')->searchable(),
                Tables\Columns\TextColumn::make('ticket_type_name')
                    ->label('Ticket type')
                    ->searchable(query: fn ($query, string $search) => $query->where('ticket_type', 'like', "%{$search}%")),
                Tables\Columns\TextColumn::make('formatted_phone')
                    ->label('Phone')
                    ->searchable(query: fn ($query, string $search) => $query->where('phone', 'like', "%{$search}%"))
                    ->copyable(),
                Tables\Columns\IconColumn::make('whatsapp_confirmed')
                    ->label('WhatsApp')
                    ->boolean(),
                Tables\Columns\TextColumn::make('amount')->money(fn (Ticket $record) => $record->currency),
                Tables\Columns\BadgeColumn::make('status')->colors([
                    'warning' => 'pending',
                    'success' => 'paid',
                    'danger' => 'failed',
                ]),
                Tables\Columns\IconColumn::make('verified')->label('Verified')->boolean(),
                Tables\Columns\TextColumn::make('verified_at')->dateTime()->sortable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')->options([
                    'pending' => 'Pending',
                    'paid' => 'Paid',
                    'failed' => 'Failed',
                ]),
                Tables\Filters\SelectFilter::make('ticket_type')
                    ->label('Ticket type')
                    ->options(fn (): array => Event::query()
                        ->get()
                        ->flatMap(fn (Event $event) => $event->ticketOptions())
                        ->unique('slug')
                        ->mapWithKeys(fn (array $option): array => [$option['slug'] => $option['name']])
                        ->all()),
                Tables\Filters\TernaryFilter::make('whatsapp_confirmed')->label('WhatsApp confirmed'),
                Tables\Filters\TernaryFilter::make('verified')->label('Verified'),
            ])
            ->groups([
                Group::make('event.title')->label('Event')->collapsible(),
            ])
            ->defaultGroup('event.title')
            ->actions([
                Tables\Actions\Action::make('sendWhatsApp')
                    ->label('Send WhatsApp')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->url(fn (Ticket $record): ?string => static::whatsappUrl($record))
                    ->openUrlInNewTab()
                    ->visible(fn (Ticket $record): bool => $record->status === 'paid'
                        && filled($record->phone)
                        && $record->whatsapp_confirmed),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('exportExcel')
                    ->label('Export to Excel')
                    ->icon('heroicon-o-table-cells')
                    ->action(function ($records) {
                        $rows = [['Reference', 'Event', 'Name', 'Email', 'Phone', 'Ticket type', 'Amount', 'Currency', 'Status', 'Created at']];

                        foreach ($records as $ticket) {
                            $rows[] = [
                                $ticket->reference,
                                $ticket->event?->title,
                                $ticket->name,
                                $ticket->email,
                                $ticket->formatted_phone,
                                $ticket->ticket_type,
                                $ticket->amount,
                                $ticket->currency,
                                $ticket->status,
                                $ticket->created_at?->toDateTimeString(),
                            ];
                        }

                        return response()->streamDownload(function () use ($rows): void {
                            $handle = fopen('php://output', 'w');
                            foreach ($rows as $row) {
                                fputcsv($handle, $row);
                            }
                            fclose($handle);
                        }, 'stellar-surge-tickets.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
                    })
                    ->deselectRecordsAfterCompletion(),
                Tables\Actions\BulkAction::make('exportPdf')
                    ->label('Export to PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    ->action(function ($records) {
                        $html = view('filament.exports.tickets-pdf', ['tickets' => $records])->render();

                        return response()->streamDownload(function () use ($html): void {
                            echo Pdf::loadHTML($html)->output();
                        }, 'stellar-surge-tickets.pdf', ['Content-Type' => 'application/pdf']);
                    })
                    ->deselectRecordsAfterCompletion(),
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function whatsappUrl(Ticket $ticket): ?string
    {
        if ($ticket->status !== 'paid' || ! $ticket->phone || ! $ticket->whatsapp_confirmed) {
            return null;
        }

        $phone = preg_replace('/\D+/', '', $ticket->phone);
        $message = sprintf(
            'Hello %s, your ticket for %s is confirmed. Reference: %s. Please keep your PDF ticket and QR code ready for the event.',
            $ticket->name,
            $ticket->event->title,
            $ticket->reference,
        );

        return 'https://wa.me/'.$phone.'?text='.rawurlencode($message);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTickets::route('/'),
            'edit' => Pages\EditTicket::route('/{record}/edit'),
        ];
    }
}
