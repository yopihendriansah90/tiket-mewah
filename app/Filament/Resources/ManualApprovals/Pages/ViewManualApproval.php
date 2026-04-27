<?php

namespace App\Filament\Resources\ManualApprovals\Pages;

use App\Filament\Resources\ManualApprovals\ManualApprovalResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewManualApproval extends ViewRecord
{
    protected static string $resource = ManualApprovalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
