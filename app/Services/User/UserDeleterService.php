<?php

namespace App\Services\User;

use App\Models\UserModel;

final class UserDeleterService {

    private UserModel $userModel;
    private UserFinderService $userFinderService;

    public function __construct(){
        $this->userModel = new UserModel();
        $this->userFinderService = new UserFinderService();
    }

    public function delete(int $id): void 
    {
        $user = $this->userFinderService->find($id);

        $this->userModel->delete($user->getId());
    } 
}