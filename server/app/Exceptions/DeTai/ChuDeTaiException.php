<?php

namespace App\Exceptions\DeTai;

use App\Utilities\ResponseError;
use Exception;


class ChuDeTaiException extends Exception
{
    public function render($request)
    {
        return response()->json(
            new ResponseError(
                "BAD REQUEST",
                400,
                "Bạn không phải là người kê khai của đề tài này"
            ),
            400
        );
    }
}
