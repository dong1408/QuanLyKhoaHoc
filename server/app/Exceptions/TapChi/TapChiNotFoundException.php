<?php

namespace App\Exceptions\TapChi;

use App\Utilities\ResponseError;
use Exception;


class TapChiNotFoundException extends Exception
{
    public function render($request)
    {
        return response()->json(
            new ResponseError(
                "NOT FOUND",
                404,
                "Không tìm thấy tạp chí"
            ),
            404
        );
    }
}
