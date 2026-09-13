<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventGalleryCommentResource\Pages;
use App\Models\EventGalleryComment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class EventGalleryCommentResource extends Resource
{
    protected static ?string $model = EventGalleryComment::class;
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationGroup = 'Events';
    protected static ?string $navigationLabel = 'Gallery comments';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->disabled(),
            Forms\Components\TextInput::make('email')->disabled(),
            Forms\Components\Textarea::make('body')->disabled()->columnSpanFull(),
            Forms\Components\Toggle::make('is_approved')->label('Approved for gallery'),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('galleryItem.event.title')->label('Event')->searchable(),
            Tables\Columns\TextColumn::make('galleryItem.category')->label('Category'),
            Tables\Columns\TextColumn::make('name')->searchable(),
            Tables\Columns\TextColumn::make('body')->limit(70),
            Tables\Columns\IconColumn::make('is_approved')->boolean()->label('Approved'),
            Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
        ])->filters([
            Tables\Filters\TernaryFilter::make('is_approved')->label('Approved'),
        ])->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])->bulkActions([
            Tables\Actions\BulkAction::make('approve')->label('Approve selected')->action(fn ($records) => $records->each->update(['is_approved' => true]))->deselectRecordsAfterCompletion(),
            Tables\Actions\DeleteBulkAction::make(),
        ]);
    }

    public static function getPages(): array
    {
        return ['index' => Pages\ListEventGalleryComments::route('/'), 'edit' => Pages\EditEventGalleryComment::route('/{record}/edit')];
    }
}
