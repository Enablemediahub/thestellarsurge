<?php

namespace App\Filament\Resources\EventResource\Pages;

use App\Filament\Resources\EventResource;
use App\Filament\Resources\EventDiscountLinkResource;
use App\Models\Event;
use App\Services\EventDiscountLinkService;
use App\Services\FreeRegistrationLinkService;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\HtmlString;

class EditEvent extends EditRecord
{
    protected static string $resource = EventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('viewDiscountLinks')
                ->label('View discount links')
                ->icon('heroicon-o-clipboard-document-list')
                ->url(EventDiscountLinkResource::getUrl('index')),
            Actions\Action::make('generateDiscountLink')
                ->label('Generate discount link')
                ->icon('heroicon-o-link')
                ->modalDescription('Generate a private ticket link. Anyone with the link can use the event’s private discount prices.')
                ->form([
                    Forms\Components\TextInput::make('label')
                        ->label('Link label')
                        ->placeholder('Speakers, partners, invited guests')
                        ->maxLength(255)
                        ->required(),
                    Forms\Components\TextInput::make('usage_limit')
                        ->label('Maximum ticket uses')
                        ->numeric()
                        ->integer()
                        ->minValue(1)
                        ->maxValue(4294967295)
                        ->helperText('Leave blank for unlimited uses. Each ticket counts as one use.'),
                    Forms\Components\DateTimePicker::make('expires_at')
                        ->label('Expires at')
                        ->minDate(now())
                        ->rules(['nullable', 'date', 'after:now'])
                        ->helperText('Leave blank for no expiry.'),
                ])
                ->action(function (array $data, Event $record): void {
                    if (
                        $record->discount_mode !== 'link'
                        || ! collect($record->ticketOptions('link'))->contains('is_discounted', true)
                    ) {
                        Notification::make()
                            ->title('Private discount is not configured')
                            ->body('Set Discount offer to Private discount available by link and enter a private discount price below the regular price, then save the event.')
                            ->warning()
                            ->send();

                        return;
                    }

                    ['link' => $link, 'token' => $token] = app(EventDiscountLinkService::class)->create(
                        $record,
                        $data['label'],
                        filled($data['usage_limit'] ?? null) ? (int) $data['usage_limit'] : null,
                        filled($data['expires_at'] ?? null) ? Carbon::parse($data['expires_at'])->toDateTimeString() : null,
                    );
                    $url = app(EventDiscountLinkService::class)->checkoutUrl($record, $token);
                    $limits = [];

                    if ($link->usage_limit !== null) {
                        $limits[] = $link->usage_limit.' ticket uses';
                    }

                    if ($link->expires_at) {
                        $limits[] = 'expires '.$link->expires_at->format('d M Y, H:i');
                    }

                    Notification::make()
                        ->title('Discount link created for '.$link->label)
                        ->body(new HtmlString(
                            '<p>'.e($limits ? implode('; ', $limits) : 'Unlimited uses; no expiry').'. Copy and share this private link:</p>'
                            .'<input type="text" readonly value="'.e($url).'" onclick="this.select()" style="width:100%;margin-top:8px;padding:8px;border:1px solid #d1d5db;border-radius:6px;">'
                        ))
                        ->persistent()
                        ->success()
                        ->send();
                }),
            Actions\Action::make('generateFreeRegistrationLink')
                ->label('Generate complimentary link')
                ->icon('heroicon-o-ticket')
                ->visible(fn (Event $record): bool => ! $record->isFree())
                ->modalDescription('Create a named complimentary group link with its own registration limit and expiry.')
                ->form([
                    Forms\Components\TextInput::make('group_name')
                        ->label('Group or audience')
                        ->placeholder('Speakers, partner organizations, VIP guests')
                        ->maxLength(255)
                        ->required(),
                    Forms\Components\TextInput::make('registration_limit')
                        ->label('Maximum registrations')
                        ->numeric()
                        ->integer()
                        ->minValue(1)
                        ->maxValue(2147483647)
                        ->required(),
                    Forms\Components\TextInput::make('expiry_days')
                        ->label('Expires after (days)')
                        ->numeric()
                        ->integer()
                        ->minValue(1)
                        ->maxValue(3650)
                        ->default(1)
                        ->required()
                        ->helperText('Choose between 1 and 3650 days.'),
                ])
                ->action(function (array $data, Event $record): void {
                    ['link' => $link, 'token' => $token] = app(FreeRegistrationLinkService::class)->create(
                        $record,
                        $data['group_name'],
                        (int) $data['registration_limit'],
                        (int) $data['expiry_days'],
                    );
                    $url = app(FreeRegistrationLinkService::class)->checkoutUrl($record, $token);

                    Notification::make()
                        ->title('Complimentary link created for '.$link->group_name)
                        ->body(new HtmlString(
                            '<p>Expires '.e($link->expires_at->format('d M Y, H:i')).'. Copy and share this link:</p>'
                            .'<input type="text" readonly value="'.e($url).'" onclick="this.select()" style="width:100%;margin-top:8px;padding:8px;border:1px solid #d1d5db;border-radius:6px;">'
                        ))
                        ->persistent()
                        ->success()
                        ->send();
                }),
            Actions\DeleteAction::make(),
        ];
    }
}
