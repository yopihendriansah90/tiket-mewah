<?php

namespace App\Filament\Resources\EventGates;

use App\Filament\Resources\EventGates\Pages\CreateEventGate;
use App\Filament\Resources\EventGates\Pages\EditEventGate;
use App\Filament\Resources\EventGates\Pages\ListEventGates;
use App\Filament\Resources\EventGates\Pages\ViewEventGate;
use App\Filament\Resources\EventGates\Schemas\EventGateForm;
use App\Filament\Resources\EventGates\Schemas\EventGateInfolist;
use App\Filament\Resources\EventGates\Tables\EventGatesTable;
use App\Models\EventGate;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class EventGateResource extends Resource
{
    protected static ?string $model = EventGate::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|\UnitEnum|null $navigationGroup = 'Event Setup';

    protected static ?string $navigationLabel = 'Gates';

    protected static ?int $navigationSort = 30;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return EventGateForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return EventGateInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EventGatesTable::configure($table);
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
            'index' => ListEventGates::route('/'),
            'create' => CreateEventGate::route('/create'),
            'view' => ViewEventGate::route('/{record}'),
            'edit' => EditEventGate::route('/{record}/edit'),
        ];
    }
}
