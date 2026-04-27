<?php

namespace App\Filament\Resources\Events\Schemas;

use App\Enums\EventStatus;
use App\Enums\EventType;
use App\Support\EnumOptions;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;

class EventForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('vendor_id')
                    ->relationship('vendor', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                Select::make('event_type')
                    ->options(EnumOptions::from(EventType::class))
                    ->required()
                    ->default(EventType::School->value),
                DatePicker::make('event_date')
                    ->required(),
                TimePicker::make('start_time'),
                TimePicker::make('end_time'),
                TextInput::make('venue_name'),
                Textarea::make('venue_address')
                    ->columnSpanFull(),
                Select::make('status')
                    ->options(EnumOptions::from(EventStatus::class))
                    ->required()
                    ->default(EventStatus::Draft->value),
                Select::make('created_by')
                    ->relationship('creator', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
            ]);
    }
}
