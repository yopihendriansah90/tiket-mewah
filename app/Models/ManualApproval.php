<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ManualApproval extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'ticket_id',
        'family_id',
        'issue_id',
        'approval_type',
        'requested_by',
        'approved_by',
        'status',
        'reason',
        'approval_note',
        'approved_at',
    ];

    protected function casts(): array
    {
        return [
            'approved_at' => 'datetime',
        ];
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class);
    }

    public function issue(): BelongsTo
    {
        return $this->belongsTo(TicketIssue::class, 'issue_id');
    }

    public function requester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function checkins(): HasMany
    {
        return $this->hasMany(Checkin::class, 'approval_id');
    }
}
