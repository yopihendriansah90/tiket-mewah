<?php

namespace App\Filament\Resources\Events\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class EventInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('vendor.name')
                    ->label('Vendor'),
                TextEntry::make('name'),
                TextEntry::make('slug'),
                TextEntry::make('event_type'),
                TextEntry::make('event_date')
                    ->date(),
                TextEntry::make('start_time')
                    ->time()
                    ->placeholder('-'),
                TextEntry::make('end_time')
                    ->time()
                    ->placeholder('-'),
                TextEntry::make('venue_name')
                    ->placeholder('-'),
                TextEntry::make('venue_address')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('status'),
                TextEntry::make('created_by')
                    ->numeric(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
