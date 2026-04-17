<?php

namespace App\Filament\Resources\Bureaus\Pages;

use App\Filament\Resources\Bureaus\BureauResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewBureau extends ViewRecord
{
    protected static string $resource = BureauResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
