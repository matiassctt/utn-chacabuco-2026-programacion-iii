<?php 

namespace App\Dto\Response\Teacher;

use DateTime;

final readonly class TeacherResponse {
    public function __construct(
        public int $id,
        public string $name,
        public string $surname,
        public string $email,
        public int $dni,
        public DateTime $birthdate
    ) {}
}