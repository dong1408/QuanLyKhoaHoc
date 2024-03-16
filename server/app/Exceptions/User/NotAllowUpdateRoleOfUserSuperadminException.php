<?php

namespace App\Exceptions\User;

use App\Utilities\ResponseError;
use Exception;
use Illuminate\Http\Request;
use Throwable;

class  NotAllowUpdateRoleOfUserSuperadminException extends Exception
{
    public function render($request)
    {
        return response()->json(
            new ResponseError(
                "BAD REQUEST",
                400,
                "Không được phép chỉnh sửa quyền của người dùng là super admin!"
            ),
            400
        );
    }
}
