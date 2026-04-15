<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            \Filament\Widgets\StatsOverviewWidget\Stat::make('Total Reports', \App\Models\Report::count())
            ->description('Reports filed to date')
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->color('success'),
        \Filament\Widgets\StatsOverviewWidget\Stat::make('Pending', \App\Models\Report::where('status', 'pending')->count())
            ->color('warning'),
        ];
    }
}
