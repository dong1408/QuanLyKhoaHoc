<?php

namespace App\Exceptions\BaiBao;

use App\Utilities\ResponseError;
use Exception;


class BaiBaoCanNotUpdateException extends Exception
{
    public function render($request)
    {
        return response()->json(
            new ResponseError(
                "BAD REQUEST",
                400,
                "Bài báo đang trong trạng thái xóa mềm nên không thể chỉnh sửa thông tin"
            ),
            404
        );
    }
}
