<?php 

namespace App\Controllers\Teacher;

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
        $teachers = $this->teachersSearcherService->search();

        return $this->response->setJSON($teachers);
    }
}