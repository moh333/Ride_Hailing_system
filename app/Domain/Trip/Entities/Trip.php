<?php

namespace App\Domain\Trip\Entities;

use App\Domain\Shared\ValueObjects\Location;
use App\Domain\Trip\Enums\TripStatus;
use DomainException;

class Trip
{
    public function __construct(
        private string $id,
        private string $passengerId,
        private Location $origin,
        private Location $destination,
        private TripStatus $status,
        private ?string $driverId = null,
        private ?float $price = null,
        private ?\DateTimeImmutable $createdAt = null
    ) {
        $this->createdAt = $createdAt ?? new \DateTimeImmutable();
    }

    public static function request(
        string $id,
        string $passengerId,
        Location $origin,
        Location $destination,
        float $estimatedPrice
    ): self {
        return new self(
            $id,
            $passengerId,
            $origin,
            $destination,
            TripStatus::PENDING,
            null,
            $estimatedPrice
        );
    }

    public function assignDriver(string $driverId): void
    {
        if ($this->status !== TripStatus::PENDING) {
            throw new DomainException("Trip can only be assigned when pending.");
        }

        $this->driverId = $driverId;
        $this->status = TripStatus::ASSIGNED;
    }

    public function start(): void
    {
        if ($this->status !== TripStatus::ASSIGNED && $this->status !== TripStatus::ARRIVED) {
            throw new DomainException("Trip can only be started after driver assignment/arrival.");
        }

        $this->status = TripStatus::IN_PROGRESS;
    }

    public function complete(): void
    {
        if ($this->status !== TripStatus::IN_PROGRESS) {
            throw new DomainException("Only in-progress trips can be completed.");
        }

        $this->status = TripStatus::COMPLETED;
    }

    public function cancel(): void
    {
        if ($this->status === TripStatus::COMPLETED || $this->status === TripStatus::CANCELLED) {
            throw new DomainException("Trip is already finalized.");
        }

        $this->status = TripStatus::CANCELLED;
    }

    // Getters
    public function getId(): string
    {
        return $this->id;
    }
    public function getPassengerId(): string
    {
        return $this->passengerId;
    }
    public function getDriverId(): ?string
    {
        return $this->driverId;
    }
    public function getOrigin(): Location
    {
        return $this->origin;
    }
    public function getDestination(): Location
    {
        return $this->destination;
    }
    public function getStatus(): TripStatus
    {
        return $this->status;
    }
    public function getPrice(): ?float
    {
        return $this->price;
    }
}
