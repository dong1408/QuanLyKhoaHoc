<?php

namespace App\Exceptions\User;

use App\Custom\StatusText;
use App\Utilities\ResponseError;
use Exception;
use Illuminate\Http\Request;
use Throwable;

class UserNotFound extends Exception 
{
    public function render($request)
    {
        return response()->json(
            new ResponseError(
                "NOT FOUND",
                404,
                "Không tìm thấy người dùng"
            ),
            404
        );
    }
}
