<?php

namespace App\Filament\Resources\EventResource\Pages;

use App\Filament\Resources\EventResource;
use App\Models\Event;
use App\Services\FreeRegistrationLinkService;
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
