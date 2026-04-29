<?php

namespace App\Filament\Resources\EventGates\Pages;

use App\Filament\Resources\EventGates\EventGateResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditEventGate extends EditRecord
{
    protected static string $resource = EventGateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return EventGateResource::getUrl('index');
    }
}
