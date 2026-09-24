<?php

namespace App\Filament\Resources\SiteSettingResource\Pages;

use App\Filament\Resources\SiteSettingResource;
use Filament\Resources\Pages\EditRecord;

class EditSiteSetting extends EditRecord
{
    protected static string $resource = SiteSettingResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['ticket_scanner_enabled'] = (bool) ($data['ticket_scanner_enabled'] ?? false);

        return $data;
    }
}
