<?php 

namespace App\Services\Teacher;

use App\Models\TeacherModel;

final class TeachersSearcherService {

    private TeacherModel $teacherModel;

    public function __construct() {
        $this->teacherModel = new TeacherModel();
    }

    public function search(): array
    {
        return $this->teacherModel->search();
    }
}