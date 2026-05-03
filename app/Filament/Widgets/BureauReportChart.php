<?php

namespace App\Filament\Widgets;

use Illuminate\Support\Facades\DB;
use Filament\Widgets\ChartWidget;
use App\Models\Report;

class BureauReportChart extends ChartWidget
{
    protected ?string $heading = 'Reports per Bureau';

    protected function getData(): array
    {
        $user = auth()->user();
        
        $query = Report::query()
            ->join('bureaus', 'reports.bureau_id', '=', 'bureaus.id');

        // Apply the category filter
        if (! $user->hasRole('super_admin')) {
            $assignedCategoryIds = $user->categories()->pluck('categories.id');
            $query->whereIn('reports.category_id', $assignedCategoryIds);
        }

        $data = $query->select('bureaus.name', DB::raw('count(*) as total'))
            ->groupBy('bureaus.name')
            ->pluck('total', 'name');

        return [
            'datasets' => [
                [
                    'data' => $data->values()->toArray(),
                    // Shades of Green and Blue for branding consistency
                    'backgroundColor' => ['#8ec23c', '#048ed6', '#a5d15c', '#33a5e0', '#638c24'],
                ],
            ],
            'labels' => $data->keys()->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}