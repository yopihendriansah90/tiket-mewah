<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FamilyMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'family_id',
        'member_type',
        'name',
        'gender',
        'class_name',
        'relation_label',
        'is_primary_student',
        'is_registered_member',
        'is_extra_guest',
        'is_replacement',
        'replaced_member_id',
        'checkin_status',
        'checked_in_at',
        'checked_in_by',
        'checked_in_gate_id',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'is_primary_student' => 'boolean',
            'is_registered_member' => 'boolean',
            'is_extra_guest' => 'boolean',
            'is_replacement' => 'boolean',
            'checked_in_at' => 'datetime',
        ];
    }

    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class);
    }

    public function replacedMember(): BelongsTo
    {
        return $this->belongsTo(self::class, 'replaced_member_id');
    }

    public function replacementMembers(): HasMany
    {
        return $this->hasMany(self::class, 'replaced_member_id');
    }

    public function checkedInBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'checked_in_by');
    }

    public function checkedInGate(): BelongsTo
    {
        return $this->belongsTo(EventGate::class, 'checked_in_gate_id');
    }

    public function checkins(): HasMany
    {
        return $this->hasMany(Checkin::class);
    }
}
