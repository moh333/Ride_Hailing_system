<?php

namespace App\Application\Trip\UseCases;

use App\Application\Trip\DTOs\RequestTripDTO;
use App\Domain\Shared\ValueObjects\Location;
use App\Domain\Trip\Entities\Trip;
use App\Domain\Trip\Events\TripRequested;
use App\Domain\Trip\Repositories\TripRepositoryInterface;
use App\Domain\Trip\Services\PricingServiceInterface;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Str;

class RequestTripUseCase
{
    public function __construct(
        private TripRepositoryInterface $tripRepository,
        private PricingServiceInterface $pricingService,
        private Dispatcher $eventDispatcher
    ) {
    }

    public function execute(RequestTripDTO $dto): string
    {
        $origin = new Location($dto->originLat, $dto->originLng);
        $destination = new Location($dto->destLat, $dto->destLng);

        $price = $this->pricingService->calculatePrice($origin, $destination);

        $tripId = (string) Str::uuid();

        $trip = Trip::request(
            $tripId,
            $dto->passengerId,
            $origin,
            $destination,
            $price
        );

        $this->tripRepository->save($trip);

        $this->eventDispatcher->dispatch(new TripRequested($trip));

        return $tripId;
    }
}
