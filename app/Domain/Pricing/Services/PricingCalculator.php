<?php

namespace App\Domain\Pricing\Services;

use App\Domain\Pricing\ValueObjects\Tariff;
use App\Domain\Shared\ValueObjects\Location;

class PricingCalculator
{
    public function calculate(Location $origin, Location $destination, Tariff $tariff): float
    {
        $distanceKm = $origin->distanceTo($destination);

        // Estimate time: assume 30km/h average speed in city
        $estimatedHours = $distanceKm / 30;
        $estimatedMinutes = $estimatedHours * 60;

        $price = $tariff->baseFare
            + ($distanceKm * $tariff->costPerKm)
            + ($estimatedMinutes * $tariff->costPerMinute);

        return max($price, $tariff->minimumFare);
    }
}
