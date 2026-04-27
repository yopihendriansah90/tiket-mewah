<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Checkin extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'ticket_id',
        'family_id',
        'family_member_id',
        'gate_id',
        'checked_by',
        'checked_at',
        'checkin_method',
        'checkin_status',
        'counts_as_quota',
        'is_extra_guest',
        'is_replacement',
        'guest_name_snapshot',
        'guest_relation_snapshot',
        'issue_id',
        'approval_id',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'checked_at' => 'datetime',
            'counts_as_quota' => 'boolean',
            'is_extra_guest' => 'boolean',
            'is_replacement' => 'boolean',
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

    public function familyMember(): BelongsTo
    {
        return $this->belongsTo(FamilyMember::class);
    }

    public function gate(): BelongsTo
    {
        return $this->belongsTo(EventGate::class, 'gate_id');
    }

    public function checkedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'checked_by');
    }

    public function issue(): BelongsTo
    {
        return $this->belongsTo(TicketIssue::class, 'issue_id');
    }

    public function approval(): BelongsTo
    {
        return $this->belongsTo(ManualApproval::class, 'approval_id');
    }
}
