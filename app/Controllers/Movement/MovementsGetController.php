<?php 

namespace App\Controllers\Movement;

use App\Services\Movement\MovementsSearcherService;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\ResponseInterface;

final class MovementsGetController extends ResourceController {
    private MovementsSearcherService $movementsSearcherService;

    public function __construct() {
        $this->movementsSearcherService = new MovementsSearcherService();
    }

    public function search(): ResponseInterface 
    {
        $movements = $this->movementsSearcherService->search();

        return $this->response->setJSON($movements);
    }
}