<?php

namespace App\Infrastructure\Persistence\Repositories;

use App\Domain\Passenger\Entities\Passenger;
use App\Domain\Passenger\Repositories\PassengerRepositoryInterface;
use App\Models\User;

class EloquentPassengerRepository implements PassengerRepositoryInterface
{
    public function save(Passenger $passenger): void
    {
        User::updateOrCreate(
            ['id' => $passenger->getId()],
            [
                'name' => $passenger->getName(),
                'email' => $passenger->getEmail(),
                'password' => $passenger->getPasswordHash(),
            ]
        );
    }

    public function findByEmail(string $email): ?Passenger
    {
        $model = User::where('email', $email)->first();
        if (!$model)
            return null;
        return $this->toDomain($model);
    }

    public function findById(string $id): ?Passenger
    {
        $model = User::find($id);
        if (!$model)
            return null;
        return $this->toDomain($model);
    }

    private function toDomain(User $model): Passenger
    {
        return new Passenger(
            $model->id,
            $model->name,
            $model->email,
            $model->password
        );
    }
}
