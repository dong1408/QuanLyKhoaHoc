<?php

namespace App\Exceptions\TapChi;

use App\Utilities\ResponseError;
use Exception;


class NameTapChiUsedException extends Exception
{
    public function render($request)
    {
        return response()->json(
            new ResponseError(
                "BAD_REQUEST",
                400,
                "Tên tạp chí này đã tồn tại trong hệ thống"
            ),
            400
        );
    }
}
