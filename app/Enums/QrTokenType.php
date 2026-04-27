<?php

namespace App\Enums;

enum QrTokenType: string
{
    case Uuid = 'uuid';
    case Ulid = 'ulid';
}
