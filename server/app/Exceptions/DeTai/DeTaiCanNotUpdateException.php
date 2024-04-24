<?php

namespace App\Exceptions\DeTai;

use App\Utilities\ResponseError;
use Exception;


class DeTaiCanNotUpdateException extends Exception
{
    public function render($request)
    {
        return response()->json(
            new ResponseError(
                "BAD REQUEST",
                400,
                "Đề tài đang trong trạng thái xóa mềm nên không thể chỉnh sửa thông tin"
            ),
            400
        );
    }
}
