<?php

namespace App\Filament\Resources\TicketIssues\Pages;

use App\Filament\Resources\TicketIssues\TicketIssueResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTicketIssue extends ViewRecord
{
    protected static string $resource = TicketIssueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
