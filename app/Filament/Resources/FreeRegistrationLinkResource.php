<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FreeRegistrationLinkResource\Pages;
use App\Models\FreeRegistrationLink;
use App\Services\FreeRegistrationLinkService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;

class FreeRegistrationLinkResource extends Resource
{
    protected static ?string $model = FreeRegistrationLink::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    protected static ?string $navigationGroup = 'Events';

    protected static ?string $navigationLabel = 'Complimentary links';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('event_id')
                ->label('Event')
                ->relationship('event', 'title')
                ->searchable()
                ->preload()
                ->required(),
            Forms\Components\TextInput::make('group_name')
                ->label('Group or audience')
                ->maxLength(255)
                ->required(),
            Forms\Components\TextInput::make('registration_limit')
                ->label('Maximum registrations')
                ->numeric()
                ->integer()
                ->minValue(fn (?FreeRegistrationLink $record): int => max(1, $record?->registrations_used ?? 1))
                ->required(),
            Forms\Components\DateTimePicker::make('expires_at')
                ->required(),
            Forms\Components\Placeholder::make('registrations_used')
                ->label('Registrations used')
                ->content(fn (?FreeRegistrationLink $record): int => $record?->registrations_used ?? 0),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query->with('event'))
            ->columns([
                Tables\Columns\TextColumn::make('event.title')->label('Event')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('group_name')->label('Group')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('generation')->label('Generation')->formatStateUsing(fn (int $state): string => "Generation {$state}"),
                Tables\Columns\TextColumn::make('registration_limit')->label('Limit')->sortable(),
                Tables\Columns\TextColumn::make('registrations_used')
                    ->label('Used')
                    ->formatStateUsing(fn (int $state, FreeRegistrationLink $record): string => "{$state} / {$record->registration_limit}"),
                Tables\Columns\TextColumn::make('expires_at')->dateTime()->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->state(fn (FreeRegistrationLink $record): string => ! $record->expires_at->isFuture()
                        ? 'Expired'
                        : ($record->remainingRegistrations() === 0 ? 'Fully used' : 'Active'))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Active' => 'success',
                        'Fully used' => 'warning',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('registration_url')
                    ->label('Share link')
                    ->state(fn (FreeRegistrationLink $record): string => app(FreeRegistrationLinkService::class)
                        ->checkoutUrlForLink($record) ?? 'Link unavailable; generate a new one')
                    ->copyable(fn (string $state): bool => filter_var($state, FILTER_VALIDATE_URL) !== false)
                    ->copyMessage('Complimentary link copied')
                    ->wrap(),
            ])
            ->defaultSort('id', 'asc')
            ->filters([
                Tables\Filters\SelectFilter::make('event_id')
                    ->label('Event')
                    ->relationship('event', 'title')
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'used' => 'Fully used',
                        'expired' => 'Expired',
                    ])
                    ->query(function ($query, array $data) {
                        return match ($data['value'] ?? null) {
                            'active' => $query->where('expires_at', '>', now())
                                ->whereColumn('registrations_used', '<', 'registration_limit'),
                            'used' => $query->where('expires_at', '>', now())
                                ->whereColumn('registrations_used', '>=', 'registration_limit'),
                            'expired' => $query->where('expires_at', '<=', now()),
                            default => $query,
                        };
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('generateNextGeneration')
                    ->label('Generate next link')
                    ->icon('heroicon-o-arrow-path')
                    ->form([
                        Forms\Components\TextInput::make('registration_limit')
                            ->label('Maximum registrations')
                            ->numeric()
                            ->integer()
                            ->minValue(1)
                            ->maxValue(2147483647)
                            ->default(fn (FreeRegistrationLink $record): int => $record->registration_limit)
                            ->required(),
                        Forms\Components\TextInput::make('expiry_days')
                            ->label('Expires after (days)')
                            ->numeric()
                            ->integer()
                            ->minValue(1)
                            ->maxValue(3650)
                            ->default(1)
                            ->required(),
                    ])
                    ->action(function (FreeRegistrationLink $record, array $data): void {
                        $service = app(FreeRegistrationLinkService::class);
                        ['link' => $link, 'token' => $token] = $service->createNextGeneration(
                            $record,
                            (int) $data['registration_limit'],
                            (int) $data['expiry_days'],
                        );
                        $url = $service->checkoutUrl($link->event, $token);

                        Notification::make()
                            ->title("Generation {$link->generation} created for {$link->group_name}")
                            ->body(new HtmlString(
                                '<p>Expires '.e($link->expires_at->format('d M Y, H:i')).'.</p>'
                                .'<input type="text" readonly value="'.e($url).'" onclick="this.select()" style="width:100%;margin-top:8px;padding:8px;border:1px solid #d1d5db;border-radius:6px;">'
                            ))
                            ->persistent()
                            ->success()
                            ->send();
                    }),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFreeRegistrationLinks::route('/'),
            'edit' => Pages\EditFreeRegistrationLink::route('/{record}/edit'),
        ];
    }
}
