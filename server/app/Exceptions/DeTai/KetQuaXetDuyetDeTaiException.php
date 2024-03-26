<?php

namespace App\Exceptions\DeTai;

use App\Utilities\ResponseError;
use Exception;


class KetQuaXetDuyetDeTaiException extends Exception
{
    public function render($request)
    {
        return response()->json(
            new ResponseError(
                "BAD REQUEST",
                400,
                "Kết quả xét duyệt của đề tài phải là đủ điều kiện"
            ),
            400
        );
    }
}
