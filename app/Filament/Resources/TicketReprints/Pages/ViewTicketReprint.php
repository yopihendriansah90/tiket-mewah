<?php

namespace App\Filament\Resources\TicketReprints\Pages;

use App\Filament\Resources\TicketReprints\TicketReprintResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTicketReprint extends ViewRecord
{
    protected static string $resource = TicketReprintResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
