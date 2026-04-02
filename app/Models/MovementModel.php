<?php 

namespace App\Models;

use Config\Database;
use CodeIgniter\Database\BaseConnection;

final class MovementModel {

    private BaseConnection $database;

    public function __construct() {
        $this->database = Database::connect();
    }

    public function insert(string $name): int
    {
        $query = "INSERT INTO movements (name) VALUES (?) ";
        $this->database->query($query, [$name]);

        return $this->database->insertID();
    }

}