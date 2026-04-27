<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'family_id',
        'ticket_code',
        'qr_token',
        'quota_registered',
        'quota_extra_allowed',
        'quota_total',
        'quota_used',
        'status',
        'generated_at',
        'revoked_at',
        'replaced_by_ticket_id',
    ];

    protected function casts(): array
    {
        return [
            'generated_at' => 'datetime',
            'revoked_at' => 'datetime',
        ];
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class);
    }

    public function files(): HasMany
    {
        return $this->hasMany(TicketFile::class);
    }

    public function checkins(): HasMany
    {
        return $this->hasMany(Checkin::class);
    }

    public function issues(): HasMany
    {
        return $this->hasMany(TicketIssue::class);
    }

    public function reprints(): HasMany
    {
        return $this->hasMany(TicketReprint::class);
    }

    public function manualApprovals(): HasMany
    {
        return $this->hasMany(ManualApproval::class);
    }

    public function replacementTicket(): BelongsTo
    {
        return $this->belongsTo(self::class, 'replaced_by_ticket_id');
    }
}
