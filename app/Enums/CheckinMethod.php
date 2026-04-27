<?php

namespace App\Enums;

enum CheckinMethod: string
{
    case QrScan = 'qr_scan';
    case Manual = 'manual';
    case HelperApproved = 'helper_approved';
    case ReentryApproved = 'reentry_approved';
}
