<?php

namespace App\Filament\Resources\EventSettings\Pages;

use App\Filament\Resources\EventSettings\EventSettingResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewEventSetting extends ViewRecord
{
    protected static string $resource = EventSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
