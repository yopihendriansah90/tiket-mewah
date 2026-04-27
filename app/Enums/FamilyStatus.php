<?php

namespace App\Enums;

enum FamilyStatus: string
{
    case Active = 'active';
    case Inactive = 'inactive';
    case Blocked = 'blocked';
}
