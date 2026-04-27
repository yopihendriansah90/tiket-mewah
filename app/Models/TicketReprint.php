<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketReprint extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'ticket_id',
        'family_id',
        'issue_id',
        'reprinted_by',
        'reprinted_at',
        'reason',
        'file_type',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'reprinted_at' => 'datetime',
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

    public function reprintedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reprinted_by');
    }
}
