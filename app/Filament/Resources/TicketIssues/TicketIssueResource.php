<?php

namespace App\Filament\Resources\TicketIssues;

use App\Filament\Resources\TicketIssues\Pages\CreateTicketIssue;
use App\Filament\Resources\TicketIssues\Pages\EditTicketIssue;
use App\Filament\Resources\TicketIssues\Pages\ListTicketIssues;
use App\Filament\Resources\TicketIssues\Pages\ViewTicketIssue;
use App\Filament\Resources\TicketIssues\Schemas\TicketIssueForm;
use App\Filament\Resources\TicketIssues\Schemas\TicketIssueInfolist;
use App\Filament\Resources\TicketIssues\Tables\TicketIssuesTable;
use App\Models\TicketIssue;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TicketIssueResource extends Resource
{
    protected static ?string $model = TicketIssue::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|\UnitEnum|null $navigationGroup = 'Operations';

    protected static ?string $navigationLabel = 'Ticket Issues';

    protected static ?int $navigationSort = 20;

    protected static ?string $recordTitleAttribute = 'issue_code';

    public static function form(Schema $schema): Schema
    {
        return TicketIssueForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TicketIssueInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TicketIssuesTable::configure($table);
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
            'index' => ListTicketIssues::route('/'),
            'create' => CreateTicketIssue::route('/create'),
            'view' => ViewTicketIssue::route('/{record}'),
            'edit' => EditTicketIssue::route('/{record}/edit'),
        ];
    }
}
