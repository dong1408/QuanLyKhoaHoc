<?php

namespace App\Exceptions\DeTai;

use App\Utilities\ResponseError;
use Exception;


class DeTaiNotHaveChuNhiemException extends Exception
{
    public function render($request)
    {
        return response()->json(
            new ResponseError(
                "BAD REQUEST",
                400,
                "Đề tài phải có ít nhất 1 tác giả đảm nhiệm vai trò chủ nhiệm đề tài"
            ),
            400
        );
    }
}
