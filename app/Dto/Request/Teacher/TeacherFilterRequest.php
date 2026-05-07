<?php 

namespace App\Dto\Request\Teacher;

use App\Dto\Request\PaginationRequest;

final readonly class TeacherFilterRequest {
    public function __construct(
        private PaginationRequest $pagination,
        private ?string $email
    ) {}

    public function getPagination(): PaginationRequest
    {
        return $this->pagination;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function hasEmail(): bool
    {
        return !empty($this->email);
    }
}