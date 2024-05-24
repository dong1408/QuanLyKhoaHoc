<?php

namespace App\Exceptions\ToChuc;

use App\Utilities\ResponseError;
use Exception;


class DeleteToChucException extends Exception
{
    public function render($request)
    {
        return response()->json(
            new ResponseError(
                "BAD REQUEST",
                400,
                "Tổ chức này đang được nguồn dữ liệu khác sử dụng!"
            ),
            400
        );
    }
}
