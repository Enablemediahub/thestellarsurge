<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketResource\Pages;
use App\Models\Ticket;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
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
                Tables\Columns\TextColumn::make('amount')->money(fn (Ticket $record) => $record->currency),
                Tables\Columns\BadgeColumn::make('status')->colors([
                    'warning' => 'pending',
                    'success' => 'paid',
                    'danger' => 'failed',
                ]),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')->options([
                    'pending' => 'Pending',
                    'paid' => 'Paid',
                    'failed' => 'Failed',
                ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
