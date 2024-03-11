<?php

namespace App\Service\User;

use App\Models\User;
use App\Utilities\Convert;
use App\Utilities\ResponseSuccess;
use Illuminate\Http\Request;

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
}
