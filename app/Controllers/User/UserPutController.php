<?php 

namespace App\Controllers\User;

use App\Dto\Request\User\UserRequest;
use App\Services\User\UserUpdaterService;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use DateTime;

class UserPutController extends ResourceController {
    private UserUpdaterService $userUpdaterService;

    public function __construct() {
        $this->userUpdaterService = new UserUpdaterService();
    }

    public function put(int $id): ResponseInterface 
    {
        $request = $this->getRequest();

        $response = $this->userUpdaterService->update($request, $id);

        return $this->response->setJSON($response);
    }

    private function getRequest(): UserRequest
    {
        $request = $this->request->getJSON();

        return new UserRequest(
            $request->username,
            $request->email,
            $request->password,
            $request->dni ?? null
        );
    }
}