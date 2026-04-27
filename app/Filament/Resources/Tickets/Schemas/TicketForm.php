<?php

namespace App\Filament\Resources\Tickets\Schemas;

use App\Enums\TicketStatus;
use App\Support\EnumOptions;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TicketForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('event_id')
                    ->relationship('event', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('family_id')
                    ->relationship('family', 'family_code')
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('ticket_code')
                    ->required(),
                TextInput::make('qr_token')
                    ->required(),
                TextInput::make('quota_registered')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('quota_extra_allowed')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('quota_total')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('quota_used')
                    ->required()
                    ->numeric()
                    ->default(0),
                Select::make('status')
                    ->options(EnumOptions::from(TicketStatus::class))
                    ->required()
                    ->default(TicketStatus::Active->value),
                DateTimePicker::make('generated_at'),
                DateTimePicker::make('revoked_at'),
                Select::make('replaced_by_ticket_id')
                    ->relationship('replacementTicket', 'ticket_code')
                    ->searchable()
                    ->preload(),
            ]);
    }
}
