<?php

namespace App\Enums;

enum FamilyMemberCheckinStatus: string
{
    case Pending = 'pending';
    case CheckedIn = 'checked_in';
    case ManualCheckedIn = 'manual_checked_in';
    case Cancelled = 'cancelled';
}
