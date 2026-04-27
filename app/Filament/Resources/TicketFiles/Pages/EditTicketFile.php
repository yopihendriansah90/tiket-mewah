<?php

namespace App\Filament\Resources\TicketFiles\Pages;

use App\Filament\Resources\TicketFiles\TicketFileResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditTicketFile extends EditRecord
{
    protected static string $resource = TicketFileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
