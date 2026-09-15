<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventPlanningRequestResource\Pages\EditEventPlanningRequest;
use App\Filament\Resources\EventPlanningRequestResource\Pages\ListEventPlanningRequests;
use App\Models\EventPlanningRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class EventPlanningRequestResource extends Resource
{
    protected static ?string $model = EventPlanningRequest::class;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationGroup = 'Site management';
    protected static ?string $navigationLabel = 'Event planning requests';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->disabled(),
            Forms\Components\TextInput::make('email')->email()->disabled(),
            Forms\Components\TextInput::make('phone')->disabled(),
            Forms\Components\TextInput::make('event_type')->disabled(),
            Forms\Components\Select::make('consultation_preference')->label('Meeting preference')->options([
                'in_person' => 'In-person', 'online' => 'Online',
            ])->disabled(),
            Forms\Components\DatePicker::make('event_date')->disabled(),
            Forms\Components\TextInput::make('guest_count')->numeric()->disabled(),
            Forms\Components\TextInput::make('budget')->disabled(),
            Forms\Components\Textarea::make('message')->disabled()->rows(6)->columnSpanFull(),
            Forms\Components\Select::make('status')->options([
                'new' => 'New', 'contacted' => 'Contacted', 'scheduled' => 'Scheduled', 'closed' => 'Closed',
            ])->required(),
            Forms\Components\Textarea::make('admin_notes')->label('Internal notes')->rows(5),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('email')->searchable()->copyable(),
            Tables\Columns\TextColumn::make('event_type')->label('Event')->searchable(),
            Tables\Columns\TextColumn::make('consultation_preference')->label('Meeting')->formatStateUsing(fn (?string $state): string => $state === 'in_person' ? 'In-person' : ($state === 'online' ? 'Online' : 'Not specified')),
            Tables\Columns\TextColumn::make('event_date')->date()->sortable(),
            Tables\Columns\TextColumn::make('status')->badge()->color(fn (string $state): string => match ($state) {
                'new' => 'warning', 'contacted', 'scheduled' => 'info', 'closed' => 'success', default => 'gray',
            }),
            Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
        ])->filters([
            Tables\Filters\SelectFilter::make('status')->options([
                'new' => 'New', 'contacted' => 'Contacted', 'scheduled' => 'Scheduled', 'closed' => 'Closed',
            ]),
        ])->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])->bulkActions([
            Tables\Actions\BulkAction::make('markContacted')->label('Mark contacted')->action(fn ($records) => $records->each->update(['status' => 'contacted']))->deselectRecordsAfterCompletion(),
            Tables\Actions\DeleteBulkAction::make(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEventPlanningRequests::route('/'),
            'edit' => EditEventPlanningRequest::route('/{record}/edit'),
        ];
    }
}
