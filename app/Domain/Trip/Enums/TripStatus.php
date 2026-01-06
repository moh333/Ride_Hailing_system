<?php

namespace App\Domain\Trip\Enums;

enum TripStatus: string
{
    case PENDING = 'pending';           // Searching for driver
    case ASSIGNED = 'assigned';         // Driver accepted
    case ARRIVED = 'arrived';           // Driver at pickup
    case IN_PROGRESS = 'in_progress';   // Trip started
    case COMPLETED = 'completed';       // Trip ended
    case CANCELLED = 'cancelled';       // Cancelled by user or driver
}
