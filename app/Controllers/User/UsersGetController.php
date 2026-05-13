<?php 

namespace App\Controllers\User;

use App\Dto\Request\PaginationRequest;
use App\Dto\Request\User\UserFilterRequest;
use App\Services\User\UsersSearcherService;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\ResponseInterface;

final class UsersGetController extends ResourceController {
    private UsersSearcherService $usersSearcherService;

    public function __construct() {
        $this->usersSearcherService = new UsersSearcherService();
    }

    public function search(): ResponseInterface 
    {
        $request = $this->getRequest();

        $responses = $this->usersSearcherService->searchResponses($request);
        
        return $this->response->setJSON($responses);
    }

    private function getRequest(): UserFilterRequest
    {
        $request = $this->request->getJSON();

        return new UserFilterRequest(
            new PaginationRequest(
                $request->page ?? 1,
                $request->size ?? 10,
            ),
            $request->email ?? null
        );
    }
}