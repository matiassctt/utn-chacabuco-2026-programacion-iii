<?php 

namespace App\Controllers\Teacher;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use App\Services\Teacher\TeacherCreatorService;

class TeacherPostController extends ResourceController {

    private TeacherCreatorService $teacherCreatorService;

    public function __construct() {
        $this->teacherCreatorService = new TeacherCreatorService();
    }

    public function create(): ResponseInterface 
    {
        $parameters = $this->request->getJson();

        $name = $parameters->name;
        $surname = $parameters->surname;
        $email = $parameters->email;
        $dni = $parameters->dni;

        $id = $this->teacherCreatorService->create($name, $surname, $email, $dni);

        return $this->response->setJSON([
            "id" => $id
        ]);   
    }

}