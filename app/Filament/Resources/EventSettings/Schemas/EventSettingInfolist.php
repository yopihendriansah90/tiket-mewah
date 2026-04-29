<?php

namespace App\Filament\Resources\EventSettings\Schemas;

use App\Support\EnumOptions;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EventSettingInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identitas Pengaturan')
                    ->description('Menunjukkan event yang menggunakan konfigurasi ini.')
                    ->schema([
                        TextEntry::make('event.name')
                            ->label('Event')
                            ->placeholder('-'),
                    ])
                    ->columns(1)
                    ->columnSpanFull(),
                Section::make('Tamu Tambahan dan Penggantian')
                    ->description('Ringkasan aturan tamu tambahan serta kebijakan penggantian orang tua atau wali.')
                    ->schema([
                        IconEntry::make('allow_extra_guests')
                            ->label('Izinkan tamu tambahan')
                            ->boolean(),
                        TextEntry::make('extra_guest_limit')
                            ->label('Limit tamu tambahan')
                            ->numeric()
                            ->placeholder('-'),
                        IconEntry::make('extra_guest_requires_helper_approval')
                            ->label('Tamu tambahan butuh approval helper')
                            ->boolean(),
                        IconEntry::make('allow_parent_replacement')
                            ->label('Izinkan penggantian orang tua')
                            ->boolean(),
                        IconEntry::make('parent_replacement_requires_helper_approval')
                            ->label('Penggantian orang tua butuh approval helper')
                            ->boolean(),
                        IconEntry::make('allow_guardian_replacement')
                            ->label('Izinkan penggantian wali')
                            ->boolean(),
                        IconEntry::make('guardian_replacement_requires_helper_approval')
                            ->label('Penggantian wali butuh approval helper')
                            ->boolean(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
                Section::make('Aturan Check-in')
                    ->description('Ringkasan pengaturan operasional check-in di gate event.')
                    ->schema([
                        IconEntry::make('allow_reentry_at_main_gate')
                            ->label('Izinkan masuk ulang di gate utama')
                            ->boolean(),
                        IconEntry::make('reentry_requires_helper_approval')
                            ->label('Masuk ulang butuh approval helper')
                            ->boolean(),
                        IconEntry::make('require_student_to_enter_with_parent')
                            ->label('Siswa wajib masuk dengan orang tua')
                            ->boolean(),
                        IconEntry::make('require_parent_to_enter_with_student')
                            ->label('Orang tua wajib masuk dengan siswa')
                            ->boolean(),
                        IconEntry::make('allow_partial_checkin')
                            ->label('Izinkan check-in parsial')
                            ->boolean(),
                        IconEntry::make('allow_manual_checkin')
                            ->label('Izinkan check-in manual')
                            ->boolean(),
                        IconEntry::make('manual_checkin_requires_reason')
                            ->label('Check-in manual wajib alasan')
                            ->boolean(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
                Section::make('Output Tiket dan Metadata')
                    ->description('Format tiket yang dihasilkan, tipe token QR, dan metadata sistem.')
                    ->schema([
                        IconEntry::make('ticket_output_pdf')
                            ->label('Aktifkan output PDF')
                            ->boolean(),
                        IconEntry::make('ticket_output_png')
                            ->label('Aktifkan output PNG')
                            ->boolean(),
                        TextEntry::make('qr_token_type')
                            ->label('Tipe token QR')
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
            ])
            ->columns(1);
    }
}
