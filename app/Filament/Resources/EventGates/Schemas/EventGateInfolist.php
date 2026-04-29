<?php

namespace App\Filament\Resources\EventGates\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EventGateInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identitas Gate')
                    ->description('Ringkasan identitas gate untuk kebutuhan operasional event.')
                    ->schema([
                        TextEntry::make('event.name')
                            ->label('Event')
                            ->placeholder('-'),
                        TextEntry::make('name')
                            ->label('Nama gate'),
                        TextEntry::make('code')
                            ->label('Kode gate'),
                        TextEntry::make('location_note')
                            ->label('Catatan lokasi')
                            ->placeholder('-'),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
                Section::make('Status dan Metadata')
                    ->description('Menunjukkan status gate serta waktu pembuatan dan pembaruan data.')
                    ->schema([
                        IconEntry::make('is_active')
                            ->label('Gate aktif')
                            ->boolean(),
                        TextEntry::make('created_at')
                            ->label('Dibuat pada')
                            ->dateTime()
                            ->placeholder('-'),
                        TextEntry::make('updated_at')
                            ->label('Diperbarui pada')
                            ->dateTime()
                            ->placeholder('-'),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ])
            ->columns(1);
    }
}
