<?php

namespace App\Filament\Resources\TicketReprints\Schemas;

use App\Enums\TicketFileType;
use App\Support\EnumOptions;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class TicketReprintForm
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
                Select::make('ticket_id')
                    ->relationship('ticket', 'ticket_code')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('family_id')
                    ->relationship('family', 'family_code')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('issue_id')
                    ->relationship('issue', 'issue_code')
                    ->searchable()
                    ->preload(),
                Select::make('reprinted_by')
                    ->relationship('reprintedBy', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                DateTimePicker::make('reprinted_at')
                    ->required(),
                Textarea::make('reason')
                    ->required()
                    ->columnSpanFull(),
                Select::make('file_type')
                    ->options(EnumOptions::from(TicketFileType::class))
                    ->required()
                    ->default(TicketFileType::Pdf->value),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }
}
