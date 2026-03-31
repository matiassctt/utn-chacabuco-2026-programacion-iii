<?php

namespace App\Controllers\User;

use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

/**
 * PUT /users/{id}
 * Actualiza un usuario existente.
 */
class UpdateController extends ResourceController
{
    protected $modelName = UserModel::class;
    protected $format    = 'json';

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
}
