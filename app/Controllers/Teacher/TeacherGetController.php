<?php 

namespace App\Controllers\Teacher;

use App\Services\Teacher\TeacherFinderService;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class TeacherGetController extends ResourceController {
    private TeacherFinderService $teacherFinderService;

    public function __construct() {
        $this->teacherFinderService = new TeacherFinderService();
    }

    public function find(int $id): ResponseInterface 
    {
        $teacher = $this->teacherFinderService->find($id);
        return $this->response->setJSON($teacher);
    }
}