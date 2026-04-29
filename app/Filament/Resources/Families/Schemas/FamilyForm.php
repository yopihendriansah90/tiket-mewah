<?php

namespace App\Filament\Resources\Families\Schemas;

use App\Enums\FamilyStatus;
use App\Models\Event;
use App\Models\Family;
use App\Support\EnumOptions;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class FamilyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identitas Keluarga')
                    ->description('Isi data utama keluarga yang akan menjadi dasar pembuatan tiket dan pencarian tamu.')
                    ->schema([
                        Select::make('event_id')
                            ->label('Acara')
                            ->relationship('event', 'name')
                            ->searchable()
                            ->preload()
                            ->live()
                            ->required(),
                        TextInput::make('family_code')
                            ->label('Kode keluarga')
                            ->placeholder('Contoh: KLG-GRADUATION-7X9K2M')
                            ->helperText('Bisa diisi manual, atau generate otomatis dengan format KLG-{EVENT}-{RANDOM}.')
                            ->suffixAction(
                                Action::make('generateFamilyCode')
                                    ->icon('heroicon-m-sparkles')
                                    ->tooltip('Generate kode keluarga')
                                    ->disabled(fn (Get $get): bool => blank($get('event_id')))
                                    ->action(fn (Set $set, Get $get) => $set('family_code', self::generateFamilyCode($get('event_id')))),
                                isInline: true,
                            )
                            ->required()
                            ->rule(fn (Get $get, ?Family $record) => Rule::unique(Family::class, 'family_code')
                                ->where(fn ($query) => $query->where('event_id', $get('event_id')))
                                ->ignore($record)),
                        TextInput::make('family_name')
                            ->label('Nama keluarga')
                            ->placeholder('Contoh: Keluarga Budi'),
                        TextInput::make('reference_no')
                            ->label('Nomor referensi')
                            ->placeholder('Nomor invoice, registrasi, atau referensi internal'),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
                Section::make('Data Siswa')
                    ->description('Informasi siswa utama dipakai untuk identifikasi keluarga dan kebutuhan operasional saat event.')
                    ->schema([
                        TextInput::make('main_student_name')
                            ->label('Nama siswa utama')
                            ->placeholder('Nama siswa utama dalam keluarga'),
                        TextInput::make('class_label')
                            ->label('Label kelas')
                            ->placeholder('Contoh: 6A atau TK B'),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
                Section::make('Catatan dan Pengaturan')
                    ->description('Ruang untuk informasi internal, import batch, dan status data keluarga.')
                    ->schema([
                        Textarea::make('notes')
                            ->label('Catatan')
                            ->rows(4)
                            ->placeholder('Catatan internal untuk admin atau operator')
                            ->columnSpanFull(),
                        TextInput::make('import_batch_id')
                            ->label('ID batch import')
                            ->placeholder('Kosongkan jika data dibuat manual'),
                        Select::make('status')
                            ->label('Status')
                            ->options(EnumOptions::from(FamilyStatus::class))
                            ->required()
                            ->default(FamilyStatus::Active->value),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ])
            ->columns(1);
    }

    private static function generateFamilyCode(?int $eventId): string
    {
        $eventSegment = self::eventCodeSegment($eventId);

        for ($attempt = 0; $attempt < 10; $attempt++) {
            $code = "KLG-{$eventSegment}-".Str::upper(Str::random(6));

            if (! Family::query()->where('family_code', $code)->exists()) {
                return $code;
            }
        }

        return "KLG-{$eventSegment}-".now()->format('His');
    }

    private static function eventCodeSegment(?int $eventId): string
    {
        if (! $eventId) {
            return 'EVENT';
        }

        $event = Event::query()->find($eventId);

        $value = $event?->slug ?: $event?->name ?: 'EVENT';

        $segment = Str::of($value)
            ->upper()
            ->replaceMatches('/[^A-Z0-9]+/', '-')
            ->trim('-')
            ->substr(0, 18)
            ->trim('-')
            ->toString();

        return $segment !== '' ? $segment : 'EVENT';
    }
}
