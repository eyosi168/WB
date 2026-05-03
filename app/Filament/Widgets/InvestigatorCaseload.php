<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class InvestigatorCaseload extends BaseWidget
{
    protected static ?string $heading = 'Active Investigator Caseload';
    
    // Makes the table take up the full width of the dashboard
    protected int | string | array $columnSpan = 'full';

    // Security: Only Super Admins can see this table
    public static function canView(): bool
    {
        return auth()->user()->hasRole('super_admin');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                // Get users with the 'admin' role, and count their reports that are 'under_review'
                User::role('admin')->withCount(['reports as active_reports_count' => function (Builder $query) {
                    $query->where('status', 'under_review');
                }])
            )
            ->defaultSort('active_reports_count', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Investigator')
                    ->weight('bold'),
                    
                Tables\Columns\TextColumn::make('bureau.name')
                    ->label('Department')
                    ->placeholder('No Department'),
                    
                Tables\Columns\TextColumn::make('active_reports_count')
                    ->label('Active Cases')
                    ->badge()
                    ->color(fn (int $state): string => match (true) {
                        $state > 5 => 'danger',  // Overloaded (Red)
                        $state > 0 => 'success', // Working (Ethio Green)
                        default => 'gray',       // Idle
                    }),
            ]);
    }
}