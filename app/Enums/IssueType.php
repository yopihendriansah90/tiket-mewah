<?php

namespace App\Enums;

enum IssueType: string
{
    case InvalidQr = 'invalid_qr';
    case QrUnreadable = 'qr_unreadable';
    case TicketNotFound = 'ticket_not_found';
    case TicketAlreadyFull = 'ticket_already_full';
    case MemberAlreadyCheckedIn = 'member_already_checked_in';
    case NameMismatch = 'name_mismatch';
    case LostTicket = 'lost_ticket';
    case ExtraGuestRequest = 'extra_guest_request';
    case ReplacementRequest = 'replacement_request';
    case ReentryRequest = 'reentry_request';
    case DataError = 'data_error';
    case Other = 'other';
}
