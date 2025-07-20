<?php

namespace App\Enums;

enum MovementType: string
{
    case INCOMING = 'incoming';
    case OUTGOING = 'outgoing';
}
