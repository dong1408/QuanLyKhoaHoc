<?php

namespace App\Service\User;

use App\Exceptions\InvalidValueException;
use App\Exceptions\User\NotAllowDeleteSelfException;
use App\Exceptions\User\NotAllowDeleteUserIsSuperadminException;
use App\Exceptions\User\NotAllowUpdateRoleOfUserSuperadminException;
use App\Exceptions\User\NotAllowUpdateRoleSelfException;
use App\Exceptions\User\PasswordIncorrectException;
use App\Exceptions\User\UserNotFoundException;
use App\Exceptions\User\UserNotHavePermissionException;
use App\Http\Requests\User\ChangePasswordRequest;
use App\Http\Requests\User\RegisterUserRequest;
use App\Http\Requests\User\UpdateRoleOfUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use App\Service\Excel\ExcelService;
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

    private ExcelService $excelService;

    public function __construct(ExcelService $excelService)
    {
        $this->excelService = $excelService;
    }

    public function getAllUser(Request $request): ResponseSuccess
    {
        $keysearch = $request->query('search', "");
        $result = [];

        if (!empty($keysearch)) {
            $users = User::where('name', 'LIKE', '%' . $keysearch . '%')
                ->orWhere('username', 'LIKE', '%' . $keysearch . '%')->get();
            foreach ($users as $user) {
                $result[] = Convert::getUserSimpleVm($user);
            }
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




    public function getRoleOfUser(int $id): ResponseSuccess
    {
        $userId = (int) $id;
        if (!is_int($userId)) {
            throw new InvalidValueException();
        }

        $user = User::find($userId);
        if ($user == null) {
            throw new UserNotFoundException();
        }

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


    public function getUserInfo(): ResponseSuccess
    {
        $idUser = auth('api')->user()->id;
        $user = User::find($idUser);
        if ($user == null) {
            throw new UserNotFoundException();
        }
        $result = Convert::getUserInfoVm($user);
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
                //                'role' => $validated['role'],
                'changed' => 0,
                'ngaysinh' => $validated['ngaysinh'],
                'dienthoai' => $validated['dienthoai'],
                'email2' => $validated['email2'],
                'orchid' => $validated['orchid'],
                'id_tochuc' => $validated['id_tochuc'],
                'cohuu' => $validated['cohuu'],
                'keodai' => $validated['keodai'],
                'dinhmucnghiavunckh' => $validated['dinhmucnghiavunckh'],
                'dangdihoc' => $validated['dangdihoc'],
                'id_noihoc' => !empty($validated['dangdihoc']) ? $validated['id_noihoc'] : null,
                'id_ngachvienchuc' => $validated['id_ngachvienchuc'],
                'id_quoctich' => $validated['id_quoctich'],
                'id_hochamhocvi' => $validated['id_hochamhocvi'],
                'id_chuyenmon' => $validated['id_chuyenmon'],
                'id_nganhtinhdiem' => $validated['id_nganhtinhdiem'],
                'id_chuyennganhtinhdiem' => $validated['id_chuyennganhtinhdiem']
            ]);
            $user->roles()->attach($validated['roles_id']);
        });

        //        $result = Convert::getUserDetailVm($user);
        return new ResponseSuccess("Tạo người dùng thành công", true);
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
            // $user->username = $validated['username'];
            $user->email = $validated['email'];
            //            $user->role = $validated['role'];
            $user->ngaysinh = $validated['ngaysinh'];
            $user->dienthoai = $validated['dienthoai'];
            $user->email2 = $validated['email2'];
            $user->orchid = $validated['orchid'];
            $user->id_tochuc = $validated['id_tochuc'];
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
        return new ResponseSuccess("Cập nhật thông tin thành công", $result);
    }

    public function updateRoleOfUser(UpdateRoleOfUserRequest $request, int $id): ResponseSuccess
    {
        $userId = (int) $id;
        if (!is_int($userId)) {
            throw new InvalidValueException();
        }
        if ($id == auth('api')->user()->id) {
            throw new NotAllowUpdateRoleSelfException();
        }
        $user = User::find($userId);
        if ($user == null) {
            throw new UserNotFoundException();
        }
        $flag = false;
        foreach ($user->roles as $role) {
            if ($role->mavaitro == 'superadmin') {
                $flag = true;
            }
        }
        if ($flag == true) {
            throw new NotAllowUpdateRoleOfUserSuperadminException();
        }
        $validated = $request->validated();
        $user->roles()->sync($validated['roles_id']);

        $result = [];

        $roles = $user->roles()->get();
        foreach ($roles as $role) {
            $result[] = Convert::getRoleVm($role);
        }

        return new ResponseSuccess("Cập nhật vai trò thành công", $result);
    }


    public function deleteUser(int $id): ResponseSuccess
    {
        $userId = (int) $id;
        if (!is_int($userId)) {
            throw new InvalidValueException();
        }
        if ($id == auth('api')->user()->id) {
            throw new NotAllowDeleteSelfException();
        }
        $user = User::find($userId);
        if ($user == null) {
            throw new UserNotFoundException();
        }
        $flag = false;
        foreach ($user->roles as $role) {
            if ($role->mavaitro == 'superadmin') {
                $flag = true;
            }
        }
        if ($flag == true) {
            throw new NotAllowDeleteUserIsSuperadminException();
        }
        $user->delete();
        return new ResponseSuccess("Xóa người dùng thành công", true);
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
        return new ResponseSuccess("Hoàn tác thành công", true);
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
        return new ResponseSuccess("Xóa người dùng thành công", true);
    }


    public function changePassword(ChangePasswordRequest $request): ResponseSuccess
    {
        $userId = auth('api')->user()->id;
        $user = User::find($userId);
        if ($user == null) {
            throw new UserNotFoundException();
        }
        $validated = $request->validated();
        $currentPassword = $validated['passwordcurrent'];
        if (!Hash::check($currentPassword, $user->password)) {
            throw new PasswordIncorrectException();
        }
        $user->password = Hash::make($validated['password']);
        $user->changed = 1;
        $user->save();
        return new ResponseSuccess("Đổi mật khẩu thành công", true);
    }


    public function themTacGiaNgoai($array): User
    {
        $user = User::create([
            'username' => $array['username'],
            'password' => $array['password'],
            'name' => $array['name'],
            'ngaysinh' => $array['ngaysinh'],
            'dienthoai' => $array['dienthoai'],
            'email' => $array['email'],
            'id_hochamhocvi' => $array['id_hochamhocvi']
        ]);
        return $user;
    }


    public function import(Request $request)
    {
        return $this->excelService->import($request);
    }

    public function exportFileResult(Request $request)
    {
        return $this->excelService->exportFileResult($request);
    }

    public function export()
    {
        return $this->excelService->export();
    }
}
