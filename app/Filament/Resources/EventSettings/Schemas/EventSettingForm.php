<?php

namespace App\Filament\Resources\EventSettings\Schemas;

use App\Enums\QrTokenType;
use App\Support\EnumOptions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EventSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Event dan Identitas Pengaturan')
                    ->description('Hubungkan pengaturan ini ke event yang tepat sebelum mengatur aturan operasional.')
                    ->schema([
                        Select::make('event_id')
                            ->label('Event')
                            ->relationship('event', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                    ])
                    ->columns(1)
                    ->columnSpanFull(),
                Section::make('Tamu Tambahan dan Penggantian')
                    ->description('Atur apakah event mengizinkan tamu tambahan serta penggantian orang tua atau wali.')
                    ->schema([
                        Toggle::make('allow_extra_guests')
                            ->label('Izinkan tamu tambahan')
                            ->required(),
                        TextInput::make('extra_guest_limit')
                            ->label('Limit tamu tambahan')
                            ->numeric(),
                        Toggle::make('extra_guest_requires_helper_approval')
                            ->label('Tamu tambahan butuh approval helper')
                            ->required(),
                        Toggle::make('allow_parent_replacement')
                            ->label('Izinkan penggantian orang tua')
                            ->required(),
                        Toggle::make('parent_replacement_requires_helper_approval')
                            ->label('Penggantian orang tua butuh approval helper')
                            ->required(),
                        Toggle::make('allow_guardian_replacement')
                            ->label('Izinkan penggantian wali')
                            ->required(),
                        Toggle::make('guardian_replacement_requires_helper_approval')
                            ->label('Penggantian wali butuh approval helper')
                            ->required(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
                Section::make('Aturan Check-in')
                    ->description('Atur perilaku masuk ulang, check-in parsial, dan check-in manual saat event berlangsung.')
                    ->schema([
                        Toggle::make('allow_reentry_at_main_gate')
                            ->label('Izinkan masuk ulang di gate utama')
                            ->required(),
                        Toggle::make('reentry_requires_helper_approval')
                            ->label('Masuk ulang butuh approval helper')
                            ->required(),
                        Toggle::make('require_student_to_enter_with_parent')
                            ->label('Siswa wajib masuk dengan orang tua')
                            ->required(),
                        Toggle::make('require_parent_to_enter_with_student')
                            ->label('Orang tua wajib masuk dengan siswa')
                            ->required(),
                        Toggle::make('allow_partial_checkin')
                            ->label('Izinkan check-in parsial')
                            ->required(),
                        Toggle::make('allow_manual_checkin')
                            ->label('Izinkan check-in manual')
                            ->required(),
                        Toggle::make('manual_checkin_requires_reason')
                            ->label('Check-in manual wajib alasan')
                            ->required(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
                Section::make('Output Tiket dan Token QR')
                    ->description('Tentukan format file tiket yang dihasilkan dan tipe token QR yang digunakan.')
                    ->schema([
                        Toggle::make('ticket_output_pdf')
                            ->label('Aktifkan output PDF')
                            ->required(),
                        Toggle::make('ticket_output_png')
                            ->label('Aktifkan output PNG')
                            ->required(),
                        Select::make('qr_token_type')
                            ->label('Tipe token QR')
                            ->options(EnumOptions::from(QrTokenType::class))
                            ->required()
                            ->default(QrTokenType::Ulid->value),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ])
            ->columns(1);
    }
}
