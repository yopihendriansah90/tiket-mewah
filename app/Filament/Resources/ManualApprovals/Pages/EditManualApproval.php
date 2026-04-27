<?php

namespace App\Filament\Resources\ManualApprovals\Pages;

use App\Filament\Resources\ManualApprovals\ManualApprovalResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditManualApproval extends EditRecord
{
    protected static string $resource = ManualApprovalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
