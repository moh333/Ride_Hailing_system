<?php

namespace App\Domain\Driver\Entities;

use App\Domain\Shared\ValueObjects\Location;
use App\Domain\Driver\Enums\DriverStatus;
use DomainException;

class Driver
{
    public function __construct(
        private string $id,
        private string $name,
        private string $email,
        private string $passwordHash,
        private string $licensePlate,
        private DriverStatus $status,
        private ?Location $location = null,
        private ?string $currentTripId = null
    ) {
    }

    public static function register(
        string $id,
        string $name,
        string $email,
        string $passwordHash,
        string $licensePlate
    ): self {
        return new self(
            $id,
            $name,
            $email,
            $passwordHash,
            $licensePlate,
            DriverStatus::OFFLINE
        );
    }

    public function goOnline(Location $location): void
    {
        $this->status = DriverStatus::ONLINE;
        $this->location = $location;
    }

    public function goOffline(): void
    {
        if ($this->status === DriverStatus::BUSY) {
            throw new DomainException("Cannot go offline while on a trip.");
        }
        $this->status = DriverStatus::OFFLINE;
        $this->location = null;
    }

    public function updateLocation(Location $newLocation): void
    {
        if ($this->status === DriverStatus::OFFLINE) {
            throw new DomainException("Cannot update location while offline.");
        }
        $this->location = $newLocation;
    }

    public function acceptTrip(string $tripId): void
    {
        if ($this->status !== DriverStatus::ONLINE) {
            throw new DomainException("Driver must be online to accept a trip.");
        }

        $this->status = DriverStatus::BUSY;
        $this->currentTripId = $tripId;
    }

    public function completeTrip(): void
    {
        if ($this->status !== DriverStatus::BUSY) {
            throw new DomainException("Driver is not on a trip.");
        }

        $this->status = DriverStatus::ONLINE;
        $this->currentTripId = null;
    }

    // Getters
    public function getId(): string
    {
        return $this->id;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getEmail(): string
    {
        return $this->email;
    }
    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }
    public function getLicensePlate(): string
    {
        return $this->licensePlate;
    }
    public function getStatus(): DriverStatus
    {
        return $this->status;
    }
    public function getLocation(): ?Location
    {
        return $this->location;
    }
    public function getCurrentTripId(): ?string
    {
        return $this->currentTripId;
    }
}
