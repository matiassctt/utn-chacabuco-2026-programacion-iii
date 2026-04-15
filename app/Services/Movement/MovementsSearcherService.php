<?php 

namespace App\Services\Movement;

use App\Models\MovementModel;

final class MovementsSearcherService {

    private MovementModel $movementModel;

    public function __construct() {
        $this->movementModel = new MovementModel();
    }

    public function search(): array
    {
        return $this->movementModel->search();
    }
}