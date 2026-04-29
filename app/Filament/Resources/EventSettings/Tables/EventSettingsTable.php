<?php

namespace App\Filament\Resources\EventSettings\Tables;

use App\Support\EnumOptions;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class EventSettingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('no')
                    ->label('No')
                    ->rowIndex(),
                TextColumn::make('event.name')
                    ->label('Event')
                    ->searchable(),
                IconColumn::make('allow_extra_guests')
                    ->label('Tamu tambahan')
                    ->boolean(),
                TextColumn::make('extra_guest_limit')
                    ->label('Limit tamu tambahan')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('extra_guest_requires_helper_approval')
                    ->label('Approval helper tamu')
                    ->boolean(),
                IconColumn::make('allow_parent_replacement')
                    ->label('Ganti orang tua')
                    ->boolean(),
                IconColumn::make('parent_replacement_requires_helper_approval')
                    ->label('Approval ganti ortu')
                    ->boolean(),
                IconColumn::make('allow_guardian_replacement')
                    ->label('Ganti wali')
                    ->boolean(),
                IconColumn::make('guardian_replacement_requires_helper_approval')
                    ->label('Approval ganti wali')
                    ->boolean(),
                IconColumn::make('allow_reentry_at_main_gate')
                    ->label('Masuk ulang')
                    ->boolean(),
                IconColumn::make('reentry_requires_helper_approval')
                    ->label('Approval masuk ulang')
                    ->boolean(),
                IconColumn::make('require_student_to_enter_with_parent')
                    ->label('Siswa wajib dengan ortu')
                    ->boolean(),
                IconColumn::make('require_parent_to_enter_with_student')
                    ->label('Ortu wajib dengan siswa')
                    ->boolean(),
                IconColumn::make('allow_partial_checkin')
                    ->label('Check-in parsial')
                    ->boolean(),
                IconColumn::make('allow_manual_checkin')
                    ->label('Check-in manual')
                    ->boolean(),
                IconColumn::make('manual_checkin_requires_reason')
                    ->label('Alasan check-in manual')
                    ->boolean(),
                IconColumn::make('ticket_output_pdf')
                    ->label('Output PDF')
                    ->boolean(),
                IconColumn::make('ticket_output_png')
                    ->label('Output PNG')
                    ->boolean(),
                TextColumn::make('qr_token_type')
                    ->label('Tipe token QR')
                    ->formatStateUsing(fn (?string $state): ?string => EnumOptions::label($state))
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
