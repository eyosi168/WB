<?php

namespace App\Filament\Resources\Bureaus\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class BureauForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
            ]);
    }
}
