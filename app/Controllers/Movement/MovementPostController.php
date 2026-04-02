<?php 

namespace App\Controllers\Movement;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use App\Services\Movement\MovementCreatorService;

class MovementPostController extends ResourceController {

    private MovementCreatorService $movementCreatorService;

    public function __construct() {
        $this->movementCreatorService = new MovementCreatorService();
    }

    public function create(): ResponseInterface 
    {
        $parameters = $this->request->getJson();

        $name = $parameters->name;

        $id = $this->movementCreatorService->create($name);

        return $this->response->setJSON([
            "id" => $id
        ]);   
    }

}