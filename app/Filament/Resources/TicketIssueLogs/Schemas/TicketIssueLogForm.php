<?php

namespace App\Filament\Resources\TicketIssueLogs\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TicketIssueLogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('ticket_issue_id')
                    ->relationship('issue', 'issue_code')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('action')
                    ->required(),
                TextInput::make('old_status'),
                TextInput::make('new_status'),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }
}
