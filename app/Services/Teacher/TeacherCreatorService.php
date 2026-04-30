<?php 

namespace App\Services\Teacher;

use App\Converter\Teacher\TeacherToTeacherResponseConverter;
use App\Dto\Request\Teacher\TeacherRequest;
use App\Dto\Response\Teacher\TeacherResponse;
use App\Entity\Teacher\Teacher;
use App\Models\TeacherModel;

final class TeacherCreatorService {

    private TeacherModel $teacherModel;
    private TeacherToTeacherResponseConverter $converter;

    public function __construct() {
        $this->teacherModel = new TeacherModel();
        $this->converter = new TeacherToTeacherResponseConverter();
    }

    public function create(TeacherRequest $request): TeacherResponse
    {
        $teacher = Teacher::convertFromRequest($request);

        $newTeacher = $this->teacherModel->insert($teacher);

        $teacherResponse = $this->converter->convert($newTeacher);

        return $teacherResponse;
    }
}