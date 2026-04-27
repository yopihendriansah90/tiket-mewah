<?php

namespace App\Filament\Resources\ManualApprovals\Schemas;

use App\Enums\ApprovalStatus;
use App\Enums\ApprovalType;
use App\Support\EnumOptions;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ManualApprovalForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('event_id')
                    ->relationship('event', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('ticket_id')
                    ->relationship('ticket', 'ticket_code')
                    ->searchable()
                    ->preload(),
                Select::make('family_id')
                    ->relationship('family', 'family_code')
                    ->searchable()
                    ->preload(),
                Select::make('issue_id')
                    ->relationship('issue', 'issue_code')
                    ->searchable()
                    ->preload(),
                Select::make('approval_type')
                    ->options(EnumOptions::from(ApprovalType::class))
                    ->required()
                    ->default(ApprovalType::ManualCheckin->value),
                Select::make('requested_by')
                    ->relationship('requester', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('approved_by')
                    ->relationship('approver', 'name')
                    ->searchable()
                    ->preload(),
                Select::make('status')
                    ->options(EnumOptions::from(ApprovalStatus::class))
                    ->required()
                    ->default(ApprovalStatus::Pending->value),
                Textarea::make('reason')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('approval_note')
                    ->columnSpanFull(),
                DateTimePicker::make('approved_at'),
            ]);
    }
}
