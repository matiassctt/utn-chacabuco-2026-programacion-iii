<?php 

namespace App\Controllers\Teacher;

use App\Dto\Request\Teacher\TeacherRequest;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use App\Services\Teacher\TeacherCreatorService;
use DateTime;

class TeacherPostController extends ResourceController {

    private TeacherCreatorService $teacherCreatorService;

    public function __construct() {
        $this->teacherCreatorService = new TeacherCreatorService();
    }

    public function create(): ResponseInterface 
    {
        $teacherRequest = $this->getRequest();

        $teacherResponse = $this->teacherCreatorService->create($teacherRequest);

        return $this->response->setJSON($teacherResponse);   
    }

    private function getRequest(): TeacherRequest
    {
        $parameters = $this->request->getJson();

        return new TeacherRequest(
            $parameters->name,
            $parameters->surname,
            $parameters->email,
            $parameters->dni,
            new DateTime($parameters->birthdate)
        );
    }

}