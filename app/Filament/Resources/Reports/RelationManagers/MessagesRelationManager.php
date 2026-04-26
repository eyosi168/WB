<?php

namespace App\Filament\Resources\ReportResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class MessagesRelationManager extends RelationManager
{
    protected static string $relationship = 'messages';

    protected static ?string $recordTitleAttribute = 'message';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('message')
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull()
                    ->placeholder('Type your question or update here...'),
                
                // Forces the sender_type to be 'admin' behind the scenes
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
                    ->wrap() // Prevents long messages from truncating
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Sent At')
                    ->dateTime('M d, Y h:i A')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc') // Puts the newest messages at the top
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('New Message')
                    ->modalHeading('Send Message to Reporter')
                    ->modalSubmitActionLabel('Send'),
            ])
            ->actions([
                // Intentionally leaving out Edit and Delete actions. 
                // In a whistleblower system, messages should be an immutable audit log.
            ])
            ->bulkActions([
                //
            ]);
    }
}