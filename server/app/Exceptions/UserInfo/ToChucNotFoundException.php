<?php

namespace App\Exceptions\UserInfo;

use App\Utilities\ResponseError;
use Exception;


class ToChucNotFoundException extends Exception
{
    public function render($request)
    {
        return response()->json(
            new ResponseError(
                "NOT FOUND",
                404,
                "Không tìm thấy tổ chức"
            ),
            404
        );
    }
}
