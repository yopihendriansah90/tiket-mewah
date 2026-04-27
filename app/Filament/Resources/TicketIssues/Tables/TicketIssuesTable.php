<?php

namespace App\Filament\Resources\TicketIssues\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TicketIssuesTable
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
                TextColumn::make('gate.name')
                    ->searchable(),
                TextColumn::make('issue_code')
                    ->searchable(),
                TextColumn::make('issue_type')
                    ->searchable(),
                TextColumn::make('reporter.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('handler.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('approver.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('reported_name')
                    ->searchable(),
                TextColumn::make('reported_phone')
                    ->searchable(),
                TextColumn::make('status')
                    ->searchable(),
                TextColumn::make('resolved_at')
                    ->dateTime()
                    ->sortable(),
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
