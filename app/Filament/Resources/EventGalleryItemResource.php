<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventGalleryItemResource\Pages;
use App\Models\EventGalleryItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Get;

class EventGalleryItemResource extends Resource
{
    protected static ?string $model = EventGalleryItem::class;
    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationGroup = 'Events';
    protected static ?string $navigationLabel = 'Event gallery';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('event_id')
                ->label('Event')
                ->relationship('event', 'title', fn ($query) => $query->where('is_published', true)->orderBy('start_at'))
                ->searchable()
                ->preload()
                ->required()
                ->helperText('Choose the published event where this image or YouTube video should appear.'),
            Forms\Components\TextInput::make('category')->required()->default('Highlights'),
            Forms\Components\FileUpload::make('image_path')->label('Gallery image')->image()->disk('public')->directory('events/gallery')->visibility('public')->required(fn (Get $get): bool => blank($get('youtube_url'))),
            Forms\Components\TextInput::make('youtube_url')->label('YouTube URL')->url()->placeholder('https://www.youtube.com/watch?v=...')->helperText('Paste a YouTube link to show its thumbnail in the gallery.')->columnSpanFull(),
            Forms\Components\TextInput::make('caption')->maxLength(255),
            Forms\Components\TextInput::make('sort_order')->numeric()->default(0)->minValue(0),
            Forms\Components\Toggle::make('is_published')->label('Published on event gallery')->default(true),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\ImageColumn::make('image_path')->label('Image'),
            Tables\Columns\TextColumn::make('event.title')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('category')->searchable(),
            Tables\Columns\TextColumn::make('youtube_url')->label('YouTube')->limit(35),
            Tables\Columns\TextColumn::make('caption')->limit(50),
            Tables\Columns\TextColumn::make('likes_count')->sortable(),
            Tables\Columns\IconColumn::make('is_published')->boolean(),
        ])->filters([
            Tables\Filters\SelectFilter::make('event_id')->label('Event')->relationship('event', 'title'),
            Tables\Filters\TernaryFilter::make('is_published')->label('Published'),
        ])->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])->bulkActions([
            Tables\Actions\BulkAction::make('publish')->label('Publish selected')->action(fn ($records) => $records->each->update(['is_published' => true]))->deselectRecordsAfterCompletion(),
            Tables\Actions\DeleteBulkAction::make(),
        ]);
    }

    public static function getPages(): array
    {
        return ['index' => Pages\ListEventGalleryItems::route('/'), 'create' => Pages\CreateEventGalleryItem::route('/create'), 'edit' => Pages\EditEventGalleryItem::route('/{record}/edit')];
    }
}
