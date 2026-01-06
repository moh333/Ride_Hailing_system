<?php

namespace App\Domain\Shared\ValueObjects;

use InvalidArgumentException;
use JsonSerializable;

readonly class Location implements JsonSerializable
{
    public function __construct(
        public float $latitude,
        public float $longitude
    ) {
        $this->validate();
    }

    private function validate(): void
    {
        if ($this->latitude < -90 || $this->latitude > 90) {
            throw new InvalidArgumentException("Latitude must be between -90 and 90 degrees.");
        }

        if ($this->longitude < -180 || $this->longitude > 180) {
            throw new InvalidArgumentException("Longitude must be between -180 and 180 degrees.");
        }
    }

    public function distanceTo(Location $target): float
    {
        // Haversine formula for distance in kilometers
        $earthRadius = 6371;

        $latFrom = deg2rad($this->latitude);
        $lonFrom = deg2rad($this->longitude);
        $latTo = deg2rad($target->latitude);
        $lonTo = deg2rad($target->longitude);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

        return $earthRadius * $angle;
    }

    public function jsonSerialize(): array
    {
        return [
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ];
    }

    public function __toString(): string
    {
        return "{$this->latitude},{$this->longitude}";
    }
}
