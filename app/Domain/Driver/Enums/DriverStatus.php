<?php

namespace App\Domain\Driver\Enums;

enum DriverStatus: string
{
    case OFFLINE = 'offline';
    case ONLINE = 'online';
    case BUSY = 'busy';
}
