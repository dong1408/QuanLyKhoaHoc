<?php

namespace App\Exceptions\DeTai;

use App\Utilities\ResponseError;
use Exception;


class PermissionUpdateTacGiaDeTaiException extends Exception
{
    public function render($request)
    {
        return response()->json(
            new ResponseError(
                "BAD REQUEST",
                400,
                "Đề tài đã được xác nhận, bạn không có quyền chỉnh sửa thông tin tác giả!"
            ),
            400
        );
    }
}
