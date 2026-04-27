<?php

namespace App\Filament\Resources\EventSettings\Tables;

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
                TextColumn::make('event.name')
                    ->searchable(),
                IconColumn::make('allow_extra_guests')
                    ->boolean(),
                TextColumn::make('extra_guest_limit')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('extra_guest_requires_helper_approval')
                    ->boolean(),
                IconColumn::make('allow_parent_replacement')
                    ->boolean(),
                IconColumn::make('parent_replacement_requires_helper_approval')
                    ->boolean(),
                IconColumn::make('allow_guardian_replacement')
                    ->boolean(),
                IconColumn::make('guardian_replacement_requires_helper_approval')
                    ->boolean(),
                IconColumn::make('allow_reentry_at_main_gate')
                    ->boolean(),
                IconColumn::make('reentry_requires_helper_approval')
                    ->boolean(),
                IconColumn::make('require_student_to_enter_with_parent')
                    ->boolean(),
                IconColumn::make('require_parent_to_enter_with_student')
                    ->boolean(),
                IconColumn::make('allow_partial_checkin')
                    ->boolean(),
                IconColumn::make('allow_manual_checkin')
                    ->boolean(),
                IconColumn::make('manual_checkin_requires_reason')
                    ->boolean(),
                IconColumn::make('ticket_output_pdf')
                    ->boolean(),
                IconColumn::make('ticket_output_png')
                    ->boolean(),
                TextColumn::make('qr_token_type')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
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
