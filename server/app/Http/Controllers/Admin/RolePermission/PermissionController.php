<?php

namespace App\Http\Controllers\Admin\RolePermission;

use App\Http\Controllers\Controller;
use App\Http\Requests\RolePermission\AddPermissionRequest;
use App\Http\Requests\RolePermission\UpdatePermissionRequest;
use App\Service\RolePermission\PermissionService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionController extends Controller
{

    private PermissionService $permissionService;
    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
        $this->middleware('auth:api');
    }

    public function getAllPermission(): Response
    {
        $result = $this->permissionService->getAllPermission();
        return response()->json($result, 200);
    }

    public function addPermission(AddPermissionRequest $request): Response
    {
        $result = $this->permissionService->addPermission($request);
        return response()->json($result, 200);
    }


    public function udpatePermission(UpdatePermissionRequest $request, int $id): Response
    {
        $result = $this->permissionService->udpatePermission($request, $id);
        return response()->json($result, 200);
    }
}
