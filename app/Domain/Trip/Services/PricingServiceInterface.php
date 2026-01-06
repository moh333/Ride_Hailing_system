<?php

namespace App\Domain\Trip\Services;

use App\Domain\Shared\ValueObjects\Location;

interface PricingServiceInterface
{
    public function calculatePrice(Location $origin, Location $destination): float;
}
