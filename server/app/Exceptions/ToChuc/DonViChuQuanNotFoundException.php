<?php

namespace App\Exceptions\ToChuc;

use App\Utilities\ResponseError;
use Exception;


class DonViChuQuanNotFoundException extends Exception
{
    public function render($request)
    {
        return response()->json(
            new ResponseError(
                "NOT FOUND",
                404,
                "Không tìm thấy đơn vị chủ quản"
            ),
            404
        );
    }
}
