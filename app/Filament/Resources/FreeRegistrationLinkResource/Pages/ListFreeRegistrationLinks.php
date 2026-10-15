<?php

namespace App\Filament\Resources\FreeRegistrationLinkResource\Pages;

use App\Filament\Resources\FreeRegistrationLinkResource;
use App\Models\Event;
use App\Services\FreeRegistrationLinkService;
use Filament\Actions;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\HtmlString;

class ListFreeRegistrationLinks extends ListRecords
{
    protected static string $resource = FreeRegistrationLinkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('createLink')
                ->label('Generate complimentary link')
                ->icon('heroicon-o-plus')
                ->form([
                    Forms\Components\Select::make('event_id')
                        ->label('Event')
                        ->options(fn (): array => Event::query()->orderBy('start_at')->pluck('title', 'id')->all())
                        ->searchable()
                        ->required(),
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
                ->action(function (array $data): void {
                    $event = Event::query()->findOrFail($data['event_id']);
                    $service = app(FreeRegistrationLinkService::class);
                    ['link' => $link, 'token' => $token] = $service->create(
                        $event,
                        $data['group_name'],
                        (int) $data['registration_limit'],
                        (int) $data['expiry_days'],
                    );
                    $url = $service->checkoutUrl($event, $token);

                    Notification::make()
                        ->title('Complimentary link created for '.$link->group_name)
                        ->body(new HtmlString(
                            '<p>For '.e($event->title).'. Expires '.e($link->expires_at->format('d M Y, H:i')).'.</p>'
                            .'<input type="text" readonly value="'.e($url).'" onclick="this.select()" style="width:100%;margin-top:8px;padding:8px;border:1px solid #d1d5db;border-radius:6px;">'
                        ))
                        ->persistent()
                        ->success()
                        ->send();
                }),
        ];
    }
}
