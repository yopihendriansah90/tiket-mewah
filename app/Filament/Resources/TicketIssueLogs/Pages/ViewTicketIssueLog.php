<?php

namespace App\Filament\Resources\TicketIssueLogs\Pages;

use App\Filament\Resources\TicketIssueLogs\TicketIssueLogResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTicketIssueLog extends ViewRecord
{
    protected static string $resource = TicketIssueLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
