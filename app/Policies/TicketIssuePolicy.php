<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\TicketIssue;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class TicketIssuePolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:TicketIssue');
    }

    public function view(AuthUser $authUser, TicketIssue $ticketIssue): bool
    {
        return $authUser->can('View:TicketIssue');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:TicketIssue');
    }

    public function update(AuthUser $authUser, TicketIssue $ticketIssue): bool
    {
        return $authUser->can('Update:TicketIssue');
    }

    public function delete(AuthUser $authUser, TicketIssue $ticketIssue): bool
    {
        return $authUser->can('Delete:TicketIssue');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:TicketIssue');
    }

    public function restore(AuthUser $authUser, TicketIssue $ticketIssue): bool
    {
        return $authUser->can('Restore:TicketIssue');
    }

    public function forceDelete(AuthUser $authUser, TicketIssue $ticketIssue): bool
    {
        return $authUser->can('ForceDelete:TicketIssue');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:TicketIssue');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:TicketIssue');
    }

    public function replicate(AuthUser $authUser, TicketIssue $ticketIssue): bool
    {
        return $authUser->can('Replicate:TicketIssue');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:TicketIssue');
    }
}
