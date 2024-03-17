<?php

namespace App\Exceptions\User;

use App\Utilities\ResponseError;
use Exception;
use Illuminate\Http\Request;
use Throwable;

class  NotAllowUpdateRoleSelfException extends Exception
{
    public function render($request)
    {
        return response()->json(
            new ResponseError(
                "BAD REQUEST",
                400,
                "Không được chỉnh sửa vai trò của chỉnh mình!"
            ),
            400
        );
    }
}
