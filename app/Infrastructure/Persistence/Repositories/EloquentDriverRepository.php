<?php

namespace App\Infrastructure\Persistence\Repositories;

use App\Domain\Driver\Entities\Driver;
use App\Domain\Driver\Enums\DriverStatus;
use App\Domain\Driver\Repositories\DriverRepositoryInterface;
use App\Domain\Shared\ValueObjects\Location;
use App\Infrastructure\Persistence\Eloquent\Models\DriverModel;

class EloquentDriverRepository implements DriverRepositoryInterface
{
    public function save(Driver $driver): void
    {
        DriverModel::updateOrCreate(
            ['id' => $driver->getId()],
            [
                'name' => $driver->getName(),
                'email' => $driver->getEmail(),
                'password' => $driver->getPasswordHash(),
                'license_plate' => $driver->getLicensePlate(),
                'status' => $driver->getStatus()->value,
                'latitude' => $driver->getLocation()?->latitude,
                'longitude' => $driver->getLocation()?->longitude,
                'current_trip_id' => $driver->getCurrentTripId(),
            ]
        );
    }

    public function findByEmail(string $email): ?Driver
    {
        $model = DriverModel::where('email', $email)->first();
        if (!$model)
            return null;
        return $this->toDomain($model);
    }

    public function findById(string $id): ?Driver
    {
        $model = DriverModel::find($id);
        if (!$model)
            return null;
        return $this->toDomain($model);
    }

    public function findAvailableNearby(Location $location, float $radiusKm): array
    {
        // Ideally use MySQL ST_Distance_Sphere or similar.
        // For now, fetching all online drivers and filtering in code or just returning them.

        $models = DriverModel::where('status', DriverStatus::ONLINE->value)->get();
        // Filter by radius could happen here

        return $models->map(fn($m) => $this->toDomain($m))->all();
    }

    private function toDomain(DriverModel $model): Driver
    {
        $location = ($model->latitude && $model->longitude)
            ? new Location($model->latitude, $model->longitude)
            : null;

        return new Driver(
            $model->id,
            $model->name,
            $model->email,
            $model->password,
            $model->license_plate,
            DriverStatus::tryFrom($model->status),
            $location,
            $model->current_trip_id
        );
    }
}
