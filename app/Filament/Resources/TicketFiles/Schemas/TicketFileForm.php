<?php

namespace App\Filament\Resources\TicketFiles\Schemas;

use App\Enums\TicketFileType;
use App\Support\EnumOptions;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TicketFileForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('ticket_id')
                    ->relationship('ticket', 'ticket_code')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('file_type')
                    ->options(EnumOptions::from(TicketFileType::class))
                    ->required()
                    ->default(TicketFileType::Pdf->value),
                TextInput::make('file_path')
                    ->required(),
                TextInput::make('file_name')
                    ->required(),
                TextInput::make('mime_type'),
                TextInput::make('file_size')
                    ->numeric(),
                DateTimePicker::make('generated_at')
                    ->required(),
            ]);
    }
}
