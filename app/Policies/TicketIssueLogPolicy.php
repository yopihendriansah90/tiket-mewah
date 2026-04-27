<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\TicketIssueLog;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class TicketIssueLogPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:TicketIssueLog');
    }

    public function view(AuthUser $authUser, TicketIssueLog $ticketIssueLog): bool
    {
        return $authUser->can('View:TicketIssueLog');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:TicketIssueLog');
    }

    public function update(AuthUser $authUser, TicketIssueLog $ticketIssueLog): bool
    {
        return $authUser->can('Update:TicketIssueLog');
    }

    public function delete(AuthUser $authUser, TicketIssueLog $ticketIssueLog): bool
    {
        return $authUser->can('Delete:TicketIssueLog');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:TicketIssueLog');
    }

    public function restore(AuthUser $authUser, TicketIssueLog $ticketIssueLog): bool
    {
        return $authUser->can('Restore:TicketIssueLog');
    }

    public function forceDelete(AuthUser $authUser, TicketIssueLog $ticketIssueLog): bool
    {
        return $authUser->can('ForceDelete:TicketIssueLog');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:TicketIssueLog');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:TicketIssueLog');
    }

    public function replicate(AuthUser $authUser, TicketIssueLog $ticketIssueLog): bool
    {
        return $authUser->can('Replicate:TicketIssueLog');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:TicketIssueLog');
    }
}
