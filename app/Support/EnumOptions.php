<?php

namespace App\Support;

use BackedEnum;
use Illuminate\Support\Str;

class EnumOptions
{
    /**
     * @param  class-string<BackedEnum>  $enum
     * @return array<string, string>
     */
    public static function from(string $enum): array
    {
        return collect($enum::cases())
            ->mapWithKeys(fn (BackedEnum $case): array => [
                (string) $case->value => self::label((string) $case->value),
            ])
            ->all();
    }

    public static function label(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        return match ($value) {
            'active' => 'Aktif',
            'inactive' => 'Tidak aktif',
            'blocked' => 'Diblokir',
            'suspended' => 'Ditangguhkan',
            'draft' => 'Draft',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            'pending' => 'Menunggu',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            'success' => 'Berhasil',
            'open' => 'Terbuka',
            'in_review' => 'Ditinjau',
            'reprinted' => 'Dicetak ulang',
            'escalated' => 'Dieskalasi',
            'closed' => 'Ditutup',
            'student' => 'Siswa',
            'father' => 'Ayah',
            'mother' => 'Ibu',
            'guardian' => 'Wali',
            'replacement' => 'Pengganti',
            'extra_guest' => 'Tamu tambahan',
            'male' => 'Laki-laki',
            'female' => 'Perempuan',
            'unknown' => 'Tidak diketahui',
            'checked_in' => 'Sudah check-in',
            'manual_checked_in' => 'Check-in manual',
            'used_partial' => 'Terpakai sebagian',
            'used_full' => 'Terpakai penuh',
            'revoked' => 'Dicabut',
            'replaced' => 'Diganti',
            'qr_scan' => 'Scan QR',
            'manual' => 'Manual',
            'helper_approved' => 'Disetujui helper',
            'reentry_approved' => 'Masuk ulang disetujui',
            'manual_checkin' => 'Check-in manual',
            'reentry' => 'Masuk ulang',
            'reprint' => 'Cetak ulang',
            'regenerate_ticket' => 'Generate ulang tiket',
            'quota_override' => 'Override kuota',
            'school' => 'Sekolah',
            'private_event' => 'Acara privat',
            'seminar' => 'Seminar',
            'concert' => 'Konser',
            'other' => 'Lainnya',
            'invalid_qr' => 'QR tidak valid',
            'qr_unreadable' => 'QR tidak terbaca',
            'ticket_not_found' => 'Tiket tidak ditemukan',
            'ticket_already_full' => 'Kuota tiket penuh',
            'member_already_checked_in' => 'Anggota sudah check-in',
            'name_mismatch' => 'Nama tidak sesuai',
            'lost_ticket' => 'Tiket hilang',
            'extra_guest_request' => 'Permintaan tamu tambahan',
            'replacement_request' => 'Permintaan pengganti',
            'reentry_request' => 'Permintaan masuk ulang',
            'data_error' => 'Kesalahan data',
            'uuid' => 'UUID',
            'ulid' => 'ULID',
            'pdf' => 'PDF',
            'png' => 'PNG',
            default => Str::headline($value),
        };
    }
}
