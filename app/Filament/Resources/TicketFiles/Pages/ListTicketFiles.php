<?php

namespace App\Filament\Resources\TicketFiles\Pages;

use App\Filament\Resources\TicketFiles\TicketFileResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTicketFiles extends ListRecords
{
    protected static string $resource = TicketFileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
