<?php

namespace App\Filament\Resources\Events\Schemas;

use App\Support\EnumOptions;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EventInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Utama Event')
                    ->description('Ringkasan identitas event yang dipakai di sistem dan operasional.')
                    ->schema([
                        TextEntry::make('vendor.name')
                            ->label('Vendor')
                            ->placeholder('-'),
                        TextEntry::make('name')
                            ->label('Nama event'),
                        TextEntry::make('slug')
                            ->label('Slug'),
                        TextEntry::make('event_type')
                            ->label('Tipe event')
                            ->formatStateUsing(fn (?string $state): ?string => EnumOptions::label($state)),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
                Section::make('Jadwal dan Lokasi')
                    ->description('Informasi waktu pelaksanaan dan lokasi event.')
                    ->schema([
                        TextEntry::make('event_date')
                            ->label('Tanggal event')
                            ->date(),
                        TextEntry::make('start_time')
                            ->label('Jam mulai')
                            ->time()
                            ->placeholder('-'),
                        TextEntry::make('end_time')
                            ->label('Jam selesai')
                            ->time()
                            ->placeholder('-'),
                        TextEntry::make('venue_name')
                            ->label('Nama venue')
                            ->placeholder('-'),
                        TextEntry::make('venue_address')
                            ->label('Alamat venue')
                            ->placeholder('-')
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
                Section::make('Informasi Sistem')
                    ->description('Status event serta metadata pengelolaan data di panel admin.')
                    ->schema([
                        TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->formatStateUsing(fn (?string $state): ?string => EnumOptions::label($state)),
                        TextEntry::make('creator.name')
                            ->label('Dibuat oleh')
                            ->placeholder('-'),
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
