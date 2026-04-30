<?php

declare(strict_types=1);

namespace App\Filament\Resources\TicketFiles\Pages;

use App\Filament\Resources\TicketFiles\TicketFileResource;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTicketFile extends ViewRecord
{
    protected static string $resource = TicketFileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('preview')
                ->label('Open Preview')
                ->icon('heroicon-o-eye')
                ->url(fn (): ?string => $this->record->previewUrl(), shouldOpenInNewTab: true),
            EditAction::make(),
        ];
    }
}
