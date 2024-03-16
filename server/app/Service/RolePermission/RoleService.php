<?php

namespace App\Service\RolePermission;

use App\Http\Requests\RolePermission\AddRoleRequest;
use App\Http\Requests\RolePermission\UpdateRoleRequest;
use App\Utilities\ResponseSuccess;
use Illuminate\Http\Request;

interface RoleService
{
    public function getAllRole(): ResponseSuccess;
    public function addRole(AddRoleRequest $request): ResponseSuccess;
    public function updateRole(UpdateRoleRequest $request, int $id): ResponseSuccess;
    public function getPermissionsOfRole(int $roleId): ResponseSuccess;
    // public function deleteRole(): ResponseSuccess;
}
