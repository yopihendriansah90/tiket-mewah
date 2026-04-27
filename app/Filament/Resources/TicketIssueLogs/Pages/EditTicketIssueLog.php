<?php

namespace App\Filament\Resources\TicketIssueLogs\Pages;

use App\Filament\Resources\TicketIssueLogs\TicketIssueLogResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditTicketIssueLog extends EditRecord
{
    protected static string $resource = TicketIssueLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
