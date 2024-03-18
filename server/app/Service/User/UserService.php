<?php

namespace App\Service\User;

use App\Http\Requests\User\ChangePasswordRequest;
use App\Http\Requests\User\RegisterUserRequest;
use App\Http\Requests\User\UpdateRoleOfUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Utilities\ResponseSuccess;
use Illuminate\Http\Request;

interface UserService
{
    public function getAllUser(Request $request): ResponseSuccess;
    public function getUserPaging(Request $request): ResponseSuccess;
    public function getUserDetail(int $id): ResponseSuccess;
    public function getUserInfo(): ResponseSuccess;
    public function getRoleOfUser(int $id): ResponseSuccess;
    public function getPermissionOfUser(): ResponseSuccess;
    public function registerUser(RegisterUserRequest $request): ResponseSuccess;
    public function updateUser(UpdateUserRequest $request, int $id): ResponseSuccess;
    public function updateRoleOfUser(UpdateRoleOfUserRequest $request, int $id): ResponseSuccess;
    public function deleteUser(int $id): ResponseSuccess;
    public function restoreUser(int $id): ResponseSuccess;
    public function forceDeleteUser(int $id): ResponseSuccess;
    public function changePassword(ChangePasswordRequest $request): ResponseSuccess;
}
