<?php

namespace App\Filament\Resources\TicketFiles\Pages;

use App\Filament\Resources\TicketFiles\TicketFileResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTicketFile extends ViewRecord
{
    protected static string $resource = TicketFileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
