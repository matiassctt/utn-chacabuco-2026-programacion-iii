<?php 

namespace App\Controllers\User;

use App\Services\User\UserFinderService;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class UserGetController extends ResourceController {
    private UserFinderService $userFinderService;

    public function __construct() {
        $this->userFinderService = new UserFinderService();
    }

    public function find(int $id): ResponseInterface 
    {
        $user = $this->userFinderService->findResponse($id);
        return $this->response->setJSON($user);
    }
}