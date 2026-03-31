<?php

namespace App\Controllers\User;

use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

/**
 * GET /users/{id}
 * Retorna un usuario por ID.
 */
class ShowController extends ResourceController
{
    protected $modelName = UserModel::class;
    protected $format    = 'json';

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
}
