<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\TicketFile;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class TicketFilePolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:TicketFile');
    }

    public function view(AuthUser $authUser, TicketFile $ticketFile): bool
    {
        return $authUser->can('View:TicketFile');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:TicketFile');
    }

    public function update(AuthUser $authUser, TicketFile $ticketFile): bool
    {
        return $authUser->can('Update:TicketFile');
    }

    public function delete(AuthUser $authUser, TicketFile $ticketFile): bool
    {
        return $authUser->can('Delete:TicketFile');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:TicketFile');
    }

    public function restore(AuthUser $authUser, TicketFile $ticketFile): bool
    {
        return $authUser->can('Restore:TicketFile');
    }

    public function forceDelete(AuthUser $authUser, TicketFile $ticketFile): bool
    {
        return $authUser->can('ForceDelete:TicketFile');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:TicketFile');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:TicketFile');
    }

    public function replicate(AuthUser $authUser, TicketFile $ticketFile): bool
    {
        return $authUser->can('Replicate:TicketFile');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:TicketFile');
    }
}
