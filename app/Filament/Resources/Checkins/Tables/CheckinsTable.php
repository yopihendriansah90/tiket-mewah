<?php

namespace App\Filament\Resources\Checkins\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CheckinsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('event.name')
                    ->searchable(),
                TextColumn::make('ticket.ticket_code')
                    ->searchable(),
                TextColumn::make('family.family_code')
                    ->searchable(),
                TextColumn::make('familyMember.name')
                    ->searchable(),
                TextColumn::make('gate.name')
                    ->searchable(),
                TextColumn::make('checkedBy.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('checked_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('checkin_method')
                    ->searchable(),
                TextColumn::make('checkin_status')
                    ->searchable(),
                IconColumn::make('counts_as_quota')
                    ->boolean(),
                IconColumn::make('is_extra_guest')
                    ->boolean(),
                IconColumn::make('is_replacement')
                    ->boolean(),
                TextColumn::make('guest_name_snapshot')
                    ->searchable(),
                TextColumn::make('guest_relation_snapshot')
                    ->searchable(),
                TextColumn::make('issue.issue_code')
                    ->searchable(),
                TextColumn::make('approval.id')
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
