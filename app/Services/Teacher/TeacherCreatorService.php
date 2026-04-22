<?php 

namespace App\Services\Teacher;

use App\Models\TeacherModel;

final class TeacherCreatorService {

    private TeacherModel $teacherModel;

    public function __construct() {
        $this->teacherModel = new TeacherModel();
    }

    public function create(string $name, string $surname, string $email, int $dni): int
    {
        $id = $this->teacherModel->insert($name, $surname, $email, $dni);
        return $id;
    }
}