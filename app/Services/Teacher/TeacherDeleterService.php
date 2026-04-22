<?php

namespace App\Services\Teacher;

use App\Models\TeacherModel;

final class TeacherDeleterService {

    private TeacherModel $teacherModel;
    private TeacherFinderService $teacherFinderService;

    public function __construct(){
        $this->teacherModel = new TeacherModel();
        $this->teacherFinderService = new TeacherFinderService();
    }

    public function delete (int $id): void {
        $teacher = $this->teacherFinderService->find($id);
        $this->teacherModel->delete($teacher->id);
    } 
}