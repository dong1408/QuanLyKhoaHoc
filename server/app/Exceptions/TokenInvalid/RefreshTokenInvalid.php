<?php

namespace App\Exceptions\TokenInvalid;

use App\Custom\StatusText;
use App\Utilities\ResponseError;
use Exception;
use Illuminate\Http\Request;
use Throwable;

class RefreshTokenInvalid extends Exception
{
    public function render($request)
    {
        return response()->json(
            new ResponseError(
                "BAD REQUEST",
                401,
                "Phiên đăng nhập hết hạn"
            ),
            400
        );
    }
}