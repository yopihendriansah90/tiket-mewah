<?php

namespace App\Filament\Resources\Tickets\Tables;

use App\Enums\TicketStatus;
use App\Models\Ticket;
use App\Support\TicketFileActions;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TicketsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('event.name')
                    ->searchable(),
                TextColumn::make('family.family_code')
                    ->searchable(),
                TextColumn::make('qr_token')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('ticket_code')
                    ->searchable(),
                TextColumn::make('quota_registered')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('quota_extra_allowed')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('quota_total')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('quota_used')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('status')
                    ->searchable(),
                TextColumn::make('generated_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('revoked_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('replacementTicket.ticket_code')
                    ->searchable()
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
                TicketFileActions::generateConfigured(),
                TicketFileActions::downloadPdf(),
                TicketFileActions::downloadPng(),
                Action::make('deactivate')
                    ->label('Nonaktifkan')
                    ->icon('heroicon-o-no-symbol')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Nonaktifkan Tiket')
                    ->modalDescription('Gunakan aksi ini jika tiket dicuri atau tidak boleh dipakai lagi. Tiket akan diubah menjadi tidak aktif.')
                    ->visible(fn (Ticket $record): bool => ! in_array($record->status, [
                        TicketStatus::Revoked->value,
                        TicketStatus::Cancelled->value,
                        TicketStatus::Replaced->value,
                    ], true))
                    ->action(function (Ticket $record): void {
                        $record->deactivate();
                    })
                    ->successNotificationTitle('Tiket berhasil dinonaktifkan'),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
