<?php

namespace App\Exceptions\BaiBao;

use App\Utilities\ResponseError;
use Exception;


class ChuBaiBaoException extends Exception
{
    public function render($request)
    {
        return response()->json(
            new ResponseError(
                "BAD REQUEST",
                400,
                "Bạn không phải là người kê khai của bài báo này"
            ),
            400
        );
    }
}
