<?php

namespace App\Exceptions\TapChi;

use App\Utilities\ResponseError;
use Exception;


class DeleteTapChiException extends Exception
{
    public function render($request)
    {
        return response()->json(
            new ResponseError(
                "BAD_REQUEST",
                400,
                "Tạp chí này đang được nguồn dữ liệu khác sử dụng!"
            ),
            400
        );
    }
}
