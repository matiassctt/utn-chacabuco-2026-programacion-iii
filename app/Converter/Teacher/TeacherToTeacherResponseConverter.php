<?php 

namespace App\Converter\Teacher;

use App\Dto\Response\Teacher\TeacherResponse;
use App\Entity\Teacher\Teacher;

final class TeacherToTeacherResponseConverter {

    public function convert(Teacher $teacher): TeacherResponse
    {
        return new TeacherResponse(
            $teacher->getId(),
            $teacher->getName(),
            $teacher->getSurname(),
            $teacher->getEmail(),
            $teacher->getDni(),
            $teacher->getBirthDate()
        );
    }
}