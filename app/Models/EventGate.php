<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EventGate extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'name',
        'code',
        'location_note',
        'is_active',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function checkins(): HasMany
    {
        return $this->hasMany(Checkin::class, 'gate_id');
    }

    public function ticketIssues(): HasMany
    {
        return $this->hasMany(TicketIssue::class, 'gate_id');
    }
}
