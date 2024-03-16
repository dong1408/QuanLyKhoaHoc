<?php

namespace App\Exceptions\User;

use App\Utilities\ResponseError;
use Exception;
use Illuminate\Http\Request;
use Throwable;

class  NotAllowDeleteSelfException extends Exception
{
    public function render($request)
    {
        return response()->json(
            new ResponseError(
                "BAD REQUEST",
                400,
                "Không được phép xóa tài khoản của chính mình!"
            ),
            400
        );
    }
}
