<?php

namespace App\Filament\Resources\Families\Tables;

use App\Enums\FamilyStatus;
use App\Models\Family;
use App\Services\Ticket\TicketGeneratorService;
use App\Support\EnumOptions;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Collection;
use InvalidArgumentException;

class FamiliesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('event.name')
                    ->label('Acara')
                    ->searchable(),
                TextColumn::make('family_code')
                    ->label('Kode keluarga')
                    ->searchable(),
                TextColumn::make('family_name')
                    ->label('Nama keluarga')
                    ->searchable(),
                TextColumn::make('reference_no')
                    ->label('Nomor referensi')
                    ->searchable(),
                TextColumn::make('main_student_name')
                    ->label('Nama siswa utama')
                    ->searchable(),
                TextColumn::make('class_label')
                    ->label('Label kelas')
                    ->searchable(),
                TextColumn::make('import_batch_id')
                    ->label('ID batch import')
                    ->searchable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
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
                SelectFilter::make('event_id')
                    ->label('Acara')
                    ->relationship('event', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('status')
                    ->label('Status')
                    ->options(EnumOptions::from(FamilyStatus::class)),
            ])
            ->recordActions([
                Action::make('generateTicket')
                    ->label('Buat Tiket')
                    ->icon('heroicon-o-qr-code')
                    ->authorize(fn (): bool => auth()->user()?->can('Create:Ticket') ?? false)
                    ->requiresConfirmation()
                    ->action(fn (Family $record): null => self::generateTicket($record)),
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('generateTickets')
                        ->label('Buat Tiket')
                        ->icon('heroicon-o-qr-code')
                        ->authorize(fn (): bool => auth()->user()?->can('Create:Ticket') ?? false)
                        ->requiresConfirmation()
                        ->action(fn (Collection $records): null => self::generateTickets($records)),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    private static function generateTicket(Family $family): null
    {
        try {
            $ticket = app(TicketGeneratorService::class)->generateForFamily($family);

            Notification::make()
                ->title("Tiket {$ticket->ticket_code} berhasil dibuat")
                ->success()
                ->send();
        } catch (InvalidArgumentException $exception) {
            Notification::make()
                ->title($exception->getMessage())
                ->danger()
                ->send();
        }

        return null;
    }

    private static function generateTickets(Collection $families): null
    {
        $success = 0;
        $failed = 0;

        $families->each(function (Family $family) use (&$success, &$failed): void {
            try {
                app(TicketGeneratorService::class)->generateForFamily($family);
                $success++;
            } catch (InvalidArgumentException) {
                $failed++;
            }
        });

        $notification = Notification::make()
            ->title("Pembuatan tiket selesai: {$success} berhasil, {$failed} gagal");

        $failed > 0
            ? $notification->warning()
            : $notification->success();

        $notification->send();

        return null;
    }
}
