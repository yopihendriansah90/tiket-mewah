<?php

namespace App\Filament\Resources\Checkins\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class CheckinInfolist
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
                TextEntry::make('familyMember.name')
                    ->label('Family member')
                    ->placeholder('-'),
                TextEntry::make('gate.name')
                    ->label('Gate')
                    ->placeholder('-'),
                TextEntry::make('checked_by')
                    ->numeric(),
                TextEntry::make('checked_at')
                    ->dateTime(),
                TextEntry::make('checkin_method'),
                TextEntry::make('checkin_status'),
                IconEntry::make('counts_as_quota')
                    ->boolean(),
                IconEntry::make('is_extra_guest')
                    ->boolean(),
                IconEntry::make('is_replacement')
                    ->boolean(),
                TextEntry::make('guest_name_snapshot')
                    ->placeholder('-'),
                TextEntry::make('guest_relation_snapshot')
                    ->placeholder('-'),
                TextEntry::make('issue.id')
                    ->label('Issue')
                    ->placeholder('-'),
                TextEntry::make('approval.id')
                    ->label('Approval')
                    ->placeholder('-'),
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
