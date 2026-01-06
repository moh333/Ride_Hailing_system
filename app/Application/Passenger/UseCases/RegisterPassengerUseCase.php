<?php

namespace App\Application\Passenger\UseCases;

use App\Application\Passenger\DTOs\RegisterPassengerDTO;
use App\Domain\Passenger\Entities\Passenger;
use App\Domain\Passenger\Repositories\PassengerRepositoryInterface;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class RegisterPassengerUseCase
{
    public function __construct(
        private PassengerRepositoryInterface $passengerRepository
    ) {
    }

    public function execute(RegisterPassengerDTO $dto): string
    {
        if ($this->passengerRepository->findByEmail($dto->email)) {
            throw new \DomainException("Email already registered.");
        }

        $id = (string) Str::uuid();
        $hashedPassword = Hash::make($dto->password);

        $passenger = Passenger::register(
            $id,
            $dto->name,
            $dto->email,
            $hashedPassword
        );

        $this->passengerRepository->save($passenger);

        return $id;
    }
}
