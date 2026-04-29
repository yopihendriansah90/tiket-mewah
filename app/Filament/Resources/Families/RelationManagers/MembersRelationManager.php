<?php

namespace App\Filament\Resources\Families\RelationManagers;

use App\Enums\FamilyMemberCheckinStatus;
use App\Enums\Gender;
use App\Enums\MemberType;
use App\Support\EnumOptions;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\RecordActionsPosition;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Support\Enums\FontWeight;

class MembersRelationManager extends RelationManager
{
    protected static string $relationship = 'members';

    protected static ?string $title = 'Anggota';

    protected static ?string $modelLabel = 'anggota';

    protected static ?string $pluralModelLabel = 'anggota';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
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
                Select::make('relation_label')
                    ->label('Hubungan dengan keluarga')
                    ->hintIcon('heroicon-m-question-mark-circle', 'Pilih hubungan anggota dengan keluarga atau siswa utama agar data lebih konsisten.')
                    ->options([
                        'Ayah' => 'Ayah',
                        'Ibu' => 'Ibu',
                        'Wali Siswa' => 'Wali Siswa',
                        'Lainnya' => 'Lainnya',
                    ])
                    ->searchable()
                    ->preload(),
                Toggle::make('is_primary_student')
                    ->label('Siswa utama')
                    ->hintIcon('heroicon-m-question-mark-circle', 'Aktifkan hanya untuk siswa utama dalam keluarga ini.')
                    ->required()
                    ->default(false),
                Toggle::make('is_registered_member')
                    ->label('Anggota terdaftar')
                    ->hintIcon('heroicon-m-question-mark-circle', 'Jika aktif, anggota ini dihitung ke kuota tiket keluarga.')
                    ->required()
                    ->default(true),
                Toggle::make('is_extra_guest')
                    ->label('Tamu tambahan')
                    ->hintIcon('heroicon-m-question-mark-circle', 'Aktifkan untuk tamu tambahan di luar anggota inti atau anggota terdaftar.')
                    ->required()
                    ->default(false),
                Toggle::make('is_replacement')
                    ->label('Pengganti')
                    ->hintIcon('heroicon-m-question-mark-circle', 'Aktifkan jika anggota ini menggantikan orang tua, wali, atau anggota lain.')
                    ->required()
                    ->default(false),
                Select::make('replaced_member_id')
                    ->label('Anggota yang digantikan')
                    ->hintIcon('heroicon-m-question-mark-circle', 'Pilih anggota lama yang digantikan oleh anggota ini, jika ada.')
                    ->relationship('replacedMember', 'name')
                    ->searchable()
                    ->preload(),
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

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('member_type')
                    ->label('Tipe anggota')
                    ->formatStateUsing(fn (?string $state): ?string => EnumOptions::label($state)),
                TextEntry::make('name')
                    ->label('Nama'),
                TextEntry::make('gender')
                    ->label('Jenis kelamin')
                    ->formatStateUsing(fn (?string $state): ?string => EnumOptions::label($state)),
                TextEntry::make('class_name')
                    ->label('Kelas')
                    ->placeholder('-'),
                TextEntry::make('relation_label')
                    ->label('Hubungan dengan siswa')
                    ->placeholder('-'),
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
                    ->placeholder('-'),
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
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->recordAction('view')
            ->columns([
                TextColumn::make('no')
                    ->label('No')
                    ->rowIndex(),
                TextColumn::make('member_type')
                    ->label('Tipe anggota')
                    ->formatStateUsing(fn (?string $state): ?string => EnumOptions::label($state))
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->color('primary')
                    ->weight(FontWeight::Medium)
                    ->action(
                        ViewAction::make('viewFromName')
                            ->label('Lihat')
                            ->icon('heroicon-o-eye'),
                    ),
                TextColumn::make('gender')
                    ->label('Jenis kelamin')
                    ->formatStateUsing(fn (?string $state): ?string => EnumOptions::label($state))
                    ->searchable(),
                TextColumn::make('class_name')
                    ->label('Kelas')
                    ->searchable(),
                TextColumn::make('relation_label')
                    ->label('Hubungan')
                    ->searchable(),
                IconColumn::make('is_primary_student')
                    ->label('Siswa utama')
                    ->boolean(),
                IconColumn::make('is_registered_member')
                    ->label('Terdaftar')
                    ->boolean(),
                IconColumn::make('is_extra_guest')
                    ->label('Tamu tambahan')
                    ->boolean(),
                IconColumn::make('is_replacement')
                    ->label('Pengganti')
                    ->boolean(),
                TextColumn::make('replacedMember.name')
                    ->label('Menggantikan')
                    ->searchable(),
                TextColumn::make('checkin_status')
                    ->label('Status check-in')
                    ->formatStateUsing(fn (?string $state): ?string => EnumOptions::label($state))
                    ->searchable(),
                TextColumn::make('checked_in_at')
                    ->label('Waktu check-in')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('checkedInBy.name')
                    ->label('Check-in oleh')
                    ->searchable(),
                TextColumn::make('checkedInGate.name')
                    ->label('Gate check-in')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Dibuat pada')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Diperbarui pada')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('member_type')
                    ->label('Tipe anggota')
                    ->options(EnumOptions::from(MemberType::class)),
                SelectFilter::make('checkin_status')
                    ->label('Status check-in')
                    ->options(EnumOptions::from(FamilyMemberCheckinStatus::class)),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Tambah Anggota')
                    ->icon('heroicon-o-user-plus'),
            ])
            ->recordActions([
                ViewAction::make()
                    ->label('Lihat')
                    ->icon('heroicon-o-eye')
                    ->link()
                    ->color('gray'),
                EditAction::make()
                    ->label('Edit')
                    ->icon('heroicon-o-pencil-square')
                    ->link()
                    ->color('warning')
                    ->modalHeading('Edit Anggota')
                    ->modalSubmitActionLabel('Simpan perubahan'),
                DeleteAction::make(),
            ], position: RecordActionsPosition::BeforeColumns)
            ->recordActionsColumnLabel('Aksi')
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
