<?php

namespace App\Domain\Passenger\Entities;

class Passenger
{
    public function __construct(
        private string $id,
        private string $name,
        private string $email,
        private string $passwordHash // We only store hash in domain if needed for creation, or handle auth separately
    ) {
    }

    public static function register(
        string $id,
        string $name,
        string $email,
        string $passwordHash
    ): self {
        return new self($id, $name, $email, $passwordHash);
    }

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
}
