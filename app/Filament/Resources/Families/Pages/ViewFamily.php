<?php

namespace App\Filament\Resources\Families\Pages;

use App\Enums\Gender;
use App\Enums\MemberType;
use App\Filament\Resources\Families\FamilyResource;
use App\Models\FamilyMember;
use App\Support\EnumOptions;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Pages\ViewRecord;

class ViewFamily extends ViewRecord
{
    protected static string $resource = FamilyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make('createFamilyMember')
                ->label('Tambah Anggota')
                ->icon('heroicon-o-user-plus')
                ->model(FamilyMember::class)
                ->modelLabel('anggota keluarga')
                ->authorize(fn (): bool => auth()->user()?->can('Create:FamilyMember') ?? false)
                ->createAnother(false)
                ->form([
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
                        ->default(false)
                        ->required(),
                    Toggle::make('is_registered_member')
                        ->label('Anggota terdaftar')
                        ->hintIcon('heroicon-m-question-mark-circle', 'Jika aktif, anggota ini dihitung ke kuota tiket keluarga.')
                        ->default(true)
                        ->required(),
                    Toggle::make('is_extra_guest')
                        ->label('Tamu tambahan')
                        ->hintIcon('heroicon-m-question-mark-circle', 'Aktifkan untuk tamu tambahan di luar anggota inti atau anggota terdaftar.')
                        ->default(false)
                        ->required(),
                    Toggle::make('is_replacement')
                        ->label('Pengganti')
                        ->hintIcon('heroicon-m-question-mark-circle', 'Aktifkan jika anggota ini menggantikan orang tua, wali, atau anggota lain.')
                        ->default(false)
                        ->required(),
                    Select::make('replaced_member_id')
                        ->label('Anggota yang digantikan')
                        ->hintIcon('heroicon-m-question-mark-circle', 'Pilih anggota lama yang digantikan oleh anggota ini, jika ada.')
                        ->options(fn (): array => $this->record
                            ->members()
                            ->orderBy('name')
                            ->pluck('name', 'id')
                            ->all())
                        ->searchable()
                        ->preload(),
                    Textarea::make('notes')
                        ->label('Catatan')
                        ->hintIcon('heroicon-m-question-mark-circle', 'Catatan internal untuk operator atau admin.')
                        ->columnSpanFull(),
                ])
                ->using(function (array $data): FamilyMember {
                    $data['family_id'] = $this->record->getKey();

                    return FamilyMember::query()->create($data);
                })
                ->successRedirectUrl(fn (): string => FamilyResource::getUrl('view', [
                    'record' => $this->record,
                ])),
            EditAction::make(),
        ];
    }
}
