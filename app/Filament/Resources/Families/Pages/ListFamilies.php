<?php

namespace App\Filament\Resources\Families\Pages;

use App\Filament\Resources\Families\FamilyResource;
use App\Models\Event;
use App\Services\Import\FamilyCsvImportService;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Storage;

class ListFamilies extends ListRecords
{
    protected static string $resource = FamilyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('downloadTemplate')
                ->label('Download Template')
                ->icon('heroicon-o-arrow-down-tray')
                ->action(fn () => response()->download(Storage::path('templates/family-import-template.csv'))),
            Action::make('importFamilies')
                ->label('Import CSV')
                ->icon('heroicon-o-arrow-up-tray')
                ->form([
                    Select::make('event_id')
                        ->label('Event')
                        ->options(Event::query()->orderBy('name')->pluck('name', 'id'))
                        ->searchable()
                        ->required(),
                    FileUpload::make('csv_file')
                        ->label('File CSV')
                        ->acceptedFileTypes(['text/csv', 'text/plain'])
                        ->disk('local')
                        ->directory('imports/families')
                        ->required(),
                ])
                ->action(function (array $data): void {
                    $event = Event::query()->findOrFail((int) $data['event_id']);
                    $path = (string) $data['csv_file'];
                    $fullPath = Storage::disk('local')->path($path);
                    $uploaded = new \Illuminate\Http\UploadedFile($fullPath, basename($fullPath), 'text/csv', null, true);

                    $result = app(FamilyCsvImportService::class)->import($event, $uploaded);

                    $errorCount = count($result['errors']);
                    $message = "Batch {$result['batch_id']}: {$result['family_created']} keluarga baru, {$result['family_updated']} keluarga diupdate, {$result['member_created']} member diproses.";

                    if ($errorCount > 0) {
                        $message .= " Gagal: {$errorCount}.";
                    }

                    Notification::make()
                        ->title('Import keluarga selesai')
                        ->body($message)
                        ->color($errorCount > 0 ? 'warning' : 'success')
                        ->send();
                }),
            CreateAction::make(),
        ];
    }
}
