<?php

namespace App\Application\Trip\DTOs;

readonly class RequestTripDTO
{
    public function __construct(
        public string $passengerId,
        public float $originLat,
        public float $originLng,
        public float $destLat,
        public float $destLng
    ) {
    }
}
