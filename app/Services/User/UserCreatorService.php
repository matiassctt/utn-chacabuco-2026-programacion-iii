<?php 

namespace App\Services\User;

use App\Converter\User\UserToUserResponseConverter;
use App\Dto\Request\User\UserRequest;
use App\Dto\Response\User\UserResponse;
use App\Entity\User\User;
use App\Models\UserModel;

final class UserCreatorService {

    private UserModel $userModel;
    private UserToUserResponseConverter $converter;

    public function __construct() {
        $this->userModel = new UserModel();
        $this->converter = new UserToUserResponseConverter();
    }

    public function create(UserRequest $request): UserResponse
    {
        $user = User::convertFromRequest($request);

        $newUser = $this->userModel->insert($user);

        $userResponse = $this->converter->convert($newUser);

        return $userResponse;
    }
}