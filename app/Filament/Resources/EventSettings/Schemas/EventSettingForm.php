<?php

namespace App\Filament\Resources\EventSettings\Schemas;

use App\Enums\QrTokenType;
use App\Support\EnumOptions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class EventSettingForm
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
                Toggle::make('allow_extra_guests')
                    ->required(),
                TextInput::make('extra_guest_limit')
                    ->numeric(),
                Toggle::make('extra_guest_requires_helper_approval')
                    ->required(),
                Toggle::make('allow_parent_replacement')
                    ->required(),
                Toggle::make('parent_replacement_requires_helper_approval')
                    ->required(),
                Toggle::make('allow_guardian_replacement')
                    ->required(),
                Toggle::make('guardian_replacement_requires_helper_approval')
                    ->required(),
                Toggle::make('allow_reentry_at_main_gate')
                    ->required(),
                Toggle::make('reentry_requires_helper_approval')
                    ->required(),
                Toggle::make('require_student_to_enter_with_parent')
                    ->required(),
                Toggle::make('require_parent_to_enter_with_student')
                    ->required(),
                Toggle::make('allow_partial_checkin')
                    ->required(),
                Toggle::make('allow_manual_checkin')
                    ->required(),
                Toggle::make('manual_checkin_requires_reason')
                    ->required(),
                Toggle::make('ticket_output_pdf')
                    ->required(),
                Toggle::make('ticket_output_png')
                    ->required(),
                Select::make('qr_token_type')
                    ->options(EnumOptions::from(QrTokenType::class))
                    ->required()
                    ->default(QrTokenType::Ulid->value),
            ]);
    }
}
