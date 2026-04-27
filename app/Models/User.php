<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, HasRoles, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'vendor_id',
        'name',
        'email',
        'phone',
        'password',
        'is_active',
        'last_login_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'last_login_at' => 'datetime',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->is_active
            && ($this->hasRole(config('filament-shield.super_admin.name', 'superadmin'))
                || $this->can('Access:AdminPanel'));
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function createdEvents(): HasMany
    {
        return $this->hasMany(Event::class, 'created_by');
    }

    public function checkins(): HasMany
    {
        return $this->hasMany(Checkin::class, 'checked_by');
    }

    public function reportedIssues(): HasMany
    {
        return $this->hasMany(TicketIssue::class, 'reported_by');
    }

    public function handledIssues(): HasMany
    {
        return $this->hasMany(TicketIssue::class, 'handled_by');
    }

    public function approvedIssues(): HasMany
    {
        return $this->hasMany(TicketIssue::class, 'approved_by');
    }

    public function requestedApprovals(): HasMany
    {
        return $this->hasMany(ManualApproval::class, 'requested_by');
    }

    public function approvedApprovals(): HasMany
    {
        return $this->hasMany(ManualApproval::class, 'approved_by');
    }
}
