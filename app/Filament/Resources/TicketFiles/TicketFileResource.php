<?php

namespace App\Filament\Resources\TicketFiles;

use App\Filament\Resources\TicketFiles\Pages\CreateTicketFile;
use App\Filament\Resources\TicketFiles\Pages\EditTicketFile;
use App\Filament\Resources\TicketFiles\Pages\ListTicketFiles;
use App\Filament\Resources\TicketFiles\Pages\ViewTicketFile;
use App\Filament\Resources\TicketFiles\Schemas\TicketFileForm;
use App\Filament\Resources\TicketFiles\Schemas\TicketFileInfolist;
use App\Filament\Resources\TicketFiles\Tables\TicketFilesTable;
use App\Models\TicketFile;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TicketFileResource extends Resource
{
    protected static ?string $model = TicketFile::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|\UnitEnum|null $navigationGroup = 'Ticketing';

    protected static ?string $navigationLabel = 'Ticket Files';

    protected static ?int $navigationSort = 20;

    protected static ?string $recordTitleAttribute = 'file_name';

    public static function form(Schema $schema): Schema
    {
        return TicketFileForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TicketFileInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TicketFilesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTicketFiles::route('/'),
            'create' => CreateTicketFile::route('/create'),
            'view' => ViewTicketFile::route('/{record}'),
            'edit' => EditTicketFile::route('/{record}/edit'),
        ];
    }
}
