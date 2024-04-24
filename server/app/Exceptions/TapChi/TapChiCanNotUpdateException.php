<?php

namespace App\Exceptions\TapChi;

use App\Utilities\ResponseError;
use Exception;


class TapChiCanNotUpdateException extends Exception
{
    public function render($request)
    {
        return response()->json(
            new ResponseError(
                "BAD_REQUEST",
                400,
                "Tạp chí đang trong trạng thái xóa mềm nên không thể thực hiện việc cập nhật"
            ),
            400
        );
    }
}
