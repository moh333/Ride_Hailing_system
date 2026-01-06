<?php

namespace App\Domain\Pricing\ValueObjects;

readonly class Tariff
{
    public function __construct(
        public float $baseFare,
        public float $costPerKm,
        public float $costPerMinute,
        public float $minimumFare
    ) {
    }

    public static function standard(): self
    {
        return new self(
            baseFare: 5.00,
            costPerKm: 1.50,
            costPerMinute: 0.50,
            minimumFare: 10.00
        );
    }
}
