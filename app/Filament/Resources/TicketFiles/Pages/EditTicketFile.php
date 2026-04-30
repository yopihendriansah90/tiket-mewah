<?php

declare(strict_types=1);

namespace App\Filament\Resources\TicketFiles\Pages;

use App\Filament\Resources\TicketFiles\TicketFileResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditTicketFile extends EditRecord
{
    protected static string $resource = TicketFileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            Action::make('preview')
                ->label('Open Preview')
                ->icon('heroicon-o-eye')
                ->url(fn (): ?string => $this->record->previewUrl(), shouldOpenInNewTab: true),
            DeleteAction::make(),
        ];
    }
}
