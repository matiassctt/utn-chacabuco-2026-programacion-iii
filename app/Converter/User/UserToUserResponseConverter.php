<?php 

namespace App\Converter\User;

use App\Dto\Response\User\UserResponse;
use App\Entity\User\User;

final class UserToUserResponseConverter {

    public function convert(User $teacher): UserResponse
    {
        return new UserResponse(
            $teacher->getId(),
            $teacher->getUserName(),
            $teacher->getEmail(),
            $teacher->getDni()
        );
    }
}