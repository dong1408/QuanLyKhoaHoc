<?php

namespace App\Exceptions\UserInfo;

use App\Utilities\ResponseError;
use Exception;


class TinhThanhNotFoundException extends Exception
{
    public function render($request)
    {
        return response()->json(
            new ResponseError(
                "NOT FOUND",
                404,
                "Không tìm thấy tình thành"
            ),
            404
        );
    }
}
