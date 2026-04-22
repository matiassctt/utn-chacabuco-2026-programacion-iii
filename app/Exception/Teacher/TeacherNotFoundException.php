<?php 

namespace App\Exception\Teacher;

use Exception;

class TeacherNotFoundException extends Exception {
    public function __construct(int $id) {
        parent::__construct("No se encontro el teacher con id: $id", 404);
    }
}