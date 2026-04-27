<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Family extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'family_code',
        'family_name',
        'reference_no',
        'main_student_name',
        'class_label',
        'notes',
        'import_batch_id',
        'status',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function members(): HasMany
    {
        return $this->hasMany(FamilyMember::class);
    }

    public function ticket(): HasOne
    {
        return $this->hasOne(Ticket::class);
    }

    public function checkins(): HasMany
    {
        return $this->hasMany(Checkin::class);
    }

    public function ticketIssues(): HasMany
    {
        return $this->hasMany(TicketIssue::class);
    }

    public function manualApprovals(): HasMany
    {
        return $this->hasMany(ManualApproval::class);
    }
}
