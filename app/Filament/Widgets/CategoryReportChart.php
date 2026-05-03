<?php

namespace App\Filament\Widgets;

use App\Models\Report;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class CategoryReportChart extends ChartWidget
{
    protected ?string $heading = 'Reports by Incident Category';
    protected int | string | array $columnSpan = 1;
    protected ?string $pollingInterval = '15s';

    protected function getData(): array
    {
        $user = auth()->user();
        
        $query = Report::query()
            ->join('categories', 'reports.category_id', '=', 'categories.id');

        // Apply the category filter
        if (! $user->hasRole('super_admin')) {
            $assignedCategoryIds = $user->categories()->pluck('categories.id');
            $query->whereIn('reports.category_id', $assignedCategoryIds);
        }

        $data = $query->select('categories.name', DB::raw('count(*) as total'))
            ->groupBy('categories.name')
            ->pluck('total', 'name');

        return [
            'datasets' => [
                [
                    'label' => 'Total Reports',
                    'data' => $data->values()->toArray(),
                    'backgroundColor' => '#8ec23c', // Primary Green
                    'borderColor' => '#048ed6',     // Secondary Blue
                    'borderWidth' => 2,
                ],
            ],
            'labels' => $data->keys()->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}