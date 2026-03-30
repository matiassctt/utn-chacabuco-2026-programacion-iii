<?php

namespace App\Models;

use CodeIgniter\Database\BaseConnection;
use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';

    /**
     * Conexión directa a la base de datos.
     * Usamos $this->db para ejecutar queries SQL crudas.
     */
    protected BaseConnection $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    // =========================================================================
    // GET /users  →  Todos los usuarios paginados
    // =========================================================================

    /**
     * Retorna todos los usuarios activos (sin soft-deleted), con paginación.
     *
     * SQL:
     *   SELECT id, name, email, role, active, created_at, updated_at
     *   FROM users
     *   WHERE deleted_at IS NULL
     *   ORDER BY id ASC
     *   LIMIT :limit OFFSET :offset
     */
    public function getAll(int $page = 1, int $perPage = 10): array
    {
        $offset = ($page - 1) * $perPage;

        // ── Query principal con paginación ───────────────────────────────────
        $query = $this->db->query(
            'SELECT id, name, email, role, active, created_at, updated_at
             FROM users
             WHERE deleted_at IS NULL
             ORDER BY id ASC
             LIMIT ? OFFSET ?',
            [$perPage, $offset]
        );

        // ── Query para el total de registros ─────────────────────────────────
        $totalQuery = $this->db->query(
            'SELECT COUNT(*) AS total
             FROM users
             WHERE deleted_at IS NULL'
        );

        $total     = (int) $totalQuery->getRow()->total;
        $lastPage  = (int) ceil($total / $perPage);

        return [
            'data'  => $query->getResultArray(),
            'pager' => [
                'total'    => $total,
                'per_page' => $perPage,
                'page'     => $page,
                'lastPage' => $lastPage,
            ],
        ];
    }

    // =========================================================================
    // GET /users/{id}  →  Un usuario por ID
    // =========================================================================

    /**
     * Busca un usuario por su ID (excluye soft-deleted).
     *
     * SQL:
     *   SELECT id, name, email, role, active, created_at, updated_at
     *   FROM users
     *   WHERE id = :id AND deleted_at IS NULL
     *   LIMIT 1
     */
    public function getById(int $id): ?array
    {
        $query = $this->db->query(
            'SELECT id, name, email, role, active, created_at, updated_at
             FROM users
             WHERE id = ? AND deleted_at IS NULL
             LIMIT 1',
            [$id]
        );

        $result = $query->getRowArray();

        return $result ?: null;
    }

    // =========================================================================
    // POST /users  →  Crear usuario
    // =========================================================================

    /**
     * Inserta un nuevo usuario en la base de datos.
     *
     * SQL:
     *   INSERT INTO users (name, email, password, role, active, created_at, updated_at)
     *   VALUES (?, ?, ?, ?, ?, NOW(), NOW())
     */
    public function createUser(array $data): int|false
    {
        // Validar email duplicado antes de insertar
        if ($this->emailExists($data['email'])) {
            $this->setValidationError('email', 'El email ya está registrado.');
            return false;
        }

        $password = password_hash($data['password'], PASSWORD_BCRYPT);
        $role     = $data['role']   ?? 'user';
        $active   = $data['active'] ?? 1;

        $result = $this->db->query(
            'INSERT INTO users (name, email, password, role, active, created_at, updated_at)
             VALUES (?, ?, ?, ?, ?, NOW(), NOW())',
            [
                $data['name'],
                $data['email'],
                $password,
                $role,
                $active,
            ]
        );

        if (! $result) {
            return false;
        }

        return $this->db->insertID();
    }

    // =========================================================================
    // PUT /users/{id}  →  Actualizar usuario
    // =========================================================================

    /**
     * Actualiza los datos de un usuario existente.
     * Solo actualiza los campos que vengan en $data.
     *
     * SQL base:
     *   UPDATE users
     *   SET name = ?, email = ?, role = ?, active = ?, updated_at = NOW()
     *   WHERE id = ? AND deleted_at IS NULL
     *
     * Si viene password:
     *   UPDATE users
     *   SET name = ?, email = ?, password = ?, role = ?, active = ?, updated_at = NOW()
     *   WHERE id = ? AND deleted_at IS NULL
     */
    public function updateUser(int $id, array $data): bool
    {
        // Validar email duplicado en otro usuario
        if (
            isset($data['email']) &&
            $this->emailExistsForOther($data['email'], $id)
        ) {
            $this->setValidationError('email', 'El email ya está en uso por otro usuario.');
            return false;
        }

        // Construir SET dinámicamente según los campos recibidos
        $fields = [];
        $params = [];

        if (isset($data['name'])) {
            $fields[] = 'name = ?';
            $params[] = $data['name'];
        }

        if (isset($data['email'])) {
            $fields[] = 'email = ?';
            $params[] = $data['email'];
        }

        if (! empty($data['password'])) {
            $fields[] = 'password = ?';
            $params[] = password_hash($data['password'], PASSWORD_BCRYPT);
        }

        if (isset($data['role'])) {
            $fields[] = 'role = ?';
            $params[] = $data['role'];
        }

        if (isset($data['active'])) {
            $fields[] = 'active = ?';
            $params[] = (int) $data['active'];
        }

        if (empty($fields)) {
            return false;
        }

        $fields[]  = 'updated_at = NOW()';
        $params[]  = $id;

        $sql = 'UPDATE users SET ' . implode(', ', $fields) . ' WHERE id = ? AND deleted_at IS NULL';

        return $this->db->query($sql, $params);
    }

    // =========================================================================
    // DELETE /users/{id}  →  Soft-delete
    // =========================================================================

    /**
     * Marca el usuario como eliminado (soft-delete).
     *
     * SQL:
     *   UPDATE users
     *   SET deleted_at = NOW(), updated_at = NOW()
     *   WHERE id = ? AND deleted_at IS NULL
     */
    public function deleteUser(int $id): bool
    {
        return $this->db->query(
            'UPDATE users
             SET deleted_at = NOW(), updated_at = NOW()
             WHERE id = ? AND deleted_at IS NULL',
            [$id]
        );
    }

    // =========================================================================
    // Métodos auxiliares
    // =========================================================================

    /**
     * Busca un usuario por email (útil para login).
     *
     * SQL:
     *   SELECT * FROM users
     *   WHERE email = ? AND active = 1 AND deleted_at IS NULL
     *   LIMIT 1
     */
    public function findByEmail(string $email): ?array
    {
        $query = $this->db->query(
            'SELECT *
             FROM users
             WHERE email = ? AND active = 1 AND deleted_at IS NULL
             LIMIT 1',
            [$email]
        );

        $result = $query->getRowArray();

        return $result ?: null;
    }

    /**
     * Verifica si un email ya existe en la tabla.
     *
     * SQL:
     *   SELECT COUNT(*) AS total FROM users WHERE email = ? AND deleted_at IS NULL
     */
    private function emailExists(string $email): bool
    {
        $query = $this->db->query(
            'SELECT COUNT(*) AS total
             FROM users
             WHERE email = ? AND deleted_at IS NULL',
            [$email]
        );

        return (int) $query->getRow()->total > 0;
    }

    /**
     * Verifica si un email ya existe pero pertenece a otro usuario (para UPDATE).
     *
     * SQL:
     *   SELECT COUNT(*) AS total FROM users WHERE email = ? AND id != ? AND deleted_at IS NULL
     */
    private function emailExistsForOther(string $email, int $excludeId): bool
    {
        $query = $this->db->query(
            'SELECT COUNT(*) AS total
             FROM users
             WHERE email = ? AND id != ? AND deleted_at IS NULL',
            [$email, $excludeId]
        );

        return (int) $query->getRow()->total > 0;
    }

    /**
     * Helper para setear errores de validación manualmente.
     */
    private function setValidationError(string $field, string $message): void
    {
        $this->validation->setError($field, $message);
    }
}