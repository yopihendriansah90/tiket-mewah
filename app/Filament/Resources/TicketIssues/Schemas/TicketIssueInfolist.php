<?php

namespace App\Filament\Resources\TicketIssues\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class TicketIssueInfolist
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
                TextEntry::make('gate.name')
                    ->label('Gate')
                    ->placeholder('-'),
                TextEntry::make('issue_code'),
                TextEntry::make('issue_type'),
                TextEntry::make('reported_by')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('handled_by')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('approved_by')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('reported_name')
                    ->placeholder('-'),
                TextEntry::make('reported_phone')
                    ->placeholder('-'),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('resolution')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('status'),
                TextEntry::make('resolved_at')
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
