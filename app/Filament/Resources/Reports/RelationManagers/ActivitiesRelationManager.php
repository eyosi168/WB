<?php

namespace App\Filament\Resources\Reports\RelationManagers;

use App\Filament\Resources\Reports\ReportResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use Filament\Tables; // THIS IS THE MISSING LINK

class ActivitiesRelationManager extends RelationManager
{
    protected static string $relationship = 'activities';

    protected static ?string $relatedResource = ReportResource::class;

    public function table(Table $table): Table
    {
        return $table
        ->recordTitleAttribute('description')
        ->columns([
            Tables\Columns\TextColumn::make('causer.name')
                ->label('User')
                ->placeholder('System') // Shows 'System' if it was an automated change
                ->badge(),

            Tables\Columns\TextColumn::make('description')
                ->label('Action'),

            // We replace ->json() with this:
            Tables\Columns\TextColumn::make('properties.attributes')
                ->label('Changes')
                ->formatStateUsing(fn ($state) => json_encode($state, JSON_PRETTY_PRINT))
                ->wrap() // Ensures long JSON strings don't break the layout
                ->fontFamily('mono'), // Makes the JSON look like code

            Tables\Columns\TextColumn::make('created_at')
                ->label('Date')
                ->dateTime()
                ->sortable(),
        ]);
    }
}
