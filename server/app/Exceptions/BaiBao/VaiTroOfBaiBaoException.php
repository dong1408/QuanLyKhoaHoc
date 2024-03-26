<?php

namespace App\Exceptions\BaiBao;

use App\Utilities\ResponseError;
use Exception;


class VaiTroOfBaiBaoException extends Exception
{
    public function render($request)
    {
        return response()->json(
            new ResponseError(
                "BAD REQUEST",
                400,
                "Các vai trò tác giả phải thuộc vai trò tác giả của bài báo"
            ),
            400
        );
    }
}
