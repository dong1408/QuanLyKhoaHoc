<?php

namespace App\Exceptions\BaiBao;

use App\Utilities\ResponseError;
use Exception;


class PermissionUpdateTacGiaException extends Exception
{
    public function render($request)
    {
        return response()->json(
            new ResponseError(
                "BAD REQUEST",
                400,
                "Bài báo đã được xác nhận, bạn không có quyền chỉnh sửa thông tin tác giả!"
            ),
            400
        );
    }
}
