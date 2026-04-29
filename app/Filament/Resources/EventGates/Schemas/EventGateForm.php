<?php

namespace App\Filament\Resources\EventGates\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EventGateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identitas Gate')
                    ->description('Informasi utama gate yang dipakai untuk identifikasi dan operasional check-in.')
                    ->schema([
                        Select::make('event_id')
                            ->label('Event')
                            ->relationship('event', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        TextInput::make('name')
                            ->label('Nama gate')
                            ->placeholder('Contoh: Gate Utama')
                            ->required(),
                        TextInput::make('code')
                            ->label('Kode gate')
                            ->placeholder('Contoh: GATE-A')
                            ->required(),
                        TextInput::make('location_note')
                            ->label('Catatan lokasi')
                            ->placeholder('Contoh: Sebelah lobby utama'),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
                Section::make('Status Gate')
                    ->description('Tentukan apakah gate ini aktif dan siap digunakan saat operasional event.')
                    ->schema([
                        Toggle::make('is_active')
                            ->label('Gate aktif')
                            ->required(),
                    ])
                    ->columns(1)
                    ->columnSpanFull(),
            ])
            ->columns(1);
    }
}
