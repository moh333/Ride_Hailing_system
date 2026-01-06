<?php

namespace App\Domain\Passenger\Repositories;

use App\Domain\Passenger\Entities\Passenger;

interface PassengerRepositoryInterface
{
    public function save(Passenger $passenger): void;
    public function findByEmail(string $email): ?Passenger;
    public function findById(string $id): ?Passenger;
}
