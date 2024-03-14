<?php

namespace App\Service\RolePermission;

use App\Http\Requests\RolePermission\AddPermissionRequest;
use App\Http\Requests\RolePermission\UpdatePermissionRequest;
use App\Utilities\ResponseSuccess;
use Illuminate\Http\Request;

interface PermissionService
{
    public function getAllPermission(): ResponseSuccess;
    public function addPermission(AddPermissionRequest $request): ResponseSuccess;
    public function udpatePermission(UpdatePermissionRequest $request, int $id): ResponseSuccess;
}
