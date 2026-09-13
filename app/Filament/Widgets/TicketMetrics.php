<?php

namespace App\Filament\Widgets;

use App\Models\Ticket;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TicketMetrics extends BaseWidget
{
    protected function getStats(): array
    {
        $paidTickets = Ticket::query()->where('status', 'paid');
        $stats = [
            Stat::make('Tickets purchased', (string) $paidTickets->count())
                ->description('Paid tickets issued')
                ->icon('heroicon-o-ticket'),
            Stat::make('Tickets verified', (string) Ticket::query()->where('verified', true)->count())
                ->description('Entries scanned and accepted')
                ->icon('heroicon-o-check-badge'),
            Stat::make('Pending tickets', (string) Ticket::query()->where('status', 'pending')->count())
                ->description('Awaiting payment')
                ->icon('heroicon-o-clock'),
            Stat::make('Failed tickets', (string) Ticket::query()->where('status', 'failed')->count())
                ->description('Payment was not completed')
                ->icon('heroicon-o-x-circle'),
        ];

        foreach (Ticket::query()->where('status', 'paid')->select('currency')->distinct()->pluck('currency') as $currency) {
            $amount = Ticket::query()
                ->where('status', 'paid')
                ->where('currency', $currency)
                ->sum('amount');

            $stats[] = Stat::make('Paid amount (' . $currency . ')', number_format($amount) . ' ' . $currency)
                ->description('Collected from paid tickets')
                ->icon('heroicon-o-banknotes');
        }

        return $stats;
    }
}
