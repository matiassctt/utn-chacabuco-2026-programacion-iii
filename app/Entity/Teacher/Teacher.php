<?php 

namespace App\Entity\Teacher;

use App\Dto\Request\Teacher\TeacherRequest;
use DateTime;

final class Teacher {
    public function __construct(
        private ?int $id,
        private string $name,
        private string $surname,
        private string $email,
        private int $dni,
        private DateTime $birthdate
    ) {}

    public function update(TeacherRequest $request): void
    {
        $this->name = $request->getName();
        $this->surname = $request->getSurname();
        $this->email = $request->getEmail();
        $this->dni = $request->getDni();
        $this->birthdate = $request->getBirthdate();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

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

    public function getBirthDate(): DateTime
    {
        return $this->birthdate;
    }

    public static function convertFromRequest(TeacherRequest $request): Teacher
    {
        return new Teacher(
            null,
            $request->getName(),
            $request->getSurname(),
            $request->getEmail(),
            $request->getDni(),
            $request->getBirthdate()
        );
    }
} 