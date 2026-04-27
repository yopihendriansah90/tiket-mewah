<?php

namespace App\Filament\Resources\Checkins\Schemas;

use App\Enums\CheckinMethod;
use App\Enums\CheckinStatus;
use App\Support\EnumOptions;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CheckinForm
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
                Select::make('family_member_id')
                    ->relationship('familyMember', 'name')
                    ->searchable()
                    ->preload(),
                Select::make('gate_id')
                    ->relationship('gate', 'name')
                    ->searchable()
                    ->preload(),
                Select::make('checked_by')
                    ->relationship('checkedBy', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                DateTimePicker::make('checked_at')
                    ->required(),
                Select::make('checkin_method')
                    ->options(EnumOptions::from(CheckinMethod::class))
                    ->required()
                    ->default(CheckinMethod::QrScan->value),
                Select::make('checkin_status')
                    ->options(EnumOptions::from(CheckinStatus::class))
                    ->required()
                    ->default(CheckinStatus::Success->value),
                Toggle::make('counts_as_quota')
                    ->required(),
                Toggle::make('is_extra_guest')
                    ->required(),
                Toggle::make('is_replacement')
                    ->required(),
                TextInput::make('guest_name_snapshot'),
                TextInput::make('guest_relation_snapshot'),
                Select::make('issue_id')
                    ->relationship('issue', 'issue_code')
                    ->searchable()
                    ->preload(),
                Select::make('approval_id')
                    ->relationship('approval', 'id')
                    ->searchable()
                    ->preload(),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }
}
