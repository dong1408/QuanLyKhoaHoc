<?php

namespace App\Exceptions\UserInfo;

use App\Utilities\ResponseError;
use Exception;


class QuocGiaNotFoundException extends Exception
{
    public function render($request)
    {
        return response()->json(
            new ResponseError(
                "NOT FOUND",
                404,
                "Không tìm thấy quốc gia"
            ),
            404
        );
    }
}
