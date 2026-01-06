<?php

namespace App\Infrastructure\Persistence\Repositories;

use App\Domain\Shared\ValueObjects\Location;
use App\Domain\Trip\Entities\Trip;
use App\Domain\Trip\Enums\TripStatus;
use App\Domain\Trip\Repositories\TripRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Models\TripModel;

class EloquentTripRepository implements TripRepositoryInterface
{
    public function save(Trip $trip): void
    {
        TripModel::updateOrCreate(
            ['id' => $trip->getId()],
            [
                'passenger_id' => $trip->getPassengerId(),
                'driver_id' => $trip->getDriverId(),
                'origin_lat' => $trip->getOrigin()->latitude,
                'origin_lng' => $trip->getOrigin()->longitude,
                'dest_lat' => $trip->getDestination()->latitude,
                'dest_lng' => $trip->getDestination()->longitude,
                'status' => $trip->getStatus()->value,
                'price' => $trip->getPrice(),
            ]
        );
    }

    public function findById(string $id): ?Trip
    {
        $model = TripModel::find($id);

        if (!$model) {
            return null;
        }

        return $this->toDomain($model);
    }

    public function findPendingTripsInArea(Location $location, float $radiusKm): array
    {
        // Simple Haversine in SQL or Geo function required here. 
        // For POC, simply returning all pending (not scalable, but demonstrates the port).
        // Ideally we use a geospatial index (MySQL 8.0 ST_Distance_Sphere or PostGIS).

        $models = TripModel::where('status', TripStatus::PENDING->value)->get();
        // In reality, filter by distance here or use DB raw query.

        return $models->map(fn($m) => $this->toDomain($m))->all();
    }

    private function toDomain(TripModel $model): Trip
    {
        // Reflection or a public constructor/static factory is needed if properties are private.
        // Since our Trip entity has a constructor that allows state reconstruction, we use that.
        // Ideally we might have a dedicated 'reconstitute' method to bypass validation logic if needed.

        // We use the constructor directly assuming it's safe for hydration,
        // or we use reflection to set properties without triggering domain rules if strict.
        // For simplicity:

        return new Trip(
            $model->id,
            $model->passenger_id,
            new Location($model->origin_lat, $model->origin_lng),
            new Location($model->dest_lat, $model->dest_lng),
            TripStatus::tryFrom($model->status),
            $model->driver_id,
            $model->price,
            \Carbon\Carbon::parse($model->created_at)->toImmutable()
        );
    }
}
