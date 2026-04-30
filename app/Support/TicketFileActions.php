<?php

declare(strict_types=1);

namespace App\Support;

use App\Models\Ticket;
use App\Services\Ticket\TicketFileGeneratorService;
use App\Services\Ticket\TicketImageService;
use App\Services\Ticket\TicketPdfService;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use InvalidArgumentException;

class TicketFileActions
{
    public static function generateConfigured(): Action
    {
        return Action::make('generateTicketFiles')
            ->label('Generate Files')
            ->icon('heroicon-o-document-duplicate')
            ->color('info')
            ->visible(fn (Ticket $record): bool => self::canGenerateAny($record))
            ->action(function (Ticket $record): void {
                try {
                    $files = app(TicketFileGeneratorService::class)->generateConfiguredFiles($record);

                    Notification::make()
                        ->title("{$files->count()} file tiket berhasil dibuat")
                        ->success()
                        ->send();
                } catch (InvalidArgumentException $exception) {
                    Notification::make()
                        ->title($exception->getMessage())
                        ->danger()
                        ->send();
                }
            });
    }

    public static function downloadPdf(): Action
    {
        return Action::make('downloadPdf')
            ->label('Download PDF')
            ->icon('heroicon-o-arrow-down-tray')
            ->color('gray')
            ->visible(fn (Ticket $record): bool => app(TicketPdfService::class)->hasPdfFile($record))
            ->action(fn (Ticket $record) => app(TicketPdfService::class)->download($record));
    }

    public static function downloadPng(): Action
    {
        return Action::make('downloadPng')
            ->label('Download PNG')
            ->icon('heroicon-o-photo')
            ->color('gray')
            ->visible(fn (Ticket $record): bool => app(TicketImageService::class)->hasPngFile($record))
            ->action(fn (Ticket $record) => app(TicketImageService::class)->download($record));
    }

    private static function canGenerateAny(Ticket $ticket): bool
    {
        return app(TicketPdfService::class)->canGenerate($ticket)
            || app(TicketImageService::class)->canGenerate($ticket);
    }
}
