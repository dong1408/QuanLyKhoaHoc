<?php

namespace App\Exceptions\QuyDoi;

use App\Utilities\ResponseError;
use Exception;


class NganhTinhDiemNotFoundException extends Exception
{
    public function render($request)
    {
        return response()->json(
            new ResponseError(
                "NOT FOUND",
                404,
                "Không tìm thấy ngành tính điểm"
            ),
            404
        );
    }
}
