<?php

namespace App\Enums;

enum MemberType: string
{
    case Student = 'student';
    case Father = 'father';
    case Mother = 'mother';
    case Guardian = 'guardian';
    case Replacement = 'replacement';
    case ExtraGuest = 'extra_guest';
}
