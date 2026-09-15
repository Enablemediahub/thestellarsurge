<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogPostResource\Pages;
use App\Models\BlogPost;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class BlogPostResource extends Resource
{
    protected static ?string $model = BlogPost::class;
    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';
    protected static ?string $navigationGroup = 'Site management';
    protected static ?string $navigationLabel = 'BlogSurge posts';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')
                ->required()
                ->live()
                ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state ?? '')))
                ->maxLength(255),
            Forms\Components\TextInput::make('slug')->required()->unique(ignoreRecord: true)->readOnly()->maxLength(255),
            Forms\Components\Textarea::make('excerpt')->label('Short introduction')->rows(3)->maxLength(500)->columnSpanFull(),
            Forms\Components\RichEditor::make('content')
                ->required()
                ->toolbarButtons([
                    'attachFiles', 'blockquote', 'bold', 'bulletList', 'codeBlock',
                    'h2', 'h3', 'italic', 'link', 'orderedList', 'redo',
                    'strike', 'underline', 'undo',
                ])
                ->columnSpanFull(),
            Forms\Components\FileUpload::make('cover_image')->label('Cover image')->image()->disk('public')->directory('blog')->visibility('public'),
            Forms\Components\DateTimePicker::make('published_at')->label('Publish date')->default(now()),
            Forms\Components\Toggle::make('is_published')->label('Visible on BlogSurge')->default(false),
            Forms\Components\Toggle::make('is_featured')->label('Featured post')->default(false),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('published_at')->dateTime()->sortable(),
                Tables\Columns\IconColumn::make('is_published')->boolean()->label('Published'),
                Tables\Columns\IconColumn::make('is_featured')->boolean()->label('Featured'),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_published')->label('Published'),
                Tables\Filters\TernaryFilter::make('is_featured')->label('Featured'),
            ])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([
                Tables\Actions\BulkAction::make('publish')->label('Publish selected')->icon('heroicon-o-eye')->action(fn ($records) => $records->each->update(['is_published' => true]))->deselectRecordsAfterCompletion(),
                Tables\Actions\BulkAction::make('unpublish')->label('Unpublish selected')->icon('heroicon-o-eye-slash')->action(fn ($records) => $records->each->update(['is_published' => false]))->deselectRecordsAfterCompletion(),
                Tables\Actions\BulkAction::make('feature')->label('Feature selected')->icon('heroicon-o-star')->action(fn ($records) => $records->each->update(['is_featured' => true]))->deselectRecordsAfterCompletion(),
                Tables\Actions\BulkAction::make('unfeature')->label('Remove from featured')->icon('heroicon-o-star')->action(fn ($records) => $records->each->update(['is_featured' => false]))->deselectRecordsAfterCompletion(),
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBlogPosts::route('/'),
            'create' => Pages\CreateBlogPost::route('/create'),
            'edit' => Pages\EditBlogPost::route('/{record}/edit'),
        ];
    }
}
