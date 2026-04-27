<?php

namespace App\Enums;

enum ApprovalType: string
{
    case ManualCheckin = 'manual_checkin';
    case ExtraGuest = 'extra_guest';
    case Replacement = 'replacement';
    case Reentry = 'reentry';
    case Reprint = 'reprint';
    case RegenerateTicket = 'regenerate_ticket';
    case QuotaOverride = 'quota_override';
}
