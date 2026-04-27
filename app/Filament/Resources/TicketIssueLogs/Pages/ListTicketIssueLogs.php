<?php

namespace App\Filament\Resources\TicketIssueLogs\Pages;

use App\Filament\Resources\TicketIssueLogs\TicketIssueLogResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTicketIssueLogs extends ListRecords
{
    protected static string $resource = TicketIssueLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
