<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestimonialResource\Pages;
use App\Models\Testimonial;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TestimonialResource extends Resource
{
    protected static ?string $model = Testimonial::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationGroup = 'Site management';
    protected static ?string $navigationLabel = 'Testimonials';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('quote')
                    ->required()
                    ->rows(5)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('author')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('role')
                    ->maxLength(255),
                Forms\Components\TextInput::make('sort_order')
                    ->numeric()
                    ->default(0)
                    ->minValue(0),
                Forms\Components\Toggle::make('is_approved')
                    ->label('Approved for website')
                    ->default(false),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('author')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('quote')->limit(70),
                Tables\Columns\TextColumn::make('role'),
                Tables\Columns\IconColumn::make('is_approved')->boolean()->label('Approved'),
                Tables\Columns\TextColumn::make('sort_order')->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_approved')->label('Approved'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTestimonials::route('/'),
            'create' => Pages\CreateTestimonial::route('/create'),
            'edit' => Pages\EditTestimonial::route('/{record}/edit'),
        ];
    }
}
