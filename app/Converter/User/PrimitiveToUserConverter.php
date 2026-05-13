<?php 

namespace App\Converter\User;

use App\Entity\User\User;

final class PrimitiveToUserConverter {
    public function convert(object $primitive): User
    {
        return new User(
            $primitive->id,
            $primitive->username,
            $primitive->email,
            $primitive->password,
            $primitive->dni
        );
    }
}