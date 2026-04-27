<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'allow_extra_guests',
        'extra_guest_limit',
        'extra_guest_requires_helper_approval',
        'allow_parent_replacement',
        'parent_replacement_requires_helper_approval',
        'allow_guardian_replacement',
        'guardian_replacement_requires_helper_approval',
        'allow_reentry_at_main_gate',
        'reentry_requires_helper_approval',
        'require_student_to_enter_with_parent',
        'require_parent_to_enter_with_student',
        'allow_partial_checkin',
        'allow_manual_checkin',
        'manual_checkin_requires_reason',
        'ticket_output_pdf',
        'ticket_output_png',
        'qr_token_type',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
