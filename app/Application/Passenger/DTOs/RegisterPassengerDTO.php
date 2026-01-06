<?php

namespace App\Application\Passenger\DTOs;

readonly class RegisterPassengerDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password
    ) {
    }
}
