<?php 

namespace App\Services\Teacher;

use App\Models\TeacherModel;

final class TeacherUpdaterService {
    private TeacherModel $teacherModel;
    private TeacherFinderService $teacherFinderService;

    public function __construct() {
        $this->teacherModel = new TeacherModel();
        $this->teacherFinderService = new TeacherFinderService();
    }

    public function update(string $name, string $surname, string $email, int $dni, int $id): void
    {
        $teacher = $this->teacherFinderService->find($id);
        $this->teacherModel->update($name, $surname, $email, $dni, $teacher->id);
    }
}