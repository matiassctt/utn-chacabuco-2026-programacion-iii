<?php

namespace App\Controllers\User;

use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

/**
 * GET /users
 * Retorna todos los usuarios paginados.
 */
class IndexController extends ResourceController
{
    protected $modelName = UserModel::class;
    protected $format    = 'json';

    public function index(): ResponseInterface
    {
        $page    = (int) ($this->request->getGet('page')     ?? 1);
        $perPage = (int) ($this->request->getGet('per_page') ?? 10);

        $result = $this->model->getAll($page, $perPage);

        return $this->respond([
            'status' => 'success',
            'data'   => $result['data'],
            'pager'  => $result['pager'],
        ]);
    }
}
