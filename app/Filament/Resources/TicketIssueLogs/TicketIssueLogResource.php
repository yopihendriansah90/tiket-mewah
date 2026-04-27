<?php

namespace App\Filament\Resources\TicketIssueLogs;

use App\Filament\Resources\TicketIssueLogs\Pages\CreateTicketIssueLog;
use App\Filament\Resources\TicketIssueLogs\Pages\EditTicketIssueLog;
use App\Filament\Resources\TicketIssueLogs\Pages\ListTicketIssueLogs;
use App\Filament\Resources\TicketIssueLogs\Pages\ViewTicketIssueLog;
use App\Filament\Resources\TicketIssueLogs\Schemas\TicketIssueLogForm;
use App\Filament\Resources\TicketIssueLogs\Schemas\TicketIssueLogInfolist;
use App\Filament\Resources\TicketIssueLogs\Tables\TicketIssueLogsTable;
use App\Models\TicketIssueLog;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TicketIssueLogResource extends Resource
{
    protected static ?string $model = TicketIssueLog::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|\UnitEnum|null $navigationGroup = 'Audit';

    protected static ?string $navigationLabel = 'Issue Logs';

    protected static ?int $navigationSort = 10;

    public static function form(Schema $schema): Schema
    {
        return TicketIssueLogForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TicketIssueLogInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TicketIssueLogsTable::configure($table);
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
            'index' => ListTicketIssueLogs::route('/'),
            'create' => CreateTicketIssueLog::route('/create'),
            'view' => ViewTicketIssueLog::route('/{record}'),
            'edit' => EditTicketIssueLog::route('/{record}/edit'),
        ];
    }
}
