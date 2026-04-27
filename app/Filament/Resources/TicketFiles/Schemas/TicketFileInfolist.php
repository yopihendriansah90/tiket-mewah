<?php

namespace App\Filament\Resources\TicketFiles\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class TicketFileInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('ticket.id')
                    ->label('Ticket'),
                TextEntry::make('file_type'),
                TextEntry::make('file_path'),
                TextEntry::make('file_name'),
                TextEntry::make('mime_type')
                    ->placeholder('-'),
                TextEntry::make('file_size')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('generated_at')
                    ->dateTime(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
