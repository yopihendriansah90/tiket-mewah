<?php

namespace App\Filament\Resources\EventGates\Pages;

use App\Filament\Resources\EventGates\EventGateResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewEventGate extends ViewRecord
{
    protected static string $resource = EventGateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
