<?php

namespace App\Filament\Resources\EventResource\Pages;

use App\Filament\Resources\EventResource;
use App\Models\Event;
use App\Models\FreeRegistrationLink;
use Filament\Actions;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

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
                ->modalDescription('The link will allow registration without payment, remain valid for 24 hours, and stop after the registration limit you set.')
                ->form([
                    Forms\Components\TextInput::make('registration_limit')
                        ->label('Maximum registrations')
                        ->numeric()
                        ->integer()
                        ->minValue(1)
                        ->maxValue(2147483647)
                        ->required(),
                ])
                ->action(function (array $data, Event $record): void {
                    $token = Str::random(64);
                    $link = FreeRegistrationLink::create([
                        'event_id' => $record->id,
                        'created_by' => auth()->id(),
                        'token_hash' => hash('sha256', $token),
                        'encrypted_token' => $token,
                        'registration_limit' => (int) $data['registration_limit'],
                        'expires_at' => now()->addDay(),
                    ]);
                    $url = route('events.checkout', [
                        'slug' => $record->slug,
                        'free_access' => $token,
                    ]);

                    Notification::make()
                        ->title('Complimentary registration link generated')
                        ->body(new HtmlString(
                            '<p>Expires ' . e($link->expires_at->format('d M Y, H:i')) . '. Copy and share this link:</p>'
                            . '<input type="text" readonly value="' . e($url) . '" onclick="this.select()" style="width:100%;margin-top:8px;padding:8px;border:1px solid #d1d5db;border-radius:6px;">'
                        ))
                        ->persistent()
                        ->success()
                        ->send();
                }),
            Actions\DeleteAction::make(),
        ];
    }
}
