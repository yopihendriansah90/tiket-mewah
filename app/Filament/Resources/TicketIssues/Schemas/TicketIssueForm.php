<?php

namespace App\Filament\Resources\TicketIssues\Schemas;

use App\Enums\IssueStatus;
use App\Enums\IssueType;
use App\Support\EnumOptions;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TicketIssueForm
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
                    ->preload(),
                Select::make('family_id')
                    ->relationship('family', 'family_code')
                    ->searchable()
                    ->preload(),
                Select::make('gate_id')
                    ->relationship('gate', 'name')
                    ->searchable()
                    ->preload(),
                TextInput::make('issue_code')
                    ->required(),
                Select::make('issue_type')
                    ->options(EnumOptions::from(IssueType::class))
                    ->required()
                    ->default(IssueType::Other->value),
                Select::make('reported_by')
                    ->relationship('reporter', 'name')
                    ->searchable()
                    ->preload(),
                Select::make('handled_by')
                    ->relationship('handler', 'name')
                    ->searchable()
                    ->preload(),
                Select::make('approved_by')
                    ->relationship('approver', 'name')
                    ->searchable()
                    ->preload(),
                TextInput::make('reported_name'),
                TextInput::make('reported_phone')
                    ->tel(),
                Textarea::make('description')
                    ->columnSpanFull(),
                Textarea::make('resolution')
                    ->columnSpanFull(),
                Select::make('status')
                    ->options(EnumOptions::from(IssueStatus::class))
                    ->required()
                    ->default(IssueStatus::Open->value),
                DateTimePicker::make('resolved_at'),
            ]);
    }
}
