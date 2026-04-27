<?php

namespace App\Filament\Resources\EventSettings\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class EventSettingInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('event.name')
                    ->label('Event'),
                IconEntry::make('allow_extra_guests')
                    ->boolean(),
                TextEntry::make('extra_guest_limit')
                    ->numeric()
                    ->placeholder('-'),
                IconEntry::make('extra_guest_requires_helper_approval')
                    ->boolean(),
                IconEntry::make('allow_parent_replacement')
                    ->boolean(),
                IconEntry::make('parent_replacement_requires_helper_approval')
                    ->boolean(),
                IconEntry::make('allow_guardian_replacement')
                    ->boolean(),
                IconEntry::make('guardian_replacement_requires_helper_approval')
                    ->boolean(),
                IconEntry::make('allow_reentry_at_main_gate')
                    ->boolean(),
                IconEntry::make('reentry_requires_helper_approval')
                    ->boolean(),
                IconEntry::make('require_student_to_enter_with_parent')
                    ->boolean(),
                IconEntry::make('require_parent_to_enter_with_student')
                    ->boolean(),
                IconEntry::make('allow_partial_checkin')
                    ->boolean(),
                IconEntry::make('allow_manual_checkin')
                    ->boolean(),
                IconEntry::make('manual_checkin_requires_reason')
                    ->boolean(),
                IconEntry::make('ticket_output_pdf')
                    ->boolean(),
                IconEntry::make('ticket_output_png')
                    ->boolean(),
                TextEntry::make('qr_token_type'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
