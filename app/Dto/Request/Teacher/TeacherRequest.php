<?php 

namespace App\Dto\Request\Teacher;

use DateTime;

final readonly class TeacherRequest {
    public function __construct(
        private string $name,
        private string $surname,
        private string $email,
        private int $dni,
        private DateTime $birthdate
    ) {}
    
    public function getName(): string
    {
        return $this->name;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getDni(): int
    {
        return $this->dni;
    }

    public function getBirthdate(): DateTime
    {
        return $this->birthdate;
    }
}