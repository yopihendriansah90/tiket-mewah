<?php

namespace App\Filament\Resources\Families\Schemas;

use App\Enums\FamilyStatus;
use App\Support\EnumOptions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class FamilyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('event_id')
                    ->label('Acara')
                    ->relationship('event', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('family_code')
                    ->label('Kode keluarga')
                    ->required(),
                TextInput::make('family_name')
                    ->label('Nama keluarga'),
                TextInput::make('reference_no')
                    ->label('Nomor referensi'),
                TextInput::make('main_student_name')
                    ->label('Nama siswa utama'),
                TextInput::make('class_label')
                    ->label('Label kelas'),
                Textarea::make('notes')
                    ->label('Catatan')
                    ->columnSpanFull(),
                TextInput::make('import_batch_id')
                    ->label('ID batch import'),
                Select::make('status')
                    ->label('Status')
                    ->options(EnumOptions::from(FamilyStatus::class))
                    ->required()
                    ->default(FamilyStatus::Active->value),
            ]);
    }
}
