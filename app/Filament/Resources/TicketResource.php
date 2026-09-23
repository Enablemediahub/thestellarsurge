<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketResource\Pages;
use App\Models\Ticket;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Grouping\Group;
use Barryvdh\DomPDF\Facade\Pdf;

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
            ->columns([
                Tables\Columns\TextColumn::make('reference')->searchable()->copyable(),
                Tables\Columns\TextColumn::make('event.title')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('email')->searchable(),
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
                Tables\Filters\TernaryFilter::make('whatsapp_confirmed')->label('WhatsApp confirmed'),
                Tables\Filters\TernaryFilter::make('verified')->label('Verified'),
            ])
            ->groups([
                Group::make('event.title')->label('Event')->collapsible(),
            ])
            ->defaultGroup('event.title')
            ->actions([
                Tables\Actions\EditAction::make(),
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
                Tables\Actions\BulkAction::make('sendWhatsApp')
                    ->label('Send WhatsApp')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->requiresConfirmation()
                    ->action(fn ($records) => $records->each(fn (Ticket $ticket) => app(\App\Services\TicketDeliveryService::class)->sendWhatsApp($ticket))),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTickets::route('/'),
            'edit' => Pages\EditTicket::route('/{record}/edit'),
        ];
    }
}
