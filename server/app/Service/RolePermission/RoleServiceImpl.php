<?php

namespace App\Service\RolePermission;

use App\Exceptions\RolePermission\RoleNotFoundException;
use App\Http\Requests\RolePermission\AddRoleRequest;
use App\Http\Requests\RolePermission\UpdateRoleRequest;
use App\Models\Role;
use App\Utilities\Convert;
use App\Utilities\ResponseSuccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class RoleServiceImpl implements RoleService
{
    public function getAllRole(): ResponseSuccess
    {
        $roles = Role::all();
        $result = [];
        foreach ($roles as $role) {
            $result[] = Convert::getRoleVm($role);
        }
        return new ResponseSuccess("Thành công", $result);
    }


    public function addRole(AddRoleRequest $request): ResponseSuccess
    {
        $validated = $request->validated();
        $role = Role::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'mavaitro' => $validated['mavaitro']
        ]);

        $role->permissions()->attach($validated['permission_id']);  // add
        $result = Convert::getRoleVm($role);
        return new ResponseSuccess("Thành công", $result);
    }

    public function updateRole(UpdateRoleRequest $request, int $id): ResponseSuccess
    {
        $roleId = (int)$id;
        $role = Role::find($roleId);
        if ($role == null) {
            throw new RoleNotFoundException();
        }
        $validated = $request->validated();
        DB::transaction(function () use ($validated, &$role) {
            $role->name = $validated['name'];
            $role->description = $validated['description'];
            $role->mavaitro = $validated['mavaitro'];
            $role->save();
            $role->permissions()->sync($validated['permission_id']);
        });
        $result = Convert::getRoleVm($role);
        return new ResponseSuccess("Thành công", $result);
    }

    public function getPermissionsOfRole(int $roleId): ResponseSuccess
    {
        $roleId = (int)$roleId;
        $role = Role::find($roleId);
        if ($role == null) {
            throw new RoleNotFoundException();
        }
        $result = Convert::getRoleDeTailVm($role);
        return new ResponseSuccess("Thành công", $result);
    }

}
