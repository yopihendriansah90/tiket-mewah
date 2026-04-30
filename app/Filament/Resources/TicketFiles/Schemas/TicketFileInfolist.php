<?php

declare(strict_types=1);

namespace App\Filament\Resources\TicketFiles\Schemas;

use App\Models\TicketFile;
use Filament\Actions\Action;
use Filament\Infolists\Components\Actions;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class TicketFileInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Preview File')
                    ->schema([
                        ImageEntry::make('file_path')
                            ->label('')
                            ->disk('local')
                            ->visibility('private')
                            ->imageWidth('100%')
                            ->imageHeight('auto')
                            ->hidden(fn (TicketFile $record): bool => ! $record->canPreviewInline()),
                        Actions::make([
                            Action::make('preview')
                                ->label('Open Preview')
                                ->icon('heroicon-o-eye')
                                ->url(fn (TicketFile $record): ?string => $record->previewUrl(), shouldOpenInNewTab: true),
                            Action::make('download')
                                ->label('Download File')
                                ->icon('heroicon-o-arrow-down-tray')
                                ->url(fn (TicketFile $record): ?string => $record->previewUrl(), shouldOpenInNewTab: true),
                        ]),
                    ])
                    ->columnSpanFull(),
                Section::make('Metadata')
                    ->schema([
                        TextEntry::make('ticket.ticket_code')
                            ->label('Ticket'),
                        TextEntry::make('file_type')
                            ->label('Tipe file'),
                        TextEntry::make('file_path')
                            ->label('Path file'),
                        TextEntry::make('file_name')
                            ->label('Nama file'),
                        TextEntry::make('mime_type')
                            ->label('MIME type')
                            ->placeholder('-'),
                        TextEntry::make('file_size')
                            ->label('Ukuran file')
                            ->numeric()
                            ->placeholder('-'),
                        TextEntry::make('generated_at')
                            ->label('Generated')
                            ->dateTime(),
                        TextEntry::make('created_at')
                            ->label('Created')
                            ->dateTime()
                            ->placeholder('-'),
                        TextEntry::make('updated_at')
                            ->label('Updated')
                            ->dateTime()
                            ->placeholder('-'),
                    ])
                    ->columns(2),
            ]);
    }
}
