<?php

namespace App\Filament\Resources\EventSettings\Pages;

use App\Filament\Resources\EventSettings\EventSettingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEventSettings extends ListRecords
{
    protected static string $resource = EventSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
