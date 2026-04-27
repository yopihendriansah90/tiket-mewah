<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'name',
        'slug',
        'event_type',
        'event_date',
        'start_time',
        'end_time',
        'venue_name',
        'venue_address',
        'status',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
        ];
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function settings(): HasOne
    {
        return $this->hasOne(EventSetting::class);
    }

    public function gates(): HasMany
    {
        return $this->hasMany(EventGate::class);
    }

    public function families(): HasMany
    {
        return $this->hasMany(Family::class);
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
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

    public function auditLogs(): HasMany
    {
        return $this->hasMany(AuditLog::class);
    }
}
