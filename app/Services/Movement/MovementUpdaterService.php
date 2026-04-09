<?php 

namespace App\Services\Movement;

use App\Models\MovementModel;

final class MovementUpdaterService {
    private MovementModel $movementModel;
    private MovementFinderService $movementFinderService;

    public function __construct() {
        $this->movementModel = new MovementModel();
        $this->movementFinderService = new MovementFinderService();
    }

    public function update(string $name, int $id): void
    {
        $movement = $this->movementFinderService->find($id);
        $this->movementModel->update($name, $movement->id);
    }
}