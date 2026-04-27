<?php

namespace App\Filament\Resources\TicketReprints\Pages;

use App\Filament\Resources\TicketReprints\TicketReprintResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditTicketReprint extends EditRecord
{
    protected static string $resource = TicketReprintResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
