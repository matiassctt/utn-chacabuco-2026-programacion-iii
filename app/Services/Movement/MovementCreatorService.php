<?php 

namespace App\Services\Movement;

use App\Models\MovementModel;

final class MovementCreatorService {

    private MovementModel $movementModel;

    public function __construct() {
        $this->movementModel = new MovementModel();
    }

    public function create(string $name): int
    {
        $id = $this->movementModel->insert($name);
        return $id;
    }
}