<?php

namespace App\Filament\Resources\ManualApprovals\Pages;

use App\Filament\Resources\ManualApprovals\ManualApprovalResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListManualApprovals extends ListRecords
{
    protected static string $resource = ManualApprovalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
