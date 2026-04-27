<?php

namespace App\Enums;

enum TicketStatus: string
{
    case Active = 'active';
    case UsedPartial = 'used_partial';
    case UsedFull = 'used_full';
    case Revoked = 'revoked';
    case Replaced = 'replaced';
    case Cancelled = 'cancelled';
}
