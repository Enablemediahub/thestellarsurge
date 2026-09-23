<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected function getHeaderActions(): array
    {
        return [
            Action::make('hostingerMail')
                ->label('Log in to Hostinger Mail')
                ->icon('heroicon-o-envelope')
                ->color('danger')
                ->url('https://mail.hostinger.com/auth/login')
                ->openUrlInNewTab(),
        ];
    }
}