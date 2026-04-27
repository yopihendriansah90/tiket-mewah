<?php

namespace App\Filament\Resources\Families\Schemas;

use App\Support\EnumOptions;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FamilyInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Data Keluarga')
                    ->schema([
                        TextEntry::make('event.name')
                            ->label('Acara'),
                        TextEntry::make('family_code')
                            ->label('Kode keluarga'),
                        TextEntry::make('family_name')
                            ->label('Nama keluarga')
                            ->placeholder('-'),
                        TextEntry::make('reference_no')
                            ->label('Nomor referensi')
                            ->placeholder('-'),
                        TextEntry::make('main_student_name')
                            ->label('Nama siswa utama')
                            ->placeholder('-'),
                        TextEntry::make('class_label')
                            ->label('Label kelas')
                            ->placeholder('-'),
                        TextEntry::make('notes')
                            ->label('Catatan')
                            ->placeholder('-')
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
                Section::make('Informasi Sistem')
                    ->schema([
                        TextEntry::make('import_batch_id')
                            ->label('ID batch import')
                            ->placeholder('-'),
                        TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->formatStateUsing(fn (?string $state): ?string => EnumOptions::label($state)),
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
            ]);
    }
}
