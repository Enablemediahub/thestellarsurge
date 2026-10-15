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
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use App\Services\TicketSecurityService;

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
                            ->helperText('Use 0 for a free registration program. Use a positive amount to require payment. Add ticket categories below to define prices.'),
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
                            ->helperText('Every category must be 0 for free registration. Any positive category price sends the attendee through payment. Leave empty to use the event price as one Standard ticket.'),
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
                            ->formatStateUsing(function (?string $state): array {
                                return $state && ! filter_var($state, FILTER_VALIDATE_URL) ? [$state] : [];
                            })
                            ->dehydrateStateUsing(fn ($state): ?string => is_array($state) ? (array_values($state)[0] ?? null) : $state)
                            ->dehydrated(fn ($state): bool => filled($state))
                            ->helperText('Upload a new local flyer if needed. Existing remote flyers remain unchanged.'),
                        Forms\Components\Placeholder::make('current_banner_preview')
                            ->label('Current flyer')
                            ->content(function (?Event $record): HtmlString {
                                $image = $record?->bannerImageUrl();

                                return new HtmlString($image
                                    ? '<img src="' . e($image) . '" alt="Current program flyer" style="max-width: 260px; max-height: 180px; object-fit: contain; border-radius: 10px; background: #eadfcf; padding: 8px;">'
                                    : '<span>No flyer uploaded.</span>');
                            }),
                    ])->columns(3),

                Forms\Components\Section::make('Publishing')
                    ->schema([
                        Forms\Components\Toggle::make('is_published')
                            ->default(true),
                        Forms\Components\Toggle::make('featured')
                            ->default(false),
                    ])->columns(2),

                Forms\Components\Section::make('Ticket preview')
                    ->description('A live visual preview of the event ticket and its scan code.')
                    ->schema([
                        Forms\Components\Placeholder::make('ticket_preview')
                            ->label('')
                            ->content(function (?Event $record): HtmlString {
                                if (! $record) {
                                    return new HtmlString('<p>Save the event to preview its ticket design and scan code.</p>');
                                }

                                $image = $record->bannerImageUrl();
                                $imageMarkup = $image
                                    ? '<img src="' . e($image) . '" alt="Event flyer" style="width: 100%; max-height: 220px; object-fit: contain; background: #eadfcf; border-radius: 12px;">'
                                    : '<div style="height: 120px; display: grid; place-items: center; background: #eadfcf; border-radius: 12px; color: #32152F;">No event flyer uploaded</div>';
                                $security = app(TicketSecurityService::class);
                                $payload = $security->previewPayloadFor($record);
                                $qr = $security->qrSvgFor($security->verificationUrlFor($payload), 180);
                                $reference = 'PREVIEW-' . $record->id;
                                $integrityCode = $security->integrityCodeFor($payload);

                                return new HtmlString('<div style="position: relative; max-width: 720px; overflow: hidden; border: 2px solid #32152F; border-radius: 12px; background: #fffaf4; color: #242124;">'
                                    . '<div style="position: absolute; inset: 0; display: grid; place-items: center; pointer-events: none; color: rgba(50,21,47,.06); font-size: 48px; font-weight: 700; transform: rotate(-18deg);">STELLAR SURGE</div>'
                                    . '<div style="display: flex; min-height: 270px;">'
                                    . '<div style="flex: 1; padding: 22px 26px;">'
                                    . '<div style="color: #32152F; font-size: 20px; font-weight: 700;">Stellar Surge <span style="color: #9c7839;">| Event Pass</span></div>'
                                    . '<div style="margin-top: 18px;">' . $imageMarkup . '</div>'
                                    . '<h2 style="color: #32152F; font-size: 24px; margin: 14px 0 6px;">' . e($record->title) . '</h2>'
                                    . '<p style="margin: 0; line-height: 1.6;"><strong>Guest:</strong> Preview Guest<br><strong>Date:</strong> ' . e($record->start_at?->format('d M Y, h:i A') ?? 'TBA') . '<br><strong>Location:</strong> ' . e($record->location) . '</p>'
                                    . '</div>'
                                    . '<div style="width: 190px; border-left: 2px dashed #c8a46a; padding: 22px 18px; text-align: center;">'
                                    . '<div style="font-size: 10px; letter-spacing: 2px; color: #32152F;">SECURE SERIAL</div>'
                                    . '<div style="margin-top: 8px; font-size: 13px; font-weight: 700; color: #32152F;">' . e($reference) . '</div>'
                                    . '<img src="data:image/svg+xml;base64,' . $qr . '" alt="Preview QR code" style="width: 140px; margin: 16px auto 10px;">'
                                    . '<div style="font-size: 9px; letter-spacing: 1px; color: #9c7839;">INTEGRITY ' . e($integrityCode) . '</div>'
                                    . '<div style="margin-top: 12px; font-size: 9px; color: #666;">Scan to verify</div>'
                                    . '</div></div></div>');
                            })
                            ->columnSpanFull(),
                    ]),
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
            ->defaultSort('featured', 'desc')
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
                Tables\Actions\BulkAction::make('markFeatured')
                    ->label('Mark featured')
                    ->icon('heroicon-o-star')
                    ->requiresConfirmation()
                    ->action(fn ($records) => $records->each->update(['featured' => true]))
                    ->deselectRecordsAfterCompletion(),
                Tables\Actions\BulkAction::make('removeFeatured')
                    ->label('Remove featured')
                    ->icon('heroicon-o-star')
                    ->requiresConfirmation()
                    ->action(fn ($records) => $records->each->update(['featured' => false]))
                    ->deselectRecordsAfterCompletion(),
                Tables\Actions\BulkAction::make('publish')
                    ->label('Publish selected')
                    ->icon('heroicon-o-eye')
                    ->action(fn ($records) => $records->each->update(['is_published' => true]))
                    ->deselectRecordsAfterCompletion(),
                Tables\Actions\BulkAction::make('unpublish')
                    ->label('Unpublish selected')
                    ->icon('heroicon-o-eye-slash')
                    ->requiresConfirmation()
                    ->action(fn ($records) => $records->each->update(['is_published' => false]))
                    ->deselectRecordsAfterCompletion(),
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
