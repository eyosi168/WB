<?php

namespace App\Filament\Resources\Reports\Pages;

use App\Filament\Resources\Reports\ReportResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
class ViewReport extends ViewRecord
{
    protected static string $resource = ReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('claim')
                ->label('Claim Investigation')
                ->icon('heroicon-m-hand-raised')
                ->color('success') // Ethio Green
                // 1. Hide it if already claimed or if the user is a Super Admin
                ->visible(fn ($record) => 
                    $record->claimed_by === null && 
                    !auth()->user()->hasRole('super_admin')
                )
                // 2. The Logic
                ->action(function ($record) {
                    $record->update([
                        'claimed_by' => auth()->user()->id,
                        'status' => 'under_review', // Automatically move to review
                    ]);

                    Notification::make()
                        ->title('Report Claimed Successfully')
                        ->body('You are now the lead investigator for this case.')
                        ->success()
                        ->send();
                })
                ->requiresConfirmation()
                ->modalHeading('Claim this Report?')
                ->modalDescription('Once you claim this report, other admins in your category will see that you are handling it.'),
        ];
    }
}
