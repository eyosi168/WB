<?php

namespace App\Filament\Resources\Reports;

use App\Filament\Resources\Reports\Pages;
use App\Models\Report;
use Filament\Resources\Resource;
use Filament\Schemas\Schema; // Essential for the new unified system
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ReportResource extends Resource
{
    protected static ?string $model = Report::class;

    // Matches the exact type union required by PHP 8.4 strictness
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'tracking_id';

    /**
     * @param Schema $schema
     * @return Schema
     */
    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Report Details')
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('tracking_id')
                            ->disabled(),
                        
                        \Filament\Forms\Components\Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'investigating' => 'Investigating',
                                'closed' => 'Closed',
                            ])
                            ->required(),

                        \Filament\Forms\Components\Textarea::make('description')
                            ->columnSpanFull()
                            ->disabled(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('tracking_id')
                    ->searchable()
                    ->sortable(),

                \Filament\Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'gray',
                        'investigating' => 'warning',
                        'closed' => 'success',
                        default => 'gray',
                    }),
            ])
            ->actions([
                // FIX: Full namespace calls to stop the "Line 70" resolution error
                \Filament\Actions\ViewAction::make(),
                \Filament\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReports::route('/'),
            'create' => Pages\CreateReport::route('/create'),
            'view' => Pages\ViewReport::route('/{record}'),
            'edit' => Pages\EditReport::route('/{record}/edit'),
        ];
    }
}