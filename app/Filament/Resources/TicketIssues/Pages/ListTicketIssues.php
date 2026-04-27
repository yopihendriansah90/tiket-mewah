<?php

namespace App\Filament\Resources\TicketIssues\Pages;

use App\Filament\Resources\TicketIssues\TicketIssueResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTicketIssues extends ListRecords
{
    protected static string $resource = TicketIssueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
