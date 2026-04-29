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
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class EventForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Utama Event')
                    ->description('Data dasar event yang dipakai untuk identitas, pencarian, dan pengelompokan operasional.')
                    ->schema([
                        Select::make('vendor_id')
                            ->label('Vendor')
                            ->relationship('vendor', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        TextInput::make('name')
                            ->label('Nama event')
                            ->placeholder('Contoh: Graduation Night 2026')
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug((string) $state)))
                            ->required(),
                        TextInput::make('slug')
                            ->label('Slug')
                            ->placeholder('Contoh: graduation-night-2026')
                            ->helperText('Slug dibuat otomatis dari nama event agar format tetap konsisten.')
                            ->disabled()
                            ->dehydrated()
                            ->required(),
                        Select::make('event_type')
                            ->label('Tipe event')
                            ->options(EnumOptions::from(EventType::class))
                            ->required()
                            ->default(EventType::School->value),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
                Section::make('Jadwal dan Lokasi')
                    ->description('Atur tanggal pelaksanaan, jam event, serta lokasi penyelenggaraan.')
                    ->schema([
                        DatePicker::make('event_date')
                            ->label('Tanggal event')
                            ->required(),
                        TimePicker::make('start_time')
                            ->label('Jam mulai'),
                        TimePicker::make('end_time')
                            ->label('Jam selesai'),
                        TextInput::make('venue_name')
                            ->label('Nama venue')
                            ->placeholder('Contoh: Aula Utama Sekolah'),
                        Textarea::make('venue_address')
                            ->label('Alamat venue')
                            ->placeholder('Alamat lengkap lokasi event')
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
                Section::make('Pengaturan Sistem')
                    ->description('Status event dan penanggung jawab data pada sistem admin.')
                    ->schema([
                        Select::make('status')
                            ->label('Status')
                            ->options(EnumOptions::from(EventStatus::class))
                            ->required()
                            ->default(EventStatus::Draft->value),
                        Select::make('created_by')
                            ->label('Dibuat oleh')
                            ->relationship('creator', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ])
            ->columns(1);
    }
}
