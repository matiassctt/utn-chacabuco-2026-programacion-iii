<?php

namespace App\Services\Movement;

use App\Models\MovementModel;

final class MovementDeleterService {

    private MovementModel $movementModel;
    private MovementFinderService $movementFinderService;

    public function __construct(){
        $this->movementModel = new MovementModel();
        $this->movementFinderService = new MovementFinderService();
    }

    public function delete (int $id): void {
        $movement = $this->movementFinderService->find($id);
        $this->movementModel->delete($movement->id);
    } 
}