<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
        ->columns([
            TextColumn::make('name')
                ->searchable()
                ->sortable(),

            TextColumn::make('email')
                ->searchable(),

            // 1. Fix the Bureau ID to show the Name
            TextColumn::make('bureau.name') 
                ->label('Bureau/Department')
                ->placeholder('No Bureau Assigned')
                ->sortable()
                ->searchable(),
            // The Bureau Level (Department, Section, etc.)
            TextColumn::make('bureau.level_type')
                ->label('Level')
                ->badge()
                ->color('gray') // Neutral color for levels
                ->sortable()
                ->searchable(),

            // 2. Fix the Role to show Spatie Roles
            // We use badges to make "super_admin" look different from "admin"
            TextColumn::make('roles.name')
                ->label('Assigned Role')
                ->badge() 
                ->color(fn (string $state): string => match ($state) {
                    'super_admin' => 'danger',
                    'admin' => 'info',
                    default => 'gray',
                })
                ->searchable(),
                
            TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
