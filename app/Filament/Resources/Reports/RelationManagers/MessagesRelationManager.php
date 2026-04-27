<?php

namespace App\Filament\Resources\Reports\RelationManagers;

use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
/**
 * V5 CHANGE: The standard action location.
 */
use Filament\Actions\CreateAction; 

class MessagesRelationManager extends RelationManager
{
    protected static string $relationship = 'messages';

    protected static ?string $recordTitleAttribute = 'message';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\Textarea::make('message')
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull()
                    ->placeholder('Type your question or update here...'),
                
                Forms\Components\Hidden::make('sender_type')
                    ->default('admin'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('message')
            ->columns([
                Tables\Columns\TextColumn::make('sender_type')
                    ->label('Sender')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'admin' => 'success',
                        'reporter' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),
                
                Tables\Columns\TextColumn::make('message')
                    ->wrap()
                    ->searchable(),
                    // Add this inside your $table->columns([]) array
Tables\Columns\TextColumn::make('attachment_path')
->label('Attachment')
->formatStateUsing(fn ($state) => $state ? '📎 View File' : '-')
->url(fn ($record) => $record->attachment_path ? asset('storage/' . $record->attachment_path) : null)
->openUrlInNewTab()
->color('primary'),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Sent At')
                    ->dateTime('M d, Y h:i A')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->headerActions([
                /**
                 * In v5, we use CreateAction directly from Filament\Actions
                 */
                CreateAction::make()
                    ->label('New Message')
                    ->modalHeading('Send Message to Reporter')
                    ->modalSubmitActionLabel('Send'),
            ])
            ->actions([])
            ->bulkActions([]);
    }
}