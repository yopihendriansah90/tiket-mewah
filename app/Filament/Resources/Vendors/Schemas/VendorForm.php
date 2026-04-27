<?php

namespace App\Filament\Resources\Vendors\Schemas;

use App\Enums\VendorStatus;
use App\Support\EnumOptions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class VendorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                TextInput::make('contact_name'),
                TextInput::make('phone')
                    ->tel(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email(),
                Textarea::make('address')
                    ->columnSpanFull(),
                Select::make('status')
                    ->options(EnumOptions::from(VendorStatus::class))
                    ->required()
                    ->default(VendorStatus::Active->value),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }
}
