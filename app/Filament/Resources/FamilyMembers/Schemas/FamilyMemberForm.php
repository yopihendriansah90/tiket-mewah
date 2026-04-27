<?php

namespace App\Filament\Resources\FamilyMembers\Schemas;

use App\Enums\FamilyMemberCheckinStatus;
use App\Enums\Gender;
use App\Enums\MemberType;
use App\Support\EnumOptions;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class FamilyMemberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('family_id')
                    ->label('Keluarga')
                    ->hintIcon('heroicon-m-question-mark-circle', 'Keluarga pemilik anggota ini.')
                    ->relationship('family', 'family_code')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('member_type')
                    ->label('Tipe anggota')
                    ->hintIcon('heroicon-m-question-mark-circle', 'Kategori sistem untuk aturan tiket dan check-in, misalnya Siswa, Ayah, Ibu, Wali, Pengganti, atau Tamu tambahan.')
                    ->options(EnumOptions::from(MemberType::class))
                    ->required()
                    ->default(MemberType::Student->value),
                TextInput::make('name')
                    ->label('Nama')
                    ->hintIcon('heroicon-m-question-mark-circle', 'Nama anggota keluarga yang akan muncul pada data tamu dan proses check-in.')
                    ->required(),
                Select::make('gender')
                    ->label('Jenis kelamin')
                    ->hintIcon('heroicon-m-question-mark-circle', 'Dipakai untuk identifikasi data tamu dan kebutuhan laporan.')
                    ->options(EnumOptions::from(Gender::class))
                    ->required()
                    ->default(Gender::Unknown->value),
                TextInput::make('class_name')
                    ->label('Kelas')
                    ->hintIcon('heroicon-m-question-mark-circle', 'Isi kelas siswa jika anggota ini adalah siswa. Boleh dikosongkan untuk orang tua atau tamu.'),
                TextInput::make('relation_label')
                    ->label('Hubungan dengan siswa')
                    ->hintIcon('heroicon-m-question-mark-circle', 'Label bebas seperti Ayah, Ibu, Wali, Paman, Tante, atau Pendamping untuk memperjelas hubungan anggota dengan siswa.'),
                Toggle::make('is_primary_student')
                    ->label('Siswa utama')
                    ->hintIcon('heroicon-m-question-mark-circle', 'Aktifkan hanya untuk siswa utama dalam keluarga ini.')
                    ->required(),
                Toggle::make('is_registered_member')
                    ->label('Anggota terdaftar')
                    ->hintIcon('heroicon-m-question-mark-circle', 'Jika aktif, anggota ini dihitung ke kuota tiket keluarga.')
                    ->required(),
                Toggle::make('is_extra_guest')
                    ->label('Tamu tambahan')
                    ->hintIcon('heroicon-m-question-mark-circle', 'Aktifkan untuk tamu tambahan di luar anggota inti atau anggota terdaftar.')
                    ->required(),
                Toggle::make('is_replacement')
                    ->label('Pengganti')
                    ->hintIcon('heroicon-m-question-mark-circle', 'Aktifkan jika anggota ini menggantikan orang tua, wali, atau anggota lain.')
                    ->required(),
                Select::make('replaced_member_id')
                    ->label('Anggota yang digantikan')
                    ->hintIcon('heroicon-m-question-mark-circle', 'Pilih anggota lama yang digantikan oleh anggota ini, jika ada.')
                    ->relationship('replacedMember', 'name'),
                Select::make('checkin_status')
                    ->label('Status check-in')
                    ->hintIcon('heroicon-m-question-mark-circle', 'Dikelola oleh proses check-in operasional, bukan dari edit data master.')
                    ->options(EnumOptions::from(FamilyMemberCheckinStatus::class))
                    ->required()
                    ->default(FamilyMemberCheckinStatus::Pending->value)
                    ->disabled()
                    ->dehydrated(false),
                DateTimePicker::make('checked_in_at')
                    ->label('Waktu check-in')
                    ->hintIcon('heroicon-m-question-mark-circle', 'Terisi otomatis saat anggota berhasil check-in.')
                    ->disabled()
                    ->dehydrated(false),
                Select::make('checked_in_by')
                    ->label('Check-in oleh')
                    ->hintIcon('heroicon-m-question-mark-circle', 'User operator yang melakukan check-in.')
                    ->relationship('checkedInBy', 'name')
                    ->searchable()
                    ->preload()
                    ->disabled()
                    ->dehydrated(false),
                Select::make('checked_in_gate_id')
                    ->label('Gate check-in')
                    ->hintIcon('heroicon-m-question-mark-circle', 'Gate tempat anggota melakukan check-in.')
                    ->relationship('checkedInGate', 'name')
                    ->searchable()
                    ->preload()
                    ->disabled()
                    ->dehydrated(false),
                Textarea::make('notes')
                    ->label('Catatan')
                    ->hintIcon('heroicon-m-question-mark-circle', 'Catatan internal untuk operator atau admin.')
                    ->columnSpanFull(),
            ]);
    }
}
