<?php

namespace App\Filament\Resources\TicketReprints\Pages;

use App\Filament\Resources\TicketReprints\TicketReprintResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTicketReprints extends ListRecords
{
    protected static string $resource = TicketReprintResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
