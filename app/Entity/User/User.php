<?php 

namespace App\Entity\User;

use App\Dto\Request\User\UserRequest;

final class User {
    public function __construct(
        private ?int $id,
        private string $username,
        private string $email,
        private string $password,
        private ?int $dni
    ) {}

    public function update(UserRequest $request): void
    {
        $this->username = $request->getUserName();
        $this->email = $request->getEmail();
        $this->password = $request->getPassword();
        $this->dni = $request->getDni();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

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

    public static function convertFromRequest(UserRequest $request): User
    {
        return new User(
            null,
            $request->getUserName(),
            $request->getEmail(),
            $request->getPassword(),
            $request->getDni()
        );
    }
} 