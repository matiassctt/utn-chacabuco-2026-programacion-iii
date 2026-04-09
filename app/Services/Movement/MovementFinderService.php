<?php 

namespace App\Services\Movement;

use App\Models\MovementModel;
use App\Exception\Movement\MovementNotFoundException;

final class MovementFinderService {

    private MovementModel $movementModel;

    public function __construct() {
        $this->movementModel = new MovementModel();
    }

    public function find(int $id): object 
    {
        $movement = $this->movementModel->find($id);

        if (empty($movement)) {
            throw new MovementNotFoundException($id);
        }

        return $movement;
    }
}