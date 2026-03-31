<?php

namespace App\Controllers\User;

use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

/**
 * POST /users
 * Crea un nuevo usuario.
 */
class CreateController extends ResourceController
{
    protected $modelName = UserModel::class;
    protected $format    = 'json';

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
}
