<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\ManualApproval;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class ManualApprovalPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:ManualApproval');
    }

    public function view(AuthUser $authUser, ManualApproval $manualApproval): bool
    {
        return $authUser->can('View:ManualApproval');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:ManualApproval');
    }

    public function update(AuthUser $authUser, ManualApproval $manualApproval): bool
    {
        return $authUser->can('Update:ManualApproval');
    }

    public function delete(AuthUser $authUser, ManualApproval $manualApproval): bool
    {
        return $authUser->can('Delete:ManualApproval');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:ManualApproval');
    }

    public function restore(AuthUser $authUser, ManualApproval $manualApproval): bool
    {
        return $authUser->can('Restore:ManualApproval');
    }

    public function forceDelete(AuthUser $authUser, ManualApproval $manualApproval): bool
    {
        return $authUser->can('ForceDelete:ManualApproval');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:ManualApproval');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:ManualApproval');
    }

    public function replicate(AuthUser $authUser, ManualApproval $manualApproval): bool
    {
        return $authUser->can('Replicate:ManualApproval');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:ManualApproval');
    }
}
