<?php

namespace App\Filament\Resources\FamilyMembers\Schemas;

use App\Support\EnumOptions;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FamilyMemberInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identitas Anggota')
                    ->description('Informasi utama anggota keluarga yang digunakan untuk identifikasi data tamu.')
                    ->schema([
                        TextEntry::make('family.family_code')
                            ->label('Kode keluarga')
                            ->placeholder('-'),
                        TextEntry::make('name')
                            ->label('Nama'),
                        TextEntry::make('member_type')
                            ->label('Tipe anggota')
                            ->formatStateUsing(fn (?string $state): ?string => EnumOptions::label($state)),
                        TextEntry::make('gender')
                            ->label('Jenis kelamin')
                            ->formatStateUsing(fn (?string $state): ?string => EnumOptions::label($state)),
                        TextEntry::make('class_name')
                            ->label('Kelas')
                            ->placeholder('-'),
                        TextEntry::make('relation_label')
                            ->label('Hubungan dengan siswa')
                            ->placeholder('-'),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
                Section::make('Status Keanggotaan')
                    ->description('Menjelaskan peran anggota dalam keluarga dan kaitannya dengan kuota tiket.')
                    ->schema([
                        IconEntry::make('is_primary_student')
                            ->label('Siswa utama')
                            ->boolean(),
                        IconEntry::make('is_registered_member')
                            ->label('Anggota terdaftar')
                            ->boolean(),
                        IconEntry::make('is_extra_guest')
                            ->label('Tamu tambahan')
                            ->boolean(),
                        IconEntry::make('is_replacement')
                            ->label('Pengganti')
                            ->boolean(),
                        TextEntry::make('replacedMember.name')
                            ->label('Anggota yang digantikan')
                            ->placeholder('-')
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
                Section::make('Status Check-in')
                    ->description('Informasi operasional yang terisi saat anggota melakukan check-in di event.')
                    ->schema([
                        TextEntry::make('checkin_status')
                            ->label('Status check-in')
                            ->formatStateUsing(fn (?string $state): ?string => EnumOptions::label($state)),
                        TextEntry::make('checked_in_at')
                            ->label('Waktu check-in')
                            ->dateTime()
                            ->placeholder('-'),
                        TextEntry::make('checkedInBy.name')
                            ->label('Check-in oleh')
                            ->placeholder('-'),
                        TextEntry::make('checkedInGate.name')
                            ->label('Gate check-in')
                            ->placeholder('-'),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
                Section::make('Catatan dan Riwayat')
                    ->description('Catatan internal serta waktu pembuatan dan pembaruan data anggota.')
                    ->schema([
                        TextEntry::make('notes')
                            ->label('Catatan')
                            ->placeholder('-')
                            ->columnSpanFull(),
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
