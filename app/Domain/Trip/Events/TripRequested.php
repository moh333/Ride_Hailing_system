<?php

namespace App\Domain\Trip\Events;

use App\Domain\Trip\Entities\Trip;

readonly class TripRequested
{
    public function __construct(
        public Trip $trip
    ) {
    }
}
