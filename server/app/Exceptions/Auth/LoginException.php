<?php

namespace App\Exceptions\Auth;

use App\Utilities\ResponseError;
use Exception;
use Illuminate\Http\Request;
use Throwable;

class LoginException extends Exception 
{
    public function render($request)
    {
        return response()->json(
            new ResponseError(
                "NOT FOUND",
                404,
                "Sai tài khoản mật khẩu"
            ),
            404
        );
    }
}
