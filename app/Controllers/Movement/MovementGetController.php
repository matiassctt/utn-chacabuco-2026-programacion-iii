<?php 

namespace App\Controllers\Movement;

use App\Services\Movement\MovementFinderService;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class MovementGetController extends ResourceController {
    private MovementFinderService $movementFinderService;

    public function __construct() {
        $this->movementFinderService = new MovementFinderService();
    }

    public function find(int $id): ResponseInterface 
    {
        $movement = $this->movementFinderService->find($id);
        return $this->response->setJSON($movement);
    }
}