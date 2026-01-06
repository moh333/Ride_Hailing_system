<?php

namespace App\Application\Driver\UseCases;

use App\Application\Driver\DTOs\RegisterDriverDTO;
use App\Domain\Driver\Entities\Driver;
use App\Domain\Driver\Repositories\DriverRepositoryInterface;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use DomainException;

class RegisterDriverUseCase
{
    public function __construct(
        private DriverRepositoryInterface $driverRepository
    ) {
    }

    public function execute(RegisterDriverDTO $dto): string
    {
        if ($this->driverRepository->findByEmail($dto->email)) {
            throw new DomainException("Driver with this email already exists.");
        }

        $id = (string) Str::uuid();
        $passwordHash = Hash::make($dto->password);

        $driver = Driver::register(
            $id,
            $dto->name,
            $dto->email,
            $passwordHash,
            $dto->licensePlate
        );

        $this->driverRepository->save($driver);

        return $id;
    }
}
