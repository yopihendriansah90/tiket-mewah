<?php

namespace App\Filament\Resources\TicketReprints\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class TicketReprintInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('event.name')
                    ->label('Event'),
                TextEntry::make('ticket.id')
                    ->label('Ticket'),
                TextEntry::make('family.id')
                    ->label('Family'),
                TextEntry::make('issue.id')
                    ->label('Issue')
                    ->placeholder('-'),
                TextEntry::make('reprinted_by')
                    ->numeric(),
                TextEntry::make('reprinted_at')
                    ->dateTime(),
                TextEntry::make('reason')
                    ->columnSpanFull(),
                TextEntry::make('file_type'),
                TextEntry::make('notes')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
