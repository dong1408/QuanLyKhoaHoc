<?php

namespace App\Exceptions\RolePermission;

use App\Utilities\ResponseError;
use Exception;


class PermissionNotFoundException extends Exception
{
    public function render($request)
    {
        return response()->json(
            new ResponseError(
                "NOT FOUND",
                404,
                "Không tìm thấy quyền này trong hệ thống"
            ),
            404
        );
    }
}
