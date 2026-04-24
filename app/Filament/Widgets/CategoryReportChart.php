<?php

namespace App\Filament\Widgets;

use App\Models\Report;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class CategoryReportChart extends ChartWidget
{
    protected  ?string $heading = 'Reports by Incident Category';
    
    // In v5, you can use 'full', 1, 2, 3, etc. for span
    protected int | string | array $columnSpan = 1;

    // Refresh the chart every 15 seconds automatically
    protected  ?string $pollingInterval = '15s';

    protected function getData(): array
    {
        // Fetching data: Category Name + Count of Reports
        $data = Report::query()
            ->join('categories', 'reports.category_id', '=', 'categories.id')
            ->select('categories.name', DB::raw('count(*) as total'))
            ->groupBy('categories.name')
            ->pluck('total', 'name');

        return [
            'datasets' => [
                [
                    'label' => 'Total Reports',
                    'data' => $data->values()->toArray(),
                    // Ethio Telecom Branding: Green with a Yellow border
                    'backgroundColor' => '#8ec23c', 
                    'borderColor' => '#048ed6',
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