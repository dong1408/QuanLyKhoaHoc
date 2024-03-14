<?php

namespace App\Service\RolePermission;

use App\Exceptions\RolePermission\PermissionNotFoundException;
use App\Http\Requests\RolePermission\AddPermissionRequest;
use App\Http\Requests\RolePermission\UpdatePermissionRequest;
use App\Models\Permission;
use App\Utilities\Convert;
use App\Utilities\ResponseSuccess;
use Illuminate\Http\Request;

class PermissionServiceImpl implements PermissionService
{
    public function getAllPermission(): ResponseSuccess
    {
        $permissionsBySlug = Permission::all()->groupBy(function ($permission) {
            return explode('.', $permission->slug)[0];
        });
        $result = Convert::getPermissionsBySlugVm($permissionsBySlug);
        return new ResponseSuccess("Thành công", $result);
    }


    public function addPermission(AddPermissionRequest $request): ResponseSuccess
    {
        $validated = $request->validated();

        $permission = Permission::create(
            [
                'name' => $validated['name'],
                'slug' => $validated['slug'],
                'description' => $validated['description']
            ]
        );

        return new ResponseSuccess("Thành công", true);
    }


    public function udpatePermission(UpdatePermissionRequest $request, int $id): ResponseSuccess
    {
        $permissionId = (int)$id;
        $permission = Permission::find($permissionId);
        if ($permission == null) {
            throw new PermissionNotFoundException();
        }
        $validated = $request->validated();

        $permission->name = $validated['name'];
        $permission->slug = $validated['slug'];
        $permission->description = $validated['description'];
        $permission->save();

        return new ResponseSuccess("Thành công", true);
    }
}
