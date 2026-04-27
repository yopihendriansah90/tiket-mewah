<?php

namespace App\Enums;

enum EventType: string
{
    case School = 'school';
    case PrivateEvent = 'private_event';
    case Seminar = 'seminar';
    case Concert = 'concert';
    case Other = 'other';
}
