<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketIssueLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_issue_id',
        'user_id',
        'action',
        'old_status',
        'new_status',
        'notes',
    ];

    public function issue(): BelongsTo
    {
        return $this->belongsTo(TicketIssue::class, 'ticket_issue_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
