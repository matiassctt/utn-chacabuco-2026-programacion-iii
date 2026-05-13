<?php 

namespace App\Models;

use App\Converter\User\PrimitiveToUserConverter;
use App\Dto\Request\User\UserFilterRequest;
use App\Entity\User\User;
use Config\Database;
use CodeIgniter\Database\BaseConnection;

final class UserModel {

    private BaseConnection $database;
    private PrimitiveToUserConverter $converter;

    public function __construct() {
        $this->database = Database::connect();
        $this->converter = new PrimitiveToUserConverter();
    }

    public function insert(User $user): User
    {
        $query = "INSERT INTO users (username, email, password, dni) VALUES (?, ?, ?, ?) ";

        $this->database->query($query, [
            $user->getUserName(), 
            $user->getEmail(), 
            $user->getPassword(), 
            $user->getDni()
        ]);

        $id = $this->database->insertID();

        return new User(
            $id,
            $user->getUserName(), 
            $user->getEmail(), 
            $user->getPassword(), 
            $user->getDni()
        );
    }

    public function update(User $user): User
    {
        $query = "UPDATE users SET username = ?, email = ?, password = ?, dni = ? WHERE id = ?";

        $this->database->query($query, [
            $user->getUserName(), 
            $user->getEmail(), 
            $user->getPassword(), 
            $user->getDni(), 
            $user->getId()
        ]);

        return $user;
    }

    public function find(int $id): ?User
    {
        $query = "SELECT U.id, U.username, U.email, U.password, U.dni FROM users U WHERE U.id = ? ";
        $result = $this->database->query($query, [$id]);

        $primitive = $result->getRow();

        if (is_null($primitive)) {
            return null;
        }

        $user = $this->converter->convert($primitive);

        return $user;
    }

    /**
     * @return User[]
     */
    public function search(UserFilterRequest $request): array 
    {
        $parameters = [];

        $selectQuery = "SELECT U.id, U.username, U.email, U.password, U.dni ";

        $fromQuery = "FROM users U ";
        $whereQuery = "WHERE 1 = 1 ";
        if ($request->hasEmail()) {
            $whereQuery.= " AND U.email LIKE ? ";
            $email = $request->getEmail();
            $parameters[] = "%$email%";
        }

        $orderQuery = "ORDER BY U.id ASC ";

        $paginationQuery = "LIMIT ?, ? ";
        $parameters[] = $request->getPagination()->getLimit();
        $parameters[] = $request->getPagination()->getOffset();

        $fullQuery = $selectQuery.$fromQuery.$whereQuery.$orderQuery.$paginationQuery;

        $result = $this->database->query($fullQuery, $parameters);

        $primitives = $result->getResult();

        $entities = [];
        foreach ($primitives as $primitive) {
            $entities[] = $this->converter->convert($primitive);
        }

        return $entities;
    }

    public function delete(int $id): void
    {
        $query = "DELETE FROM users WHERE id = ?";
        $this->database->query($query, [$id]);
    }
}