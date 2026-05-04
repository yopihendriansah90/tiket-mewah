<?php

declare(strict_types=1);

namespace App\Services\Import;

use App\Enums\FamilyMemberCheckinStatus;
use App\Enums\FamilyStatus;
use App\Enums\Gender;
use App\Enums\MemberType;
use App\Models\Event;
use App\Models\Family;
use App\Models\FamilyMember;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use InvalidArgumentException;

class FamilyCsvImportService
{
    public function import(Event $event, UploadedFile $file): array
    {
        if (strtolower((string) $file->getClientOriginalExtension()) !== 'csv') {
            throw new InvalidArgumentException('File harus berformat CSV.');
        }

        $content = (string) file_get_contents($file->getRealPath());
        $rows = $this->parseCsv($content);

        if ($rows === []) {
            throw new InvalidArgumentException('File CSV kosong.');
        }

        $batchId = 'BATCH-'.Str::upper(Str::random(10));
        $grouped = collect($rows)->groupBy(fn (array $row): string => $row['family_code']);

        $summary = [
            'batch_id' => $batchId,
            'family_created' => 0,
            'family_updated' => 0,
            'member_created' => 0,
            'errors' => [],
        ];

        foreach ($grouped as $familyCode => $members) {
            try {
                DB::transaction(function () use ($event, $members, $familyCode, $batchId, &$summary): void {
                    $familyRow = $members->first();

                    $family = Family::query()->firstOrNew([
                        'event_id' => $event->id,
                        'family_code' => $familyCode,
                    ]);

                    $isNew = ! $family->exists;

                    $family->fill([
                        'family_name' => $familyRow['family_name'] ?: null,
                        'reference_no' => $familyRow['reference_no'] ?: null,
                        'main_student_name' => $familyRow['main_student_name'] ?: null,
                        'class_label' => $familyRow['class_label'] ?: null,
                        'notes' => $familyRow['notes'] ?: null,
                        'import_batch_id' => $batchId,
                        'status' => FamilyStatus::Active->value,
                    ]);
                    $family->save();

                    if ($isNew) {
                        $summary['family_created']++;
                    } else {
                        $summary['family_updated']++;
                    }

                    $family->members()->delete();

                    $hasRegistered = false;

                    foreach ($members as $row) {
                        $isRegistered = $this->toBool($row['is_registered_member']);
                        $isPrimaryStudent = $this->toBool($row['is_primary_student']);
                        $isExtraGuest = $this->toBool($row['is_extra_guest']);

                        if ($isRegistered) {
                            $hasRegistered = true;
                        }

                        FamilyMember::query()->create([
                            'family_id' => $family->id,
                            'member_type' => $this->validateMemberType($row['member_type']),
                            'name' => $row['member_name'],
                            'gender' => $this->validateGender($row['gender']),
                            'class_name' => $row['member_class_name'] ?: null,
                            'relation_label' => $row['relation_label'] ?: null,
                            'is_primary_student' => $isPrimaryStudent,
                            'is_registered_member' => $isRegistered,
                            'is_extra_guest' => $isExtraGuest,
                            'is_replacement' => false,
                            'checkin_status' => FamilyMemberCheckinStatus::Pending->value,
                            'notes' => $row['member_notes'] ?: null,
                        ]);

                        $summary['member_created']++;
                    }

                    if (! $hasRegistered) {
                        throw new InvalidArgumentException("Keluarga {$familyCode} wajib punya minimal 1 member terdaftar.");
                    }
                });
            } catch (\Throwable $exception) {
                $summary['errors'][] = "{$familyCode}: {$exception->getMessage()}";
            }
        }

        return $summary;
    }

    private function parseCsv(string $content): array
    {
        $lines = preg_split('/\r\n|\r|\n/', trim($content));

        if (! is_array($lines) || count($lines) < 2) {
            return [];
        }

        $header = str_getcsv((string) array_shift($lines));
        $expected = [
            'family_code',
            'family_name',
            'reference_no',
            'main_student_name',
            'class_label',
            'notes',
            'member_name',
            'member_type',
            'gender',
            'relation_label',
            'member_class_name',
            'is_primary_student',
            'is_registered_member',
            'is_extra_guest',
            'member_notes',
        ];

        if ($header !== $expected) {
            throw new InvalidArgumentException('Header CSV tidak sesuai template.');
        }

        $rows = [];

        foreach ($lines as $idx => $line) {
            if (trim($line) === '') {
                continue;
            }

            $values = str_getcsv($line);

            if (count($values) !== count($expected)) {
                throw new InvalidArgumentException('Jumlah kolom tidak valid di baris '.($idx + 2).'.');
            }

            $row = array_combine($expected, array_map(fn ($value): string => trim((string) $value), $values));

            if (! is_array($row) || $row['family_code'] === '' || $row['member_name'] === '' || $row['member_type'] === '') {
                throw new InvalidArgumentException('Kolom wajib kosong di baris '.($idx + 2).'.');
            }

            $rows[] = $row;
        }

        return $rows;
    }

    private function validateMemberType(string $value): string
    {
        $allowed = array_column(MemberType::cases(), 'value');

        if (! in_array($value, $allowed, true)) {
            throw new InvalidArgumentException("member_type tidak valid: {$value}");
        }

        return $value;
    }

    private function validateGender(string $value): string
    {
        if ($value === '') {
            return Gender::Unknown->value;
        }

        $allowed = array_column(Gender::cases(), 'value');

        if (! in_array($value, $allowed, true)) {
            throw new InvalidArgumentException("gender tidak valid: {$value}");
        }

        return $value;
    }

    private function toBool(string $value): bool
    {
        return in_array(strtolower($value), ['1', 'true', 'yes', 'y'], true);
    }
}
