<?php

namespace App\Filament\Resources\ManualApprovals\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ManualApprovalInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('event.name')
                    ->label('Event'),
                TextEntry::make('ticket.id')
                    ->label('Ticket')
                    ->placeholder('-'),
                TextEntry::make('family.id')
                    ->label('Family')
                    ->placeholder('-'),
                TextEntry::make('issue.id')
                    ->label('Issue')
                    ->placeholder('-'),
                TextEntry::make('approval_type'),
                TextEntry::make('requested_by')
                    ->numeric(),
                TextEntry::make('approved_by')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('status'),
                TextEntry::make('reason')
                    ->columnSpanFull(),
                TextEntry::make('approval_note')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('approved_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
