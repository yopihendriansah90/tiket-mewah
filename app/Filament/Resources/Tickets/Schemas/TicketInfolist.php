<?php

namespace App\Filament\Resources\Tickets\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class TicketInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('event.name')
                    ->label('Event'),
                TextEntry::make('family.id')
                    ->label('Family'),
                TextEntry::make('ticket_code'),
                TextEntry::make('quota_registered')
                    ->numeric(),
                TextEntry::make('quota_extra_allowed')
                    ->numeric(),
                TextEntry::make('quota_total')
                    ->numeric(),
                TextEntry::make('quota_used')
                    ->numeric(),
                TextEntry::make('status'),
                TextEntry::make('generated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('revoked_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('replaced_by_ticket_id')
                    ->numeric()
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
