<?php 

namespace App\Dto\Response\User;

use DateTime;

final readonly class UserResponse {
    public function __construct(
        public int $id,
        public string $surname,
        public string $email,
        public ?int $dni
    ) {}
}