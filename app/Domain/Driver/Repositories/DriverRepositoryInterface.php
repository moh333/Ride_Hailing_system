<?php

namespace App\Domain\Driver\Repositories;

use App\Domain\Driver\Entities\Driver;
use App\Domain\Shared\ValueObjects\Location;

interface DriverRepositoryInterface
{
    public function save(Driver $driver): void;
    public function findByEmail(string $email): ?Driver;
    public function findById(string $id): ?Driver;
    /** @return Driver[] */
    public function findAvailableNearby(Location $location, float $radiusKm): array;
}
