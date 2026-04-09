<?php 

namespace App\Controllers\Movement;

use App\Services\Movement\MovementUpdaterService;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class MovementPutController extends ResourceController {
    private MovementUpdaterService $movementUpdaterService;

    public function __construct() {
        $this->movementUpdaterService = new MovementUpdaterService();
    }

    public function put(int $id): ResponseInterface 
    {
        $request = $this->request->getJSON();
        $name = $request->name;

        $this->movementUpdaterService->update($name, $id);

        return $this->response->setJSON([
            "id" => $id
        ]);
    }
}