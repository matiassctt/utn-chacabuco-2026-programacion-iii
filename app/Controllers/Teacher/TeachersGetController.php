<?php 

namespace App\Controllers\Teacher;

use App\Dto\Request\PaginationRequest;
use App\Dto\Request\Teacher\TeacherFilterRequest;
use App\Services\Teacher\TeachersSearcherService;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\ResponseInterface;

final class TeachersGetController extends ResourceController {
    private TeachersSearcherService $teachersSearcherService;

    public function __construct() {
        $this->teachersSearcherService = new TeachersSearcherService();
    }

    public function search(): ResponseInterface 
    {
        $request = $this->getRequest();

        $responses = $this->teachersSearcherService->searchResponses($request);
        
        return $this->response->setJSON($responses);
    }

    private function getRequest(): TeacherFilterRequest
    {
        $request = $this->request->getJSON();

        return new TeacherFilterRequest(
            new PaginationRequest(
                $request->page ?? 1,
                $request->size ?? 10,
            ),
            $request->email ?? null
        );
    }
}