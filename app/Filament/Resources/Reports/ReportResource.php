<?php

namespace App\Filament\Resources\Reports;

use App\Models\Report;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;
use BackedEnum;
use Filament\Support\Icons\Heroicon;

/**
 * CHANGE 1: Corrected the Import Namespace.
 * We ensure we are pulling the MessagesRelationManager from the 'Reports' 
 * sub-folder to match your PSR-4 directory structure.
 */
use App\Filament\Resources\Reports\RelationManagers\MessagesRelationManager;

class ReportResource extends Resource
{
    protected static ?string $model = Report::class;

    protected static string|null|BackedEnum $navigationIcon = Heroicon::OutlinedExclamationTriangle;
    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'id';

    /**
     * CHANGE 2: Signature Update
     * Using Filament\Schemas\Schema to maintain compatibility with 
     * the version requirements of your current environment.
     */
    public static function form(\Filament\Schemas\Schema $form): \Filament\Schemas\Schema
    {
        return $form
            ->components([
                \Filament\Schemas\Components\Section::make('Report Details')
                    ->schema([
                        \Filament\Forms\Components\Select::make('bureau_id')
                            ->relationship('bureau', 'name')
                            ->required()
                            ->searchable()
                            ->preload(),
                         \Filament\Forms\Components\TextInput::make('address')
                            ->label('Incident Location / Address')
                            ->maxLength(255),
                        
                        \Filament\Forms\Components\Select::make('category_id')
                            ->relationship('category', 'name')
                            ->required()
                            ->preload(),
                            
                        \Filament\Forms\Components\Textarea::make('description')
                            ->required()
                            ->columnSpanFull(),
                    ])->columns(2),

                \Filament\Schemas\Components\Section::make('Status & Evidence')
                    ->schema([
                        \Filament\Forms\Components\Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'under_review' => 'Under Review',
                                'resolved' => 'Resolved',
                            ])
                            ->default('pending'),

                        \Filament\Forms\Components\Select::make('priority')
                            ->options([
                                'low' => 'Low',
                                'normal' => 'Normal',
                                'high' => 'High',
                            ])
                            ->default('normal'),

                        \Filament\Forms\Components\FileUpload::make('attachments')
                            ->multiple()
                            ->directory('report-evidence')
                            ->visibility('private')
                            ->openable()
                            ->downloadable()
                            ->formatStateUsing(function (?Model $record) {
                                if (!$record) {
                                    return [];
                                }
                                
                                return $record->attachments->pluck('file_path')->toArray();
                            })
                            ->saveRelationshipsUsing(static function (Model $record, $state) {
                                $record->attachments()->delete();
                                foreach ($state as $file) {
                                    $record->attachments()->create([
                                        'file_path' => $file,
                                        'file_name' => basename($file),
                                        'mime_type' => strtolower(pathinfo($file, PATHINFO_EXTENSION)),
                                    ]);
                                }
                            })
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(\Filament\Tables\Table $table): \Filament\Tables\Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('id')->sortable(),
                \Filament\Tables\Columns\TextColumn::make('bureau.name')->label('Bureau')->searchable(),
                \Filament\Tables\Columns\TextColumn::make('address')
                    ->label('Location')
                    ->searchable(),
                \Filament\Tables\Columns\TextColumn::make('category.name')->label('Category'),
                
                \Filament\Tables\Columns\TextColumn::make('attachments_count')
                    ->counts('attachments')
                    ->label('Files')
                    ->badge(),

                \Filament\Tables\Columns\TextColumn::make('view_report')
                    ->label('Action')
                    ->default('VIEW DETAILS')
                    ->color('primary')
                    ->weight('bold')
                    ->url(fn (Report $record): string => static::getUrl('view', ['record' => $record])),

                \Filament\Tables\Columns\TextColumn::make('priority')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'low' => 'gray',
                        'normal' => 'info',
                        'high' => 'danger',
                        default => 'gray',
                    }),

                \Filament\Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'under_review' => 'primary',
                        'resolved' => 'success',
                        default => 'gray',
                    }),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'resolved' => 'Resolved',
                    ]),
            ]);
    }

    /**
     * CHANGE 3: The Integration Point.
     * This registers the MessagesRelationManager. It will now appear 
     * at the bottom of your "View" and "Edit" pages.
     */
    public static function getRelations(): array
    {
        return [
            MessagesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\Reports\Pages\ListReports::route('/'),
            'create' => \App\Filament\Resources\Reports\Pages\CreateReport::route('/create'),
            // CHANGE 4: Fixed a typo in your snippet (Fil ament -> Filament)
            'view' => \App\Filament\Resources\Reports\Pages\ViewReport::route('/{record}'),
            'edit' => \App\Filament\Resources\Reports\Pages\EditReport::route('/{record}/edit'),
        ];
    }
}