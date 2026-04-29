<?php

namespace App\Services\Ticket;

use App\Enums\FamilyMemberCheckinStatus;
use App\Enums\FamilyStatus;
use App\Enums\QrTokenType;
use App\Enums\TicketStatus;
use App\Models\Family;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use InvalidArgumentException;

class TicketGeneratorService
{
    public function generateForFamily(Family $family): Ticket
    {
        $family->loadMissing('event.settings');

        if ($family->status !== FamilyStatus::Active->value) {
            throw new InvalidArgumentException('Ticket hanya bisa dibuat untuk keluarga aktif.');
        }

        $registeredQuota = $this->countRegisteredQuota($family);

        if ($registeredQuota < 1) {
            throw new InvalidArgumentException('Ticket membutuhkan minimal satu anggota terdaftar.');
        }

        $settings = $family->event?->settings;
        $extraQuota = (bool) ($settings?->allow_extra_guests ?? false)
            ? (int) ($settings?->extra_guest_limit ?? 0)
            : 0;

        return DB::transaction(function () use ($family, $registeredQuota, $extraQuota, $settings): Ticket {
            $ticket = $family->ticket()->lockForUpdate()->first();
            $quotaTotal = $registeredQuota + $extraQuota;

            if ($ticket) {
                $ticket->forceFill([
                    'event_id' => $family->event_id,
                    'quota_registered' => $registeredQuota,
                    'quota_extra_allowed' => $extraQuota,
                    'quota_total' => $quotaTotal,
                    'status' => $this->statusForQuota($ticket->quota_used, $quotaTotal, $ticket->status),
                ])->save();

                return $ticket->refresh();
            }

            return Ticket::query()->create([
                'event_id' => $family->event_id,
                'family_id' => $family->id,
                'ticket_code' => $this->ticketCode($family),
                'qr_token' => $this->qrToken($settings?->qr_token_type),
                'quota_registered' => $registeredQuota,
                'quota_extra_allowed' => $extraQuota,
                'quota_total' => $quotaTotal,
                'quota_used' => 0,
                'status' => TicketStatus::Active->value,
                'generated_at' => now(),
            ]);
        });
    }

    private function countRegisteredQuota(Family $family): int
    {
        return $family->members()
            ->where('is_registered_member', true)
            ->where('checkin_status', '!=', FamilyMemberCheckinStatus::Cancelled->value)
            ->count();
    }

    private function statusForQuota(int $used, int $total, string $currentStatus): string
    {
        if (in_array($currentStatus, [
            TicketStatus::Revoked->value,
            TicketStatus::Replaced->value,
            TicketStatus::Cancelled->value,
        ], true)) {
            return $currentStatus;
        }

        if ($used >= $total) {
            return TicketStatus::UsedFull->value;
        }

        if ($used > 0) {
            return TicketStatus::UsedPartial->value;
        }

        return TicketStatus::Active->value;
    }

    private function ticketCode(Family $family): string
    {
        return Str::of("{$family->event_id}-{$family->family_code}")
            ->upper()
            ->replaceMatches('/[^A-Z0-9-]/', '-')
            ->replaceMatches('/-+/', '-')
            ->trim('-')
            ->toString();
    }

    private function qrToken(?string $tokenType): string
    {
        return match ($tokenType) {
            QrTokenType::Uuid->value => (string) Str::uuid(),
            default => (string) Str::ulid(),
        };
    }
}
