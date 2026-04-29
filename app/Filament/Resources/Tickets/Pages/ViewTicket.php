<?php

namespace App\Filament\Resources\Tickets\Pages;

use App\Enums\TicketStatus;
use App\Filament\Resources\Tickets\TicketResource;
use App\Services\Ticket\TicketPdfService;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTicket extends ViewRecord
{
    protected static string $resource = TicketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('generatePdf')
                ->label('Generate PDF')
                ->icon('heroicon-o-document')
                ->color('info')
                ->visible(fn (): bool => app(TicketPdfService::class)->canGenerate($this->record))
                ->action(function (): void {
                    app(TicketPdfService::class)->generate($this->record);
                })
                ->successNotificationTitle('PDF tiket berhasil dibuat'),
            Action::make('downloadPdf')
                ->label('Download PDF')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('gray')
                ->visible(fn (): bool => app(TicketPdfService::class)->hasPdfFile($this->record))
                ->action(fn () => app(TicketPdfService::class)->download($this->record)),
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
