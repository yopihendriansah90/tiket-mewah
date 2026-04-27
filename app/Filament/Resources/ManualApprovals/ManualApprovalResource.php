<?php

namespace App\Filament\Resources\ManualApprovals;

use App\Filament\Resources\ManualApprovals\Pages\CreateManualApproval;
use App\Filament\Resources\ManualApprovals\Pages\EditManualApproval;
use App\Filament\Resources\ManualApprovals\Pages\ListManualApprovals;
use App\Filament\Resources\ManualApprovals\Pages\ViewManualApproval;
use App\Filament\Resources\ManualApprovals\Schemas\ManualApprovalForm;
use App\Filament\Resources\ManualApprovals\Schemas\ManualApprovalInfolist;
use App\Filament\Resources\ManualApprovals\Tables\ManualApprovalsTable;
use App\Models\ManualApproval;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ManualApprovalResource extends Resource
{
    protected static ?string $model = ManualApproval::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|\UnitEnum|null $navigationGroup = 'Operations';

    protected static ?string $navigationLabel = 'Manual Approvals';

    protected static ?int $navigationSort = 30;

    public static function form(Schema $schema): Schema
    {
        return ManualApprovalForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ManualApprovalInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ManualApprovalsTable::configure($table);
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
            'index' => ListManualApprovals::route('/'),
            'create' => CreateManualApproval::route('/create'),
            'view' => ViewManualApproval::route('/{record}'),
            'edit' => EditManualApproval::route('/{record}/edit'),
        ];
    }
}
