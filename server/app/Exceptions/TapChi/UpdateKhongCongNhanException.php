<?php

namespace App\Exceptions\TapChi;

use App\Utilities\ResponseError;
use Exception;


class UpdateKhongCongNhanException extends Exception
{
    public function render($request)
    {
        return response()->json(
            new ResponseError(
                "BAD REQUEST",
                400,
                "Trạng thái trước khi cập nhật và sau khi cập nhật giống nhau"
            ),
            404
        );
    }
}
