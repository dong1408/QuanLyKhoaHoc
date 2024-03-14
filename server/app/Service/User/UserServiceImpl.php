<?php

namespace App\Service\User;

use App\Exceptions\InvalidValueException;
use App\Exceptions\User\UserNotFoundException;
use App\Exceptions\User\UserNotHavePermissionException;
use App\Http\Requests\User\RegisterUserRequest;
use App\Http\Requests\User\UpdateRoleOfUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use App\Utilities\Convert;
use App\Utilities\PagingResponse;
use App\Utilities\ResponseSuccess;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class UserServiceImpl implements UserService
{

    public function getAllUser(Request $request): ResponseSuccess
    {
        $keysearch = $request->query('search', "");

        $result = [];
        $users = User::where('name', 'LIKE', '%' . $keysearch . '%')
            ->orWhere('username', 'LIKE', '%' . $keysearch . '%')->get();
        foreach ($users as $user) {
            $result[] = Convert::getUserVm($user);
        }
        return new ResponseSuccess("Thành công", $result);
    }




    public function getUserPaging(Request $request): ResponseSuccess
    {
        $page = $request->query('page', 1);
        $keysearch = $request->query('search', "");
        $sortby = $request->query('sortby', "created_at");
        $isLock = $request->query('isLock', 0);
        $users = null;
        if ($isLock == 1) {
            $users = User::onlyTrashed()->where(function ($query) use ($keysearch) {
                $query->where('username', 'LIKE', '%' . $keysearch . '%')
                    ->orwhere('name', 'LIKE', '%' . $keysearch . '%')
                    ->orwhere('email', 'LIKE', '%' . $keysearch . '%');
            })->orderBy($sortby, 'desc')->paginate(env('PAGE_SIZE'), ['*'], 'page', $page);
        } else {
            $users = User::where(function ($query) use ($keysearch) {
                $query->where('username', 'LIKE', '%' . $keysearch . '%')
                    ->orwhere('name', 'LIKE', '%' . $keysearch . '%')
                    ->orwhere('email', 'LIKE', '%' . $keysearch . '%');
            })->orderBy($sortby, 'desc')->paginate(env('PAGE_SIZE'), ['*'], 'page', $page);
        }
        $result = [];
        foreach ($users as $user) {
            $result[] = Convert::getUserVm($user);
        }
        $pagingResponse = new PagingResponse($users->lastPage(), $users->total(), $result);
        return new ResponseSuccess("Thành công", $pagingResponse);
    }


    public function getRoleOfUser(): ResponseSuccess
    {
        $user = auth('api')->user();
        $rolesOfUser = $user->roles;
        $result = [];
        foreach ($rolesOfUser as $role) {
            $result[] = Convert::getRoleVm($role);
        }
        return new ResponseSuccess("Thành công", $result);
    }


    public function getPermissionOfUser(): ResponseSuccess
    {
        $user = auth('api')->user();
        $rolesOfUser = $user->roles;
        $result = [];
        foreach ($rolesOfUser as $role) {
            foreach ($role->permissions as $permission) {
                $result[] = Convert::getPermissionVm($permission);
            }
        }
        return new ResponseSuccess("Thành công", $result);
    }




    public function getUserDetail(int $id): ResponseSuccess
    {
        $userId = (int) $id;
        if (!is_int($userId)) {
            throw new InvalidValueException();
        }
        $user = User::withTrashed()->find($userId);
        if ($user == null) {
            throw new UserNotFoundException();
        }
        $result = Convert::getUserDetailVm($user);
        return new ResponseSuccess("Thành công", $result);
    }





    public function registerUser(RegisterUserRequest $request): ResponseSuccess
    {
        $validated = $request->validated();
        $user = new User();
        DB::transaction(function () use ($validated, &$user) {
            $user = User::create([
                'name' => $validated['name'],
                'username' => $validated['username'],
                'email' => $validated['email'],
                'password' => Hash::make(env('SGU_2024')),
                'role' => $validated['role'],
                'changed' => 0,
                'ngaysinh' => $validated['ngaysinh'],
                'dienthoai' => $validated['dienthoai'],
                'email2' => $validated['email2'],
                'orchid' => $validated['orchid'],
                'id_tochuc' => $validated['id_tochuc'],
                'id_donvi' => $validated['id_donvi'],
                'cohuu' => $validated['cohuu'],
                'keodai' => $validated['keodai'],
                'dinhmucnghiavunckh' => $validated['dinhmucnghiavunckh'],
                'dangdihoc' => $validated['dangdihoc'],
                'id_noihoc' => $validated['id_noihoc'],
                'id_ngachvienchuc' => $validated['id_ngachvienchuc'],
                'id_quoctich' => $validated['id_quoctich'],
                'id_hochamhocvi' => $validated['id_hochamhocvi'],
                'id_chuyenmon' => $validated['id_chuyenmon'],
                'id_nganhtinhdiem' => $validated['id_nganhtinhdiem'],
                'id_chuyennganhtinhdiem' => $validated['id_chuyennganhtinhdiem']
            ]);
            $user->roles()->attach($validated['roles_id']);
        });

        $result = Convert::getUserDetailVm($user);
        return new ResponseSuccess("Thành công", $result);
    }

    public function updateUser(UpdateUserRequest $request, int $id): ResponseSuccess
    {
        $userId = (int)$id;
        if (!is_int($userId)) {
            throw new InvalidValueException();
        }
        $user = User::where('id', $userId)->first();
        if ($user == null) {
            throw new UserNotFoundException();
        }
        $validated = $request->validated();
        DB::transaction(function () use ($validated, &$user) {
            $user->name = $validated['name'];
            $user->username = $validated['username'];
            $user->email = $validated['email'];
            $user->role = $validated['role'];
            $user->ngaysinh = $validated['ngaysinh'];
            $user->dienthoai = $validated['dienthoai'];
            $user->email2 = $validated['email2'];
            $user->orchid = $validated['orchid'];
            $user->id_tochuc = $validated['id_tochuc'];
            $user->id_donvi = $validated['id_donvi'];
            $user->cohuu = $validated['cohuu'];
            $user->keodai = $validated['keodai'];
            $user->dinhmucnghiavunckh = $validated['dinhmucnghiavunckh'];
            $user->dangdihoc = $validated['dangdihoc'];
            $user->id_noihoc = $validated['id_noihoc'];
            $user->id_ngachvienchuc = $validated['id_ngachvienchuc'];
            $user->id_quoctich = $validated['id_quoctich'];
            $user->id_hochamhocvi = $validated['id_hochamhocvi'];
            $user->id_chuyenmon = $validated['id_chuyenmon'];
            $user->id_nganhtinhdiem = $validated['id_nganhtinhdiem'];
            $user->id_chuyennganhtinhdiem = $validated['id_chuyennganhtinhdiem'];
            $user->save();
        });
        $result = Convert::getUserDetailVm($user);
        return new ResponseSuccess("Thành công", $result);
    }

    public function updateRoleOfUser(UpdateRoleOfUserRequest $request, int $id): ResponseSuccess
    {
        $userId = (int) $id;
        if (!is_int($userId)) {
            throw new InvalidValueException();
        }
        $user = User::find($userId);
        if ($user == null) {
            throw new UserNotFoundException();
        }
        $validated = $request->validated();
        $user->roles()->sync($validated['roles_id']);
        return new ResponseSuccess("Thành công", true);
    }


    public function deleteUser(int $id): ResponseSuccess
    {
        $userId = (int) $id;
        if (!is_int($userId)) {
            throw new InvalidValueException();
        }
        $user = User::find($userId);
        if ($user == null) {
            throw new UserNotFoundException();
        }
        $user->delete();
        return new ResponseSuccess("Thành công", true);
    }

    public function restoreUser(int $id): ResponseSuccess
    {
        $userId = (int) $id;
        if (!is_int($userId)) {
            throw new InvalidValueException();
        }
        $user = User::onlyTrashed()->find($userId);
        if ($user == null) {
            throw new UserNotFoundException();
        }
        User::onlyTrashed()->where('id', $userId)->restore();
        return new ResponseSuccess("Thành công", true);
    }

    public function forceDeleteUser(int $id): ResponseSuccess
    {
        $userId = (int) $id;
        if (!is_int($userId)) {
            throw new InvalidValueException();
        }
        $user = User::onlyTrashed()->find($userId);
        if ($user == null) {
            throw new UserNotFoundException();
        }
        User::onlyTrashed()->where('id', $userId)->forceDelete();
        return new ResponseSuccess("Thành công", true);
    }
}
