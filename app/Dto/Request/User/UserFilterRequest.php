<?php 

namespace App\Dto\Request\User;

use App\Dto\Request\PaginationRequest;

final readonly class UserFilterRequest {
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