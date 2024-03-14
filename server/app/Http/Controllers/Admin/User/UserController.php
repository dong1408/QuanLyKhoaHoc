<?php

namespace App\Http\Controllers\Admin\User;

use App\Exceptions\User\UserNotHavePermissionException;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\RegisterUserRequest;
use App\Http\Requests\User\UpdateRoleOfUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Service\User\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        $this->middleware('auth:api');
    }

    public function getAllUser(Request $request): Response
    {
        $result = $this->userService->getAllUser($request);
        return response()->json($result, 200);
    }

    public function getUserPaging(Request $request): response
    {
        $result = $this->userService->getUserPaging($request);
        return response()->json($result, 200);
    }

    public function getUserDetail(int $id): response
    {
        // if (!Gate::allows('user.view', $id)) {
        //     throw new UserNotHavePermissionException();
        // }
        $result = $this->userService->getUserDetail($id);
        return response()->json($result, 200);
    }


    public function getRoleOfUser(): response
    {
        $result = $this->userService->getRoleOfUser();
        return response()->json($result, 200);
    }


    public function getPermissionOfUser(): response
    {
        $result = $this->userService->getPermissionOfUser();
        return response()->json($result, 200);
    }

    public function registerUser(RegisterUserRequest $request): response
    {
        $result = $this->userService->registerUser($request);
        return response()->json($result, 200);
    }

    public function updateUser(UpdateUserRequest $request, int $id): response
    {
        $result = $this->userService->updateUser($request, $id);
        return response()->json($result, 200);
    }

    public function updateRoleOfUser(UpdateRoleOfUserRequest $request, int $id)
    {
        $result = $this->userService->updateRoleOfUser($request, $id);
        return response()->json($result, 200);
    }

    public function deleteUser(int $id): response
    {
        $result = $this->userService->deleteUser($id);
        return response()->json($result, 200);
    }

    public function restoreUser(int $id): response
    {
        $result = $this->userService->restoreUser($id);
        return response()->json($result, 200);
    }

    public function forceDeleteUser(int $id): response
    {
        $result = $this->userService->forceDeleteUser($id);
        return response()->json($result, 200);
    }
}
