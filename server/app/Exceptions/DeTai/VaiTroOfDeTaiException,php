<?php

namespace App\Exceptions\DeTai;

use App\Utilities\ResponseError;
use Exception;


class VaiTroOfDeTaiException extends Exception
{
    public function render($request)
    {
        return response()->json(
            new ResponseError(
                "BAD REQUEST",
                400,
                "Các vai trò tác giả phải thuộc vai trò tác giả của đề tài"
            ),
            404
        );
    }
}
