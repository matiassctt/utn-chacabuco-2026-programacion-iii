<?php 

namespace App\Models;

use App\Converter\Teacher\PrimitiveToTeacherConverter;
use App\Entity\Teacher\Teacher;
use Config\Database;
use CodeIgniter\Database\BaseConnection;

final class TeacherModel {

    private BaseConnection $database;
    private PrimitiveToTeacherConverter $converter;

    public function __construct() {
        $this->database = Database::connect();
        $this->converter = new PrimitiveToTeacherConverter();
    }

    public function insert(Teacher $teacher): Teacher
    {
        $query = "INSERT INTO teachers (name, surname, email, dni, birth_date) VALUES (?, ?, ?, ?, ?) ";

        $this->database->query($query, [
            $teacher->getName(), 
            $teacher->getSurname(), 
            $teacher->getEmail(), 
            $teacher->getDni(),
            $teacher->getBirthDate()->format("Y-m-d")
        ]);

        $id = $this->database->insertID();

        return new Teacher(
            $id,
            $teacher->getName(),
            $teacher->getSurname(),
            $teacher->getEmail(),
            $teacher->getDni(),
            $teacher->getBirthDate()
        );
    }

    public function update(Teacher $teacher): Teacher
    {
        $query = "UPDATE teachers SET name = ?, surname = ?, email = ?, dni = ?, birth_date = ? WHERE id = ?";

        $this->database->query($query, [
            $teacher->getName(), 
            $teacher->getSurname(), 
            $teacher->getEmail(), 
            $teacher->getDni(),
            $teacher->getBirthDate()->format("Y-m-d"), 
            $teacher->getId()
        ]);

        return $teacher;
    }

    public function find(int $id): ?Teacher
    {
        $query = "SELECT T.id, T.name, T.surname, T.email, T.dni, T.birth_date FROM teachers T WHERE T.id = ? ";
        $result = $this->database->query($query, [$id]);

        $primitive = $result->getRow();

        if (is_null($primitive)) {
            return null;
        }

        $teacher = $this->converter->convert($primitive);

        return $teacher;
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