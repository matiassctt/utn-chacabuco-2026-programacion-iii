<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class UserController extends ResourceController
{
    protected $modelName = UserModel::class;
    protected $format    = 'json';

    // -------------------------------------------------------------------------
    // GET /users
    // -------------------------------------------------------------------------
    public function index(): ResponseInterface
    {
        $perPage = (int) ($this->request->getGet('per_page') ?? 10);

        $result = $this->model->getAll($perPage);

        return $this->respond([
            'status'  => 'success',
            'data'    => $result['data'],
            'pager'   => $result['pager'],
        ]);
    }

    // -------------------------------------------------------------------------
    // GET /users/{id}
    // -------------------------------------------------------------------------
    public function show($id = null): ResponseInterface
    {
        $user = $this->model->getById((int) $id);

        if (! $user) {
            return $this->failNotFound("Usuario con ID {$id} no encontrado.");
        }

        return $this->respond([
            'status' => 'success',
            'data'   => $user,
        ]);
    }

    // -------------------------------------------------------------------------
    // POST /users
    // -------------------------------------------------------------------------
    public function create(): ResponseInterface
    {
        $data = $this->request->getJSON(true) ?? $this->request->getPost();

        if (empty($data)) {
            return $this->failValidationErrors('No se recibieron datos.');
        }

        $insertId = $this->model->createUser($data);

        if ($insertId === false) {
            return $this->failValidationErrors($this->model->errors());
        }

        $user = $this->model->getById($insertId);

        return $this->respondCreated([
            'status'  => 'success',
            'message' => 'Usuario creado correctamente.',
            'data'    => $user,
        ]);
    }

    // -------------------------------------------------------------------------
    // PUT /users/{id}
    // -------------------------------------------------------------------------
    public function update($id = null): ResponseInterface
    {
        $user = $this->model->getById((int) $id);

        if (! $user) {
            return $this->failNotFound("Usuario con ID {$id} no encontrado.");
        }

        $data = $this->request->getJSON(true) ?? $this->request->getRawInput();

        if (empty($data)) {
            return $this->failValidationErrors('No se recibieron datos.');
        }

        if (! $this->model->updateUser((int) $id, $data)) {
            return $this->failValidationErrors($this->model->errors());
        }

        return $this->respond([
            'status'  => 'success',
            'message' => 'Usuario actualizado correctamente.',
            'data'    => $this->model->getById((int) $id),
        ]);
    }

    // -------------------------------------------------------------------------
    // DELETE /users/{id}
    // -------------------------------------------------------------------------
    public function delete($id = null): ResponseInterface
    {
        $user = $this->model->getById((int) $id);

        if (! $user) {
            return $this->failNotFound("Usuario con ID {$id} no encontrado.");
        }

        if (! $this->model->deleteUser((int) $id)) {
            return $this->fail('No se pudo eliminar el usuario.');
        }

        return $this->respondDeleted([
            'status'  => 'success',
            'message' => "Usuario con ID {$id} eliminado correctamente.",
        ]);
    }
}