<?php 

namespace App\Dto\Request\User;

final readonly class UserRequest {
    public function __construct(
        private string $username,
        private string $email,
        private string $password,
        private ?int $dni
    ) {}
    
    public function getUserName(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getDni(): ?int
    {
        return $this->dni;
    }
}