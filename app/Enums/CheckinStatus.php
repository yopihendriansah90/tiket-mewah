<?php

namespace App\Enums;

enum CheckinStatus: string
{
    case Success = 'success';
    case Rejected = 'rejected';
    case Cancelled = 'cancelled';
}
