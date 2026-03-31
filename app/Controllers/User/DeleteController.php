<?php

namespace App\Controllers\User;

use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

/**
 * DELETE /users/{id}
 * Soft-delete de un usuario.
 */
class DeleteController extends ResourceController
{
    protected $modelName = UserModel::class;
    protected $format    = 'json';

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
