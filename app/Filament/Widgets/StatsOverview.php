<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Report;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $user = auth()->user();
        $query = Report::query();

        // Filter for normal admins
        if (! $user->hasRole('super_admin')) {
            $assignedCategoryIds = $user->categories()->pluck('categories.id');
            $query->whereIn('category_id', $assignedCategoryIds);
        }

        return [
            Stat::make('Total Reports', (clone $query)->count())
                ->description('Reports filed to date')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
                
            Stat::make('Pending', (clone $query)->where('status', 'pending')->count())
                ->color('warning'),
        ];
    }
}