<?php 

namespace App\Models;

use CodeIgniter\Database\Query;
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

    public function update(string $name, int $id): void
    {
        $query = "UPDATE movements SET name = ? WHERE id = ?";
        $this->database->query($query, [$name, $id]);
    }

    public function find(int $id): ?object
    {
        $query = "SELECT M.id, M.name FROM movements M WHERE id = ? ";
        $result = $this->database->query($query, [$id]);

        return $result->getRow();
    }

    public function search(): array 
    {
        $query = "SELECT M.id, M.name FROM movements M";
        $result = $this->database->query($query);

        return $result->getResult();
    }

    public function delete(int $id): void
    {
        $query = "DELETE FROM movements WHERE id = ?";
        $this->database->query($query, [$id]);
    }

}