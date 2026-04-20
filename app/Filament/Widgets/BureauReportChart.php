<?php

namespace App\Filament\Widgets;
use Illuminate\Support\Facades\DB;

use Filament\Widgets\ChartWidget;
use App\Models\Report;


class BureauReportChart extends ChartWidget
{
    protected ?string $heading = 'Bureau Report Chart';
  
    // Inside app/Filament/Widgets/BureauReportChart.php

protected function getData(): array
{
    $data = Report::query()
        ->join('bureaus', 'reports.bureau_id', '=', 'bureaus.id')
        ->select('bureaus.name', DB::raw('count(*) as total'))
        ->groupBy('bureaus.name')
        ->pluck('total', 'name');

    return [
        'datasets' => [
            [
                'data' => $data->values()->toArray(),
                'backgroundColor' => ['#005a32', '#f7e400', '#ef4444', '#3b82f6', '#8b5cf6'],
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
