<?php

namespace App\Filament\Resources\Events\Tables;

use App\Support\EnumOptions;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class EventsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('no')
                    ->label('No')
                    ->rowIndex(),
                TextColumn::make('vendor.name')
                    ->label('Vendor')
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Nama event')
                    ->searchable(),
                TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable(),
                TextColumn::make('event_type')
                    ->label('Tipe event')
                    ->formatStateUsing(fn (?string $state): ?string => EnumOptions::label($state))
                    ->searchable(),
                TextColumn::make('event_date')
                    ->label('Tanggal event')
                    ->date()
                    ->sortable(),
                TextColumn::make('start_time')
                    ->label('Mulai')
                    ->time()
                    ->sortable(),
                TextColumn::make('end_time')
                    ->label('Selesai')
                    ->time()
                    ->sortable(),
                TextColumn::make('venue_name')
                    ->label('Venue')
                    ->searchable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): ?string => EnumOptions::label($state))
                    ->searchable(),
                TextColumn::make('creator.name')
                    ->label('Dibuat oleh')
                    ->searchable()
                    ->sortable(),
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
