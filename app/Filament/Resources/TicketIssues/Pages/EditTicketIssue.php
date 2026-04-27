<?php

namespace App\Filament\Resources\TicketIssues\Pages;

use App\Filament\Resources\TicketIssues\TicketIssueResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditTicketIssue extends EditRecord
{
    protected static string $resource = TicketIssueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
