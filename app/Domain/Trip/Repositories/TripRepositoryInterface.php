<?php

namespace App\Domain\Trip\Repositories;

use App\Domain\Trip\Entities\Trip;

interface TripRepositoryInterface
{
    public function save(Trip $trip): void;
    public function findById(string $id): ?Trip;
    public function findPendingTripsInArea(\App\Domain\Shared\ValueObjects\Location $location, float $radiusKm): array;
}
