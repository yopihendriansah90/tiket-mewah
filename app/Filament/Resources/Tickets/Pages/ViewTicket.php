<?php

namespace App\Filament\Resources\Tickets\Pages;

use App\Enums\TicketStatus;
use App\Filament\Resources\Tickets\TicketResource;
use App\Support\TicketFileActions;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTicket extends ViewRecord
{
    protected static string $resource = TicketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            TicketFileActions::generateConfigured()->record($this->record),
            TicketFileActions::downloadPdf()->record($this->record),
            TicketFileActions::downloadPng()->record($this->record),
            Action::make('deactivate')
                ->label('Nonaktifkan')
                ->icon('heroicon-o-no-symbol')
                ->color('danger')
                ->requiresConfirmation()
                ->modalHeading('Nonaktifkan Tiket')
                ->modalDescription('Gunakan aksi ini jika tiket dicuri atau tidak boleh dipakai lagi. Tiket akan diubah menjadi tidak aktif.')
                ->visible(fn (): bool => ! in_array($this->record->status, [
                    TicketStatus::Revoked->value,
                    TicketStatus::Cancelled->value,
                    TicketStatus::Replaced->value,
                ], true))
                ->action(function (): void {
                    $this->record->deactivate();
                })
                ->successNotificationTitle('Tiket berhasil dinonaktifkan'),
            EditAction::make(),
        ];
    }
}
