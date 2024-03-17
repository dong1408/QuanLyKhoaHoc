<?php

namespace App\Http\Controllers\Admin\RolePermission;


use App\Http\Controllers\Controller;
use App\Http\Requests\RolePermission\AddRoleRequest;
use App\Http\Requests\RolePermission\UpdateRoleRequest;
use App\Service\RolePermission\RoleService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends Controller
{
    private RoleService $roleService;
    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
        $this->middleware('auth:api');
    }

    public function getAllRole(): response
    {
        $result = $this->roleService->getAllRole();
        return response()->json($result, 200);
    }

    public function addRole(AddRoleRequest $request): response
    {
        $result = $this->roleService->addRole($request);
        return response()->json($result, 200);
    }

    public function updateRole(UpdateRoleRequest $request, int $id): response
    {
        $result = $this->roleService->updateRole($request, $id);
        return response()->json($result, 200);
    }

    public function getPermissionsOfRole(int $roleId): response
    {
        $result = $this->roleService->getPermissionsOfRole($roleId);
        return response()->json($result, 200);
    }
}
