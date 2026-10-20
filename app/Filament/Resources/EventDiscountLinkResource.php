<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventDiscountLinkResource\Pages;
use App\Models\EventDiscountLink;
use App\Services\EventDiscountLinkService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;

class EventDiscountLinkResource extends Resource
{
    protected static ?string $model = EventDiscountLink::class;

    protected static ?string $navigationIcon = 'heroicon-o-link';

    protected static ?string $navigationGroup = 'Events';

    protected static ?string $navigationLabel = 'Discount links';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Placeholder::make('link_details')
                ->content('Discount links are generated from an event’s edit page.'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query->with('event'))
            ->columns([
                Tables\Columns\TextColumn::make('event.title')->label('Event')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('label')->label('Link label')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('usage_count')
                    ->label('Uses')
                    ->formatStateUsing(fn (int $state, EventDiscountLink $record): string => $record->usage_limit === null
                        ? "{$state} / Unlimited"
                        : "{$state} / {$record->usage_limit}"),
                Tables\Columns\TextColumn::make('expires_at')
                    ->label('Expires')
                    ->dateTime()
                    ->placeholder('Never')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->state(fn (EventDiscountLink $record): string => ! $record->isAvailable()
                        ? ($record->expires_at && $record->expires_at->isPast() ? 'Expired' : 'Fully used')
                        : ($record->event->discount_mode === 'link' ? 'Active' : 'Paused'))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Active' => 'success',
                        'Paused' => 'warning',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('registration_url')
                    ->label('Share link')
                    ->state(fn (EventDiscountLink $record): string => app(EventDiscountLinkService::class)
                        ->checkoutUrlForLink($record) ?? 'Link unavailable; generate a new one')
                    ->copyable(fn (string $state): bool => filter_var($state, FILTER_VALIDATE_URL) !== false)
                    ->copyMessage('Discount link copied')
                    ->copyableState(fn (string $state): ?string => filter_var($state, FILTER_VALIDATE_URL) ? $state : null)
                    ->wrap(),
            ])
            ->defaultSort('id', 'desc')
            ->actions([
                Tables\Actions\Action::make('showLink')
                    ->label('View / copy link')
                    ->icon('heroicon-o-clipboard-document')
                    ->modalHeading(fn (EventDiscountLink $record): string => 'Discount link for '.$record->label)
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Close')
                    ->modalContent(function (EventDiscountLink $record): HtmlString {
                        $url = app(EventDiscountLinkService::class)->checkoutUrlForLink($record);

                        if (! $url) {
                            return new HtmlString('<p>This link cannot be decrypted. Delete it and generate a new link.</p>');
                        }

                        return new HtmlString(
                            '<p style="margin-bottom:8px">Copy and share this private discount link:</p>'
                            .'<div style="display:flex;gap:8px;align-items:center">'
                            .'<input type="text" readonly value="'.e($url).'" onclick="this.select()" style="width:100%;padding:10px;border:1px solid #d1d5db;border-radius:6px">'
                            .'<button type="button" onclick="const i=this.previousElementSibling;i.select();navigator.clipboard.writeText(i.value).then(()=>{this.textContent=\'Copied!\'}).catch(()=>{document.execCommand(\'copy\');this.textContent=\'Copied!\'})" style="white-space:nowrap;padding:10px 14px;border-radius:6px;background:#32152F;color:white">Copy</button>'
                            .'</div>'
                        );
                    }),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEventDiscountLinks::route('/'),
        ];
    }
}
