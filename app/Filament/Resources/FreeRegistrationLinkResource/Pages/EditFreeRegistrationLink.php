<?php

namespace App\Filament\Resources\FreeRegistrationLinkResource\Pages;

use App\Filament\Resources\FreeRegistrationLinkResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFreeRegistrationLink extends EditRecord
{
    protected static string $resource = FreeRegistrationLinkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
