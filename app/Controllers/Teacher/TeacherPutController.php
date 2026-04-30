<?php 

namespace App\Controllers\Teacher;

use App\Dto\Request\Teacher\TeacherRequest;
use App\Services\Teacher\TeacherUpdaterService;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use DateTime;

class TeacherPutController extends ResourceController {
    private TeacherUpdaterService $teacherUpdaterService;

    public function __construct() {
        $this->teacherUpdaterService = new TeacherUpdaterService();
    }

    public function put(int $id): ResponseInterface 
    {
        $request = $this->getRequest();

        $response = $this->teacherUpdaterService->update($request, $id);

        return $this->response->setJSON($response);
    }

    private function getRequest(): TeacherRequest
    {
        $request = $this->request->getJSON();

        return new TeacherRequest(
            $request->name,
            $request->surname,
            $request->email,
            $request->dni,
            new DateTime($request->birthdate)
        );
    }
}