<?php

namespace App\Filament\Resources\Reports;

use App\Models\Report;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;
use BackedEnum;

class ReportResource extends Resource
{
    protected static ?string $model = Report::class;

    protected static string|null|BackedEnum $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'id';

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
                            /** * FIX: This line fetches the existing file paths from the 
                             * 'attachments' relationship and displays them in the form 
                             * so you don't see an empty "Drag & Drop" box.
                             */
                            ->formatStateUsing(function (?Model $record) {
                                if (!$record) {
                                    return [];
                                }
                                
                                return $record->attachments->pluck('file_path')->toArray();
                            })
                            /** * FIX: When you save, this deletes old database links 
                             * and creates new ones for the files currently in the box.
                             */
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

                // FIX: Adding a "View" button directly as a column to bypass the error
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
            // Notice: actions() is gone. We put the link in the 'view_report' column instead.
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\Reports\Pages\ListReports::route('/'),
            'create' => \App\Filament\Resources\Reports\Pages\CreateReport::route('/create'),
            'view' => \App\Filament\Resources\Reports\Pages\ViewReport::route('/{record}'),
            'edit' => \App\Filament\Resources\Reports\Pages\EditReport::route('/{record}/edit'),
        ];
    }
}