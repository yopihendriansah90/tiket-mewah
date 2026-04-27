<?php

namespace App\Filament\Resources\FamilyMembers\Tables;

use App\Support\EnumOptions;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FamilyMembersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('family.family_code')
                    ->label('Kode keluarga')
                    ->searchable(),
                TextColumn::make('member_type')
                    ->label('Tipe anggota')
                    ->formatStateUsing(fn (?string $state): ?string => EnumOptions::label($state))
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable(),
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
                    ->searchable()
                    ->sortable(),
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
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
