<?php

namespace App\Filament\Resources\TicketReprints\Pages;

use App\Filament\Resources\TicketReprints\TicketReprintResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTicketReprint extends CreateRecord
{
    protected static string $resource = TicketReprintResource::class;
}
