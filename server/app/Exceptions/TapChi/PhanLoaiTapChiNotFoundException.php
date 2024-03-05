<?php

namespace App\Exceptions\TapChi;

use App\Utilities\ResponseError;
use Exception;


class PhanLoaiTapChiNotFoundException extends Exception
{
    public function render($request)
    {
        return response()->json(
            new ResponseError(
                "NOT FOUND",
                404,
                "Không tìm thấy phân loại tạp chí"
            ),
            404
        );
    }
}
