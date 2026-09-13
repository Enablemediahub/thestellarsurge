<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages; 
use App\Models\Event;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Set;
use Illuminate\Support\Str;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationGroup = 'Events';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Event details')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Set $set, ?string $state): void {
                                $set('slug', Str::slug($state ?? ''));
                            })
                            ->maxLength(255),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->readOnly()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('summary')
                            ->maxLength(255),
                        Forms\Components\Textarea::make('description')
                            ->rows(5)
                            ->columnSpanFull(),
                        Forms\Components\DateTimePicker::make('start_at')
                            ->required(),
                        Forms\Components\DateTimePicker::make('end_at'),
                        Forms\Components\TextInput::make('location')
                            ->required(),
                        Forms\Components\TextInput::make('venue')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('location_url')
                            ->label('Google Maps link')
                            ->url()
                            ->placeholder('https://maps.google.com/...')
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Ticket setup')
                    ->schema([
                        Forms\Components\TextInput::make('price')
                            ->numeric()
                            ->required()
                            ->default(0),
                        Forms\Components\Repeater::make('ticket_options')
                            ->label('Ticket categories and prices')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Category name')
                                    ->required()
                                    ->placeholder('VIP, Regular, Student'),
                                Forms\Components\TextInput::make('price')
                                    ->label('Price in GHS')
                                    ->numeric()
                                    ->required()
                                    ->minValue(0),
                            ])
                            ->columns(2)
                            ->defaultItems(0)
                            ->columnSpanFull()
                            ->helperText('Leave empty to use the event price as one Standard ticket.'),
                        Forms\Components\Select::make('currency')
                            ->options([
                                'GHS' => 'GHS',
                                'USD' => 'USD',
                            ])
                            ->default('GHS'),
                        Forms\Components\FileUpload::make('banner_image')
                            ->label('Program flyer')
                            ->image()
                            ->disk('public')
                            ->directory('events/flyers')
                            ->visibility('public')
                            ->helperText('Upload the flyer shown on the events billboard and cards.'),
                    ])->columns(3),

                Forms\Components\Section::make('Publishing')
                    ->schema([
                        Forms\Components\Toggle::make('is_published')
                            ->default(true),
                        Forms\Components\Toggle::make('featured')
                            ->default(false),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('location')
                    ->searchable(),
                Tables\Columns\TextColumn::make('start_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->money(fn (Event $record) => $record->currency),
                Tables\Columns\IconColumn::make('is_published')
                    ->boolean(),
                Tables\Columns\IconColumn::make('featured')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Published'),
                Tables\Filters\TernaryFilter::make('featured')
                    ->label('Featured'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}
