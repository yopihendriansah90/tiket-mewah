<?php

namespace App\Filament\Resources\TicketReprints\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TicketReprintsTable
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
                TextColumn::make('issue.issue_code')
                    ->searchable(),
                TextColumn::make('reprintedBy.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('reprinted_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('file_type')
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
