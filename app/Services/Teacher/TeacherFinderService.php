<?php 

namespace App\Services\Teacher;

use App\Models\TeacherModel;
use App\Exception\Teacher\TeacherNotFoundException;

final class TeacherFinderService {

    private TeacherModel $teacherModel;

    public function __construct() {
        $this->teacherModel = new TeacherModel();
    }

    public function find(int $id): object 
    {
        $teacher = $this->teacherModel->find($id);

        if (empty($teacher)) {
            throw new TeacherNotFoundException($id);
        }

        return $teacher;
    }
}