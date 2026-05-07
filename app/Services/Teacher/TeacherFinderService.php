<?php 

namespace App\Services\Teacher;

use App\Converter\Teacher\TeacherToTeacherResponseConverter;
use App\Dto\Response\Teacher\TeacherResponse;
use App\Entity\Teacher\Teacher;
use App\Models\TeacherModel;
use App\Exception\Teacher\TeacherNotFoundException;

final class TeacherFinderService {

    private TeacherModel $teacherModel;
    private TeacherToTeacherResponseConverter $converter;

    public function __construct() {
        $this->teacherModel = new TeacherModel();
        $this->converter = new TeacherToTeacherResponseConverter();
    }

    public function find(int $id): Teacher 
    {
        $teacher = $this->teacherModel->find($id);

        if (empty($teacher)) {
            throw new TeacherNotFoundException($id);
        }

        return $teacher;
    }

    public function findResponse(int $id): TeacherResponse
    {
        $teacher = $this->find($id);
        
        $response = $this->converter->convert($teacher);

        return $response;
    }
}