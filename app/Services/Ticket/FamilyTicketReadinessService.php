<?php

declare(strict_types=1);

namespace App\Services\Ticket;

use App\Enums\FamilyMemberCheckinStatus;
use App\Enums\FamilyStatus;
use App\Enums\MemberType;
use App\Models\Event;

class FamilyTicketReadinessService
{
    public function validate(Event $event): array
    {
        $families = $event->families()->with('members')->get();

        $ready = 0;
        $notReady = 0;
        $issues = [];

        foreach ($families as $family) {
            $reasons = [];

            if ($family->status !== FamilyStatus::Active->value) {
                $reasons[] = 'Status keluarga tidak aktif';
            }

            $registeredMembers = $family->members
                ->where('is_registered_member', true)
                ->where('checkin_status', '!=', FamilyMemberCheckinStatus::Cancelled->value);

            if ($registeredMembers->isEmpty()) {
                $reasons[] = 'Tidak ada member terdaftar aktif';
            }

            $hasStudent = $registeredMembers->contains(fn ($member): bool => $member->member_type === MemberType::Student->value);

            if (! $hasStudent) {
                $reasons[] = 'Tidak ada member tipe student yang terdaftar';
            }

            if ($reasons === []) {
                $ready++;

                continue;
            }

            $notReady++;
            $issues[] = [
                'family_code' => $family->family_code,
                'reasons' => $reasons,
            ];
        }

        return [
            'event_name' => $event->name,
            'event_id' => $event->id,
            'total_families' => $families->count(),
            'ready_families' => $ready,
            'not_ready_families' => $notReady,
            'issues' => $issues,
        ];
    }

    public function toCsv(array $result): string
    {
        $lines = [
            'event_id,event_name,total_families,ready_families,not_ready_families,family_code,reasons',
        ];

        if (empty($result['issues'])) {
            $lines[] = implode(',', [
                (string) $result['event_id'],
                $this->escapeCsv((string) $result['event_name']),
                (string) $result['total_families'],
                (string) $result['ready_families'],
                (string) $result['not_ready_families'],
                '',
                '',
            ]);

            return implode("\n", $lines)."\n";
        }

        foreach ($result['issues'] as $issue) {
            $lines[] = implode(',', [
                (string) $result['event_id'],
                $this->escapeCsv((string) $result['event_name']),
                (string) $result['total_families'],
                (string) $result['ready_families'],
                (string) $result['not_ready_families'],
                $this->escapeCsv((string) $issue['family_code']),
                $this->escapeCsv(implode(' | ', $issue['reasons'])),
            ]);
        }

        return implode("\n", $lines)."\n";
    }

    private function escapeCsv(string $value): string
    {
        return '"'.str_replace('"', '""', $value).'"';
    }
}
