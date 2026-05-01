<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\CheckboxList;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
{
    return $schema->components([
        TextInput::make('name')
            ->required(),
            
        TextInput::make('email')
            ->email()
            ->required()
            ->unique(ignoreRecord: true),

        TextInput::make('password')
            ->password()
            ->dehydrated(fn ($state) => filled($state)) // Only saves if you type something
            ->required(fn (string $context): bool => $context === 'create'),

        // 1. Selecting the Bureau (The "Where they work" field)
        Select::make('bureau_id')
            ->relationship('bureau', 'name')
            ->searchable()
            ->preload()
            ->nullable(),

        // 2. Assigning Categories (The Many-to-Many field)
        CheckboxList::make('categories')
            ->relationship('categories', 'name')
            ->columns(2)
            ->helperText('Select the categories this admin is responsible for.'),

        // 3. Assigning Spatie Roles (Admin vs Super Admin)
        Select::make('roles')
            ->relationship('roles', 'name')
            ->multiple()
            ->preload()
            ->searchable(),
    ]);
}
}
