<?php

namespace App\Filament\Resources\Categories;

use App\Filament\Resources\Categories\Pages\CreateCategory;
use App\Filament\Resources\Categories\Pages\EditCategory;
use App\Filament\Resources\Categories\Pages\ListCategories;
use App\Filament\Resources\Categories\Pages\ViewCategory;
use App\Filament\Resources\Categories\Schemas\CategoryForm;
use App\Filament\Resources\Categories\Schemas\CategoryInfolist;
use App\Filament\Resources\Categories\Tables\CategoriesTable;
use App\Models\Category;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;

    protected static ?string $recordTitleAttribute = 'name';
    

    public static function form(\Filament\Schemas\Schema $form): \Filament\Schemas\Schema
{
    return $form
        ->components([
            \Filament\Schemas\Components\Section::make('Category Information')
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
            \Filament\Tables\Columns\TextColumn::make('reports_count')->counts('reports')->label('Reports in Category'),
        ]);
}

    public static function infolist(Schema $schema): Schema
    {
        return CategoryInfolist::configure($schema);
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
            'index' => ListCategories::route('/'),
            'create' => CreateCategory::route('/create'),
            'view' => ViewCategory::route('/{record}'),
            'edit' => EditCategory::route('/{record}/edit'),
        ];
    }
}
