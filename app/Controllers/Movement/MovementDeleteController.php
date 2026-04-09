<?php

namespace App\Controllers\Movement;

use App\Services\Movement\MovementDeleterService;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class MovementDeleteController extends ResourceController{
    private MovementDeleterService $movementDeleterService;
    
    public function __construct(){
        $this->movementDeleterService = new MovementDeleterService();
    }
    
    public function do(int $id): ResponseInterface
    {
        $this->movementDeleterService->delete($id);

        return $this->response->setJSON([
            "id"  => $id
        ]);
    }
}




