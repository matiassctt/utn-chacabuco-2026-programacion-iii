<?php 

namespace App\Converter\Teacher;

use DateTime;
use App\Entity\Teacher\Teacher;

final class PrimitiveToTeacherConverter {
    public function convert(object $primitive): Teacher
    {
        return new Teacher(
            $primitive->id,
            $primitive->name,
            $primitive->surname,
            $primitive->email,
            $primitive->dni,
            new DateTime($primitive->birth_date)
        );
    }
}