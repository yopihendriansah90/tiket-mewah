<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\EventSetting;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class EventSettingPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:EventSetting');
    }

    public function view(AuthUser $authUser, EventSetting $eventSetting): bool
    {
        return $authUser->can('View:EventSetting');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:EventSetting');
    }

    public function update(AuthUser $authUser, EventSetting $eventSetting): bool
    {
        return $authUser->can('Update:EventSetting');
    }

    public function delete(AuthUser $authUser, EventSetting $eventSetting): bool
    {
        return $authUser->can('Delete:EventSetting');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:EventSetting');
    }

    public function restore(AuthUser $authUser, EventSetting $eventSetting): bool
    {
        return $authUser->can('Restore:EventSetting');
    }

    public function forceDelete(AuthUser $authUser, EventSetting $eventSetting): bool
    {
        return $authUser->can('ForceDelete:EventSetting');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:EventSetting');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:EventSetting');
    }

    public function replicate(AuthUser $authUser, EventSetting $eventSetting): bool
    {
        return $authUser->can('Replicate:EventSetting');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:EventSetting');
    }
}
