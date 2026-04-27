<?php

namespace App\Filament\Resources\Families\RelationManagers;

use App\Enums\TicketStatus;
use App\Services\Ticket\TicketGeneratorService;
use App\Support\EnumOptions;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use InvalidArgumentException;

class TicketRelationManager extends RelationManager
{
    protected static string $relationship = 'ticket';

    protected static ?string $title = 'Tiket';

    protected static ?string $modelLabel = 'tiket';

    protected static ?string $pluralModelLabel = 'tiket';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('ticket_code')
                    ->label('Kode tiket')
                    ->required(),
                TextInput::make('qr_token')
                    ->label('Token QR')
                    ->required(),
                TextInput::make('quota_registered')
                    ->label('Kuota terdaftar')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('quota_extra_allowed')
                    ->label('Kuota tamu tambahan')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('quota_total')
                    ->label('Total kuota')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('quota_used')
                    ->label('Kuota terpakai')
                    ->required()
                    ->numeric()
                    ->default(0),
                Select::make('status')
                    ->label('Status')
                    ->options(EnumOptions::from(TicketStatus::class))
                    ->required()
                    ->default(TicketStatus::Active->value),
                DateTimePicker::make('generated_at')
                    ->label('Dibuat pada'),
                DateTimePicker::make('revoked_at')
                    ->label('Dicabut pada'),
                Select::make('replaced_by_ticket_id')
                    ->label('Diganti oleh tiket')
                    ->relationship('replacementTicket', 'ticket_code')
                    ->searchable()
                    ->preload(),
            ]);
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('ticket_code')
                    ->label('Kode tiket'),
                TextEntry::make('qr_token')
                    ->label('Token QR'),
                TextEntry::make('quota_registered')
                    ->label('Kuota terdaftar')
                    ->numeric(),
                TextEntry::make('quota_extra_allowed')
                    ->label('Kuota tamu tambahan')
                    ->numeric(),
                TextEntry::make('quota_total')
                    ->label('Total kuota')
                    ->numeric(),
                TextEntry::make('quota_used')
                    ->label('Kuota terpakai')
                    ->numeric(),
                TextEntry::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn (?string $state): ?string => EnumOptions::label($state)),
                TextEntry::make('generated_at')
                    ->label('Dibuat pada')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('revoked_at')
                    ->label('Dicabut pada')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('replacementTicket.ticket_code')
                    ->label('Tiket pengganti')
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->label('Dibuat pada')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->label('Diperbarui pada')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('ticket_code')
            ->columns([
                TextColumn::make('ticket_code')
                    ->label('Kode tiket')
                    ->searchable(),
                TextColumn::make('quota_registered')
                    ->label('Kuota terdaftar')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('quota_extra_allowed')
                    ->label('Kuota tamu tambahan')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('quota_total')
                    ->label('Total kuota')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('quota_used')
                    ->label('Kuota terpakai')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): ?string => EnumOptions::label($state))
                    ->searchable(),
                TextColumn::make('generated_at')
                    ->label('Dibuat pada')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('revoked_at')
                    ->label('Dicabut pada')
                    ->dateTime()
                    ->sortable(),
            ])
            ->headerActions([
                Action::make('generateTicket')
                    ->label('Buat Tiket')
                    ->icon('heroicon-o-qr-code')
                    ->authorize(fn (): bool => auth()->user()?->can('Create:Ticket') ?? false)
                    ->requiresConfirmation()
                    ->action(fn (): null => $this->generateTicket()),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ]);
    }

    private function generateTicket(): null
    {
        try {
            $ticket = app(TicketGeneratorService::class)
                ->generateForFamily($this->getOwnerRecord());

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
}
