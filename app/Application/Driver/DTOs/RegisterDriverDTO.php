<?php

namespace App\Application\Driver\DTOs;

readonly class RegisterDriverDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
        public string $licensePlate
    ) {
    }
}
