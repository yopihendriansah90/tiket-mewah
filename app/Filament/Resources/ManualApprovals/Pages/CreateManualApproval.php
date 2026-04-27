<?php

namespace App\Filament\Resources\ManualApprovals\Pages;

use App\Filament\Resources\ManualApprovals\ManualApprovalResource;
use Filament\Resources\Pages\CreateRecord;

class CreateManualApproval extends CreateRecord
{
    protected static string $resource = ManualApprovalResource::class;
}
