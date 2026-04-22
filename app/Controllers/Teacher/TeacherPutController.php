<?php 

namespace App\Controllers\Teacher;

use App\Services\Teacher\TeacherUpdaterService;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class TeacherPutController extends ResourceController {
    private TeacherUpdaterService $teacherUpdaterService;

    public function __construct() {
        $this->teacherUpdaterService = new TeacherUpdaterService();
    }

    public function put(int $id): ResponseInterface 
    {
        $request = $this->request->getJSON();

        $name = $request->name;
        $surname = $request->surname;
        $email = $request->email;
        $dni = $request->dni;

        $this->teacherUpdaterService->update($name, $surname, $email, $dni, $id);

        return $this->response->setJSON([
            "id" => $id
        ]);
    }
}