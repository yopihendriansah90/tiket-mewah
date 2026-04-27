<?php

namespace App\Filament\Resources\TicketReprints;

use App\Filament\Resources\TicketReprints\Pages\CreateTicketReprint;
use App\Filament\Resources\TicketReprints\Pages\EditTicketReprint;
use App\Filament\Resources\TicketReprints\Pages\ListTicketReprints;
use App\Filament\Resources\TicketReprints\Pages\ViewTicketReprint;
use App\Filament\Resources\TicketReprints\Schemas\TicketReprintForm;
use App\Filament\Resources\TicketReprints\Schemas\TicketReprintInfolist;
use App\Filament\Resources\TicketReprints\Tables\TicketReprintsTable;
use App\Models\TicketReprint;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TicketReprintResource extends Resource
{
    protected static ?string $model = TicketReprint::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|\UnitEnum|null $navigationGroup = 'Operations';

    protected static ?string $navigationLabel = 'Ticket Reprints';

    protected static ?int $navigationSort = 40;

    public static function form(Schema $schema): Schema
    {
        return TicketReprintForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TicketReprintInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TicketReprintsTable::configure($table);
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
            'index' => ListTicketReprints::route('/'),
            'create' => CreateTicketReprint::route('/create'),
            'view' => ViewTicketReprint::route('/{record}'),
            'edit' => EditTicketReprint::route('/{record}/edit'),
        ];
    }
}
