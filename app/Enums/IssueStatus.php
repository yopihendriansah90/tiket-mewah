<?php

namespace App\Enums;

enum IssueStatus: string
{
    case Open = 'open';
    case InReview = 'in_review';
    case Approved = 'approved';
    case Rejected = 'rejected';
    case Reprinted = 'reprinted';
    case Escalated = 'escalated';
    case Closed = 'closed';
}
