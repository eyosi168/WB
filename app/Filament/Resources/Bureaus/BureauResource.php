<?php

namespace App\Filament\Resources\Bureaus;

use App\Filament\Resources\Bureaus\Pages\CreateBureau;
use App\Filament\Resources\Bureaus\Pages\EditBureau;
use App\Filament\Resources\Bureaus\Pages\ListBureaus;
use App\Filament\Resources\Bureaus\Pages\ViewBureau;
use App\Filament\Resources\Bureaus\Schemas\BureauForm;
use App\Filament\Resources\Bureaus\Schemas\BureauInfolist;
use App\Filament\Resources\Bureaus\Tables\BureausTable;
use App\Models\Bureau;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BureauResource extends Resource
{
    protected static ?string $model = Bureau::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice;

    protected static string|UnitEnum|null $navigationGroup = 'System Data';
    protected static ?string $recordTitleAttribute = 'name';
    public static function form(\Filament\Schemas\Schema $form): \Filament\Schemas\Schema
    {
        return $form
            ->components([
                \Filament\Schemas\Components\Section::make('Bureau Information')
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('name')
                            ->required()
                            ->unique(ignoreRecord: true),
                    ]),
            ]);
    }
    
    public static function table(\Filament\Tables\Table $table): \Filament\Tables\Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                \Filament\Tables\Columns\TextColumn::make('reports_count')->counts('reports')->label('Total Reports'),
            ]);
    }



    public static function infolist(Schema $schema): Schema
    {
        return BureauInfolist::configure($schema);
    }

    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBureaus::route('/'),
            'create' => CreateBureau::route('/create'),
            'view' => ViewBureau::route('/{record}'),
            'edit' => EditBureau::route('/{record}/edit'),
        ];
    }
}
