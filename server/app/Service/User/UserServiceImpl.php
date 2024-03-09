<?php

namespace App\Service\User;

use App\Models\User;
use App\Utilities\Convert;
use App\Utilities\ResponseSuccess;

class UserServiceImpl implements UserService
{
    public function getAllUser(): ResponseSuccess
    {
        $result = [];
        $users = User::all();
        foreach ($users as $user) {
            $result[] = Convert::getUserVm($user);
        }
        return new ResponseSuccess("Thành công", $result);
    }
}
