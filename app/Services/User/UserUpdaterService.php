<?php 

namespace App\Services\User;

use App\Converter\User\UserToUserResponseConverter;
use App\Dto\Request\User\UserRequest;
use App\Dto\Response\User\UserResponse;
use App\Models\UserModel;

final class UserUpdaterService {
    private UserModel $userModel;
    private UserFinderService $userFinderService;
    private UserToUserResponseConverter $converter;

    public function __construct() {
        $this->userModel = new UserModel();
        $this->userFinderService = new UserFinderService();
        $this->converter = new UserToUserResponseConverter();
    }

    public function update(UserRequest $request, int $id): UserResponse
    {
        $user = $this->userFinderService->find($id);
        
        $user->update($request);

        $user = $this->userModel->update($user);

        $response = $this->converter->convert($user);

        return $response;
    }
}