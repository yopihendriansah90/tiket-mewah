<?php

namespace App\Filament\Resources\TicketIssueLogs\Pages;

use App\Filament\Resources\TicketIssueLogs\TicketIssueLogResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTicketIssueLog extends CreateRecord
{
    protected static string $resource = TicketIssueLogResource::class;
}
