<?php

namespace App\Controllers\Teacher;

use App\Services\Teacher\TeacherDeleterService;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class TeacherDeleteController extends ResourceController{
    private TeacherDeleterService $teacherDeleterService;
    
    public function __construct(){
        $this->teacherDeleterService = new TeacherDeleterService();
    }
    
    public function do(int $id): ResponseInterface
    {
        $this->teacherDeleterService->delete($id);

        return $this->response->setJSON([
            "id"  => $id
        ]);
    }
}




