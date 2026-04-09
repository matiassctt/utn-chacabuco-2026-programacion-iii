<?php 

namespace App\Exception\Movement;

use Exception;

class MovementNotFoundException extends Exception {
    public function __construct(int $id) {
        parent::__construct("No se encontro el movement con id: $id", 404);
    }
}