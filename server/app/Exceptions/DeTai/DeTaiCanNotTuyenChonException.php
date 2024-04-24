<?php

namespace App\Exceptions\DeTai;

use App\Utilities\ResponseError;
use Exception;


class DeTaiCanNotTuyenChonException extends Exception
{
    public function render($request)
    {
        return response()->json(
            new ResponseError(
                "BAD REQUEST",
                400,
                "Đề tài đã được tuyển chọn hoặc xét duyệt hoặc nghiệm thu trước đó"
            ),
            400
        );
    }
}
