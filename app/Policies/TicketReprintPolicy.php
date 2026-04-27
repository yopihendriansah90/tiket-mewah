<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\TicketReprint;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class TicketReprintPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:TicketReprint');
    }

    public function view(AuthUser $authUser, TicketReprint $ticketReprint): bool
    {
        return $authUser->can('View:TicketReprint');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:TicketReprint');
    }

    public function update(AuthUser $authUser, TicketReprint $ticketReprint): bool
    {
        return $authUser->can('Update:TicketReprint');
    }

    public function delete(AuthUser $authUser, TicketReprint $ticketReprint): bool
    {
        return $authUser->can('Delete:TicketReprint');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:TicketReprint');
    }

    public function restore(AuthUser $authUser, TicketReprint $ticketReprint): bool
    {
        return $authUser->can('Restore:TicketReprint');
    }

    public function forceDelete(AuthUser $authUser, TicketReprint $ticketReprint): bool
    {
        return $authUser->can('ForceDelete:TicketReprint');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:TicketReprint');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:TicketReprint');
    }

    public function replicate(AuthUser $authUser, TicketReprint $ticketReprint): bool
    {
        return $authUser->can('Replicate:TicketReprint');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:TicketReprint');
    }
}
