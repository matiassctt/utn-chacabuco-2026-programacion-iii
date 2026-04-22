<?php 

namespace App\Models;

use Config\Database;
use CodeIgniter\Database\BaseConnection;

final class TeacherModel {

    private BaseConnection $database;

    public function __construct() {
        $this->database = Database::connect();
    }

    public function insert(string $name, string $surname, string $email, int $dni): int
    {
        $query = "INSERT INTO teachers (name, surname, email, dni) VALUES (?, ?, ?, ?) ";
        $this->database->query($query, [$name, $surname, $email, $dni]);

        return $this->database->insertID();
    }

    public function update(string $name, string $surname, string $email, int $dni, int $id): void
    {
        $query = "UPDATE teachers SET name = ?, surname = ?, email = ?, dni = ? WHERE id = ?";
        $this->database->query($query, [$name, $surname, $email, $dni, $id]);
    }

    public function find(int $id): ?object
    {
        $query = "SELECT T.id, T.name, T.surname, T.email, T.dni FROM teachers T WHERE T.id = ? ";
        $result = $this->database->query($query, [$id]);

        return $result->getRow();
    }

    public function search(): array 
    {
        $query = "SELECT T.id, T.name, T.surname, T.email, T.dni FROM teachers T";
        $result = $this->database->query($query);

        return $result->getResult();
    }

    public function delete(int $id): void
    {
        $query = "DELETE FROM teachers WHERE id = ?";
        $this->database->query($query, [$id]);
    }

}